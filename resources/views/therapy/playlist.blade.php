<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Simple Music Player</title>
    <link rel="stylesheet" href="{{ asset('assets/css/music.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/music2.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div id="smp_container" class="smp"></div>


</body>
<script>
    let fetchTherapiesUrl = "{{ route('fetch-therapies') }}";
    let getpeaksTherapiesUrl = "{{ route('get-peaks') }}";
    let savepeaksTherapiesUrl = "{{ route('save-peaks') }}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/music.js') }}"></script>
<script src="{{ asset('assets/js/music2.js') }}"></script>
</html>
