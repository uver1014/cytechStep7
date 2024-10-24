<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])

    
</head>

<body>
    <br>
    <div class="container">
        @yield('content')
    </div>
    

</body>

</html>