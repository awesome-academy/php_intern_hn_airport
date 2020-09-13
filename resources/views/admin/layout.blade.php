<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
        href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/fonts/ionicons.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/AdminLTE/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/summernote/summernote-bs4.css') }}">
    <link href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/fonts/fonts.css') }}" rel="stylesheet">
    <link rel="stylesheet" 
        href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/flag-icon-css/css/flag-icon.min.css') }}">

    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/jquery-ui/jquery-ui.min.js') }}">
    </script>
    <script
        src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/jquery-knob/jquery.knob.min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/moment/moment.min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/daterangepicker/daterangepicker.js') }}">
    </script>
    <script
        src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <script
        src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/dist/js/demo.js') }}"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">{{ trans('contents.admin.home') }}</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    @switch (Lang::locale())
                        @case (config('constance.lang.en'))
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="flag-icon flag-icon-us"></i>
                            </a>
                            @break
                        @case (config('constance.lang.vi'))
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="flag-icon flag-icon-vn"></i>
                            </a>
                            @break
                        @default
                            @break
                    @endswitch
                    <div class="dropdown-menu dropdown-menu-right p-0">
                        <a href="{{ route('changeLanguage', config('constance.lang.en')) }}"
                            class="dropdown-item @if (Lang::locale() == config('constance.lang.en')) active @endif">
                            <i class="flag-icon flag-icon-us mr-2"></i>
                            {{ trans('contents.common.en') }}
                        </a>
                        <a href="{{ route('changeLanguage', config('constance.lang.vi')) }}"
                            class="dropdown-item @if (Lang::locale() == config('constance.lang.vi')) active @endif">
                            <i class="flag-icon flag-icon-vn mr-2"></i>
                            {{ trans('contents.common.vi') }}
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <form action="{{ route('admin.postLogout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-default"><i class="fas fa-sign-out-alt"></i></button>
                    </form>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('bower_components/bower_localdriver/AdminLTE/dist/img/AdminLTELogo.png') }}"
                    alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ trans('contents.admin.title') }}</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset(config('constance.anonymous_user')) }}" class="img-circle elevation-2">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"></a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    {{ trans('contents.admin.dashboard') }}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    {{ trans('contents.admin.users') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ trans('contents.admin.agency') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ trans('contents.admin.host') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
</body>

</html>
