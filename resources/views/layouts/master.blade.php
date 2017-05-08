<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My App</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Style --}}
    <link rel="stylesheet" href="/css/app.css">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
    <body>
        <script>
            window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        </script>

        <div id="app">

        </div>
        <script src="//cardgames.local:6001/socket.io/socket.io.js"></script>
        <script src="/js/app.js"></script>
    </body>
</html>
