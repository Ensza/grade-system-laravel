<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/js/app.js', 'resources/css/app.css'])
        <title>{{ $title ?? 'Page Title' }}</title>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    </head>
    <body class="bg-slate-300">
        {{ $slot }}
    </body>
</html>
