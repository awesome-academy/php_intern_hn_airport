<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/fav.png">
    <meta name="author" content="codepixer">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/carrental/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/carrental/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/carrental/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/carrental/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/carrental/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/carrental/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/carrental/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/carrental/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/carrental/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/carrental/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/web.css') }}">
</head>

<body>
    <header id="header" id="home">
        <div class="container">
            <div class="row align-items-center justify-content-between d-flex">
                <div id="logo">
                    <img src=" {{asset('bower_components/bower_localdriver/carrental/img/logo.png') }}" alt="" title="" />
                </div>
                <nav id="nav-menu-container">
                    <ul class="nav-menu">
                       <li><a href="#" class="genric-btn default circle">{{ trans('contents.common.form.login') }}</a></li>
                       <li><a href="#" class="genric-btn default circle">{{ trans('contents.common.form.register') }}</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    @yield('content')

    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/easing.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/hoverIntent.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/superfish.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/parallax.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/mail-script.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/carrental/js/main.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/jquery/src/popper.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/jquery/src/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/web.js') }}"></script>
</body>

</html>
