<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pet-Pal</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    {{-- <link rel="shortcut icon" href="img/fav.png"> --}}

</head>

<body>
    @include('layouts.header')
    @include('layouts.navbar')

    @yield('body')



</body>

</html>