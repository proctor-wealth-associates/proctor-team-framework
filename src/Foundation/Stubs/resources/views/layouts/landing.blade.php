<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Elegon') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('style')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<body id="landing" class="{{ isset($bodyClass) ? $bodyClass : '' }}">

    <!-- Sidebar Menu -->
    <div class="ui vertical inverted sidebar menu">
        @include('layouts.landing.menu-sidebar')
    </div>

    <div class="pusher">
        @include('layouts.landing.header')

        @yield('content')

        @include('layouts.landing.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/landing.js') }}"></script>
    @stack('script')
</body>
</html>
