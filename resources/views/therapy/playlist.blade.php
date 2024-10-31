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
    <style>
        .chat-container {
            position: fixed;
            right: 0;
            bottom: 0;
            width: 300px;
            max-height: 400px;
            background-color: #f0f2f5;
            border: 1px solid #ccc;
            border-radius: 8px 8px 0 0;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background-color: #0078ff;
            color: white;
            padding: 10px;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid #ccc;
            border-radius: 8px 8px 0 0;
        }

        .chat-box {
            flex-grow: 1;
            padding: 10px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .chat-message {
            max-width: 75%;
            padding: 8px 12px;
            border-radius: 15px;
            font-size: 0.9rem;
            color: #333;
        }

        .chat-message.user {
            background-color: #0078ff;
            color: white;
            align-self: flex-end;
            border-radius: 15px 15px 0 15px;
        }

        .chat-message.other {
            background-color: #e4e6eb;
            align-self: flex-start;
            border-radius: 15px 15px 15px 0;
        }

        .chat-input-container {
            display: flex;
            padding: 8px;
            border-top: 1px solid #ccc;
            background-color: #fff;
        }

        .chat-input {
            flex-grow: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 15px;
            outline: none;
            font-size: 0.9rem;
        }

        .send-btn {
            margin-left: 8px;
            background-color: #0078ff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .send-btn:hover {
            background-color: #005bb5;
        }
    .call-btn, .end-call-btn {
        background-color: #0078ff;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 5px;
    }

.end-call-btn {
    background-color: #ff4d4d;
}

.call-btn:hover, .end-call-btn:hover {
    opacity: 0.8;
}

    </style>
</head>

<body>

    <div id="smp_container" class="smp"></div>


    <div class="chat-container">
        <div class="chat-header">
            Session Chat
            <button onclick="startCall()" class="call-btn">Start Call</button>
            <button onclick="endCall()" class="end-call-btn" style="display:none;">End Call</button>
        </div>

        <div id="chat-box" class="chat-box">
        </div>
        <div class="chat-input-container">
            <input type="text" id="chat-message" class="chat-input" placeholder="Type your message here..."
                onkeydown="if(event.key === 'Enter') sendMessage()">
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

    const iceServers = {
        iceServers: [{
                urls: 'stun:stun.l.google.com:19302'
            }
        ]
    };

    async function startCall() {
        localStream = await navigator.mediaDevices.getUserMedia({
            audio: true
        });
        document.querySelector('.call-btn').style.display = 'none';
        document.querySelector('.end-call-btn').style.display = 'inline';
        socket.emit('start-call');
        initializePeerConnection();
    }

    function initializePeerConnection() {
        peerConnection = new RTCPeerConnection(iceServers);

        localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

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
        peerConnection.setRemoteDescription(new RTCSessionDescription(offer));
        peerConnection.createAnswer()
            .then(answer => peerConnection.setLocalDescription(answer))
            .then(() => socket.emit('answer', peerConnection.localDescription));
    });

    socket.on('answer', (answer) => {
        peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
    });

    socket.on('ice-candidate', (candidate) => {
        peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
    });

    function endCall() {
        document.querySelector('.end-call-btn').style.display = 'none';
        document.querySelector('.call-btn').style.display = 'inline';

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
    socket.on('end-call', () => {
        endCall();
    });
</script>

</html>
