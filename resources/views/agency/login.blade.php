<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('constance.title.title_agency_login') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet"
        href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/fonts/ionicons.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_localdriver/AdminLTE/dist/css/adminlte.min.css') }}">
    <link href="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/fonts/fonts.css') }}" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    @include('sweetalert::alert')
    <div class="login-box">
        <div class="login-logo">
            <a href="#">{{ trans('contents.agency.title') }}</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ trans('contents.common.form.signin') }}</p>

                <form action="{{ route('agency.postLogin') }}" method="post">
                    @csrf
                    @error('phone')
                        <label class="col-form-label"><i class="far fa-times-circle"></i>{{ $message }}</label>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                            placeholder="{{ trans('contents.common.form.phone') }}" name="phone">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    @error('password')
                        <label class="col-form-label"><i class="far fa-times-circle"></i>{{ $message }}</label>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="{{ trans('contents.common.form.password') }}" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    {{ trans('contents.common.form.remember_me') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit"
                                class="btn btn-primary btn-block">{{ trans('contents.common.form.signin') }}</button>
                        </div>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="#">{{ trans('contents.common.form.forget_password') }}</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('agency.signup.index') }}"
                        class="text-center">{{ trans('contents.common.register') }}</a>
                </p>
            </div>
        </div>
    </div>

    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script
        src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_localdriver/AdminLTE/dist/js/adminlte.js') }}"></script>

</body>

</html>
