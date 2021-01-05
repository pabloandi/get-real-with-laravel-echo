<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>
            window.currentuser = @json(auth()->user())
        </script>
    </head>
    <body>
        <div class="container">
            <div id="app">
                {{ $slot }}
            </div>
        </div>
        <script src="/js/app.js"></script>
    </body>

</html>
