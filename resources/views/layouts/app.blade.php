<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if(Route::current()->getname() == 'ranglijst.index')
        <meta http-equiv="refresh" content="300">
    @endif
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NK Carcassonne') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>    
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!--fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('img/favicon')}}/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('img/favicon')}}/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('img/favicon')}}/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon')}}/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('img/favicon')}}/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('img/favicon')}}/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('img/favicon')}}/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('img/favicon')}}/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/favicon')}}/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('img/favicon')}}/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('img/favicon')}}/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('img/favicon')}}/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/favicon')}}/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    {{--Samantha--}}
    <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>-->

</head>


<body style="background:url({{ asset('img/carcassonne-blue-pattern.png')}})">
    <div id="app">
        
        @include('inc.navbar')

        <main class="py-4">
            <div class="container scroll-top" style="background:url({{ asset('img/perkament-pattern-top.png')}})"></div>
            <div class="container scroll" style="background:url({{ asset('img/perkament-pattern.png')}})">
            @include('inc.messages')
                @yield('content')
            </div>
            <div class="container scroll-bot" style="background:url({{ asset('img/perkament-pattern-bottom.png')}})"></div>
        </main>
    </div>
</body>
</html>
