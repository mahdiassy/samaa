<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ٍSamaa Music Player</title>
    <link rel="stylesheet" href="{{ asset('assets/css/music.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/music2.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body>

    <div id="smp_container" class="smp"></div>


    <div class="chat-container">
        <div class="chat-header">
            Session Chat
            <button  id="startCallButton" class="call-btn">Start Call</button>
            <button  id="endCallButton"  onclick="endCall()" class="end-call-btn" style="display:none;">End Call</button>
        </div>

        <div id="chat-box" class="chat-box">
        </div>
        <div class="chat-input-container">
            <input type="text" id="chat-message" class="chat-input" placeholder="Type your message here..."
                onkeydown="if(event.key === 'Enter') sendMessage()"/>
            <button onclick="sendMessage()" class="send-btn">&#9658;</button>
        </div>
    </div>
</body>


<script>
    let fetchTherapiesUrl = "{{ route('fetch-therapies') }}";
    let getpeaksTherapiesUrl = "{{ route('get-peaks') }}";
    let savepeaksTherapiesUrl = "{{ route('save-peaks') }}";

    function controlMusic(action, track = 'new_track.mp3') {
        fetch('/control-music', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                action: action,
                track: track
            })
        });
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.min.js"></script>
<script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>

<script src="{{ asset('assets/js/music.js') }}"></script>
<script src="{{ asset('assets/js/music2.js') }}"></script>

<script>
    const echo = new Echo({
        broadcaster: 'socket.io',
        host: "https://test.clingroup.net"
    });


    function controlMusic(action, track = '') {
        echo.connector.socket.emit('music-control', {
            action: action,
            track: track
        });
    }

    echo.channel('music-channel')
        .listen('MusicControlEvent', (e) => {
            const musicPlayer = document.getElementById('musicPlayer');
            const trackSource = document.getElementById('trackSource');

            if (e.action === 'start') {
                musicPlayer.play();
            } else if (e.action === 'pause') {
                musicPlayer.pause();
            } else if (e.action === 'change') {
                trackSource.src = e.track;
                musicPlayer.load();
                musicPlayer.play();
            }
        });


    function sendMessage() {
        const message = document.getElementById('chat-message').value;
        if (message.trim() !== '') {
            socket.emit('chat-message', message);
            document.getElementById('chat-message').value = '';
        }
    }

    socket.on('chat-message', (data) => {
        const isUserMessage = data.sender === socket.id;
        appendMessage(data.message, isUserMessage ? 'user' : 'other');
    });

    function appendMessage(message, type) {
        const chatBox = document.getElementById('chat-box');
        const messageElement = document.createElement('div');
        messageElement.textContent = message;
        messageElement.classList.add('chat-message', type);
        chatBox.appendChild(messageElement);
        chatBox.scrollTop = chatBox.scrollHeight;
    }
</script>

<script>
    let localStream;
    let peerConnection;
    let audioContext;
    let callActive = false;


    const iceServers = {
        iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
    };


    document.getElementById("startCallButton").addEventListener("click", () => {
        if (!audioContext) {
            audioContext = new (window.AudioContext || window.webkitAudioContext)();
        }
        if (audioContext.state === "suspended") {
            audioContext.resume().then(() => {
                console.log("AudioContext is resumed.");
                startCall();
            });
        } else {
            startCall();
        }
    });


    async function startCall() {
        try {

            localStream = await navigator.mediaDevices.getUserMedia({ audio: true });
            showEndCallButton();
            callActive = true;

            socket.emit('start-call');
            initializePeerConnection();
        } catch (error) {
            console.error("Failed to access audio stream:", error);
            alert("Could not access audio. Please check permissions.");
        }
    }


    function initializePeerConnection() {
        peerConnection = new RTCPeerConnection(iceServers);


        if (localStream) {
            localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));
        } else {
            console.error("Local stream is not initialized.");
            return;
        }

        peerConnection.onicecandidate = (event) => {
            if (event.candidate) {
                socket.emit('ice-candidate', event.candidate);
            }
        };


        peerConnection.ontrack = (event) => {
            const remoteAudio = new Audio();
            remoteAudio.srcObject = event.streams[0];
            remoteAudio.play();
        };


        peerConnection.createOffer()
            .then(offer => peerConnection.setLocalDescription(offer))
            .then(() => socket.emit('offer', peerConnection.localDescription));
    }


    socket.on('offer', (offer) => {
        if (!peerConnection) initializePeerConnection();
        peerConnection.setRemoteDescription(new RTCSessionDescription(offer))
            .then(() => peerConnection.createAnswer())
            .then(answer => peerConnection.setLocalDescription(answer))
            .then(() => socket.emit('answer', peerConnection.localDescription));
    });

    socket.on('answer', (answer) => {
        peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
    });


    socket.on('ice-candidate', (candidate) => {
        peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
    });


    socket.on('end-call', () => {
        if (callActive) {
            alert("The call has been ended by the other user.");
            endCall();
        }
    });


    socket.on('resume-call', (data) => {
        if (data.isActive) {
            alert("A call is currently active. Rejoining the call...");
            startCall();
        }
    });


    function endCall() {
        hideEndCallButton();
        callActive = false;

        if (peerConnection) {
            peerConnection.close();
            peerConnection = null;
        }
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
            localStream = null;
        }

        socket.emit('end-call');
    }


    function showEndCallButton() {
        document.getElementById('startCallButton').style.display = 'none';
        document.getElementById('endCallButton').style.display = 'inline';
    }

    function hideEndCallButton() {
        document.getElementById('endCallButton').style.display = 'none';
        document.getElementById('startCallButton').style.display = 'inline';
    }
</script>

</html>
