<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="4b5515616bd4cb5b0618737c-text/javascript"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('include.head')
    @yield('style-area')
</head>

<body>
    <div class="main-wrapper">
        @include('include.header')

        @include('include.sidebar')

        @yield('content-area')
    </div>
    @include('include.foot')
    @yield('script-area')
</body>
</html>
