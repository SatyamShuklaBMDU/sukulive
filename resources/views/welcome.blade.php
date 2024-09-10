<!DOCTYPE html>
<html lang="en">

<head>
    <title>SukuLive - Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />
</head>

<body>
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid rounded" src="{{ asset('assets/img/Frame 312.jpg') }}" alt="Logo" />
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Login</h1>
                            <p class="account-subtitle"></p>
                            <form action="{{ route('login.custom') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input class="form-control" type="email" placeholder="Email" name="email"
                                        autofocus required />
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" type="password" name="password" required
                                        placeholder="Password" />
                                    @if ($errors->has('emailPassword'))
                                        <span class="text-danger">{{ $errors->first('emailPassword') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary w-100" type="submit">
                                        Login
                                    </button>
                                    {{-- <a href="{{ url('dashboard') }}" class="btn btn-primary w-100">Login</a> --}}
                                </div>
                            </form>
                            <div class="login-or">
                                <span class="or-line"></span>
                                <span class="span-or">or</span>
                            </div>
                            <div class="text-center dont-have">Don't have an account? <a
                                    href="{{ route('register-user') }}">Registration</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" type="95b95b8459ce8c14f90bc096-text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="95b95b8459ce8c14f90bc096-text/javascript"></script>
    <script src="{{ asset('assets/js/script.js') }}" type="95b95b8459ce8c14f90bc096-text/javascript"></script>
    <script src="{{ asset('cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}"
        data-cf-settings="95b95b8459ce8c14f90bc096-|49" defer></script>
</body>

</html>
