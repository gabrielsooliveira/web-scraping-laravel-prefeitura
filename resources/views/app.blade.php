<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Web Scrapping</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @include('layouts.navbar')
        @yield('content')
        @stack('scripts')
    </body>
</html>
