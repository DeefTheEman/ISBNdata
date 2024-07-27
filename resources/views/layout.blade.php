<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
    <title>TESTapp</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.jpg') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
    @yield('content')
</html>