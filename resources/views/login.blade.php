<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} | Log in</title>

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;

            background: url('{{ asset('bg/MenuNano.png') }}') no-repeat center center fixed;
            background-size: cover;

            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            font-family: 'Source Sans Pro', sans-serif;
        }

        .login-box {
            width: 100%;
            max-width: 420px;

            background: rgba(255, 255, 255, 0.88);

            border-radius: 15px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);

            padding: 30px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-logo b {
            font-size: 30px;
            color: #2c3e50;
        }

        .card {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        .card-body {
            padding: 0;
        }

        .login-box-msg {
            text-align: center;
            font-size: 17px;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 25px;
        }

        .form-control {
            height: 45px;
            border-radius: 10px;
            border: 1px solid #dcdde1;
            background-color: #f5f6fa;
            padding-left: 15px;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.15rem rgba(52, 152, 219, 0.25);
            background-color: #fff;
        }

        .btn-primary {
            height: 45px;
            border-radius: 10px;
            background-color: #3498db;
            border: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .alert {
            border-radius: 10px;
        }

        .invalid-feedback {
            display: block;
        }

        @media (max-width: 576px) {
            .login-box {
                margin: 20px;
                padding: 25px;
            }

            .login-logo b {
                font-size: 24px;
            }
        }
    </style>
</head>

<body class="hold-transition login-page">

    <div class="login-box">

        <div class="login-logo">
            <b>
                {{ \App\Models\Setting::where('key', 'name')->first()->value }}
            </b>
        </div>

        <div class="card">

            <div class="card-body login-card-body">

                @if ($errors->has('login'))
                    <div class="alert alert-danger">
                        {{ $errors->first('login') }}
                    </div>
                @endif

                <p class="login-box-msg">
                    Sign in to start your session
                </p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email"
                            required
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password"
                            required
                        >

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt mr-1"></i>
                            Sign In
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- AdminLTE -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

</body>

</html>