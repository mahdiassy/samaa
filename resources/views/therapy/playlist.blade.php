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
            body: JSON.stringify({ action: action, track: track })
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
</script>
</html>
