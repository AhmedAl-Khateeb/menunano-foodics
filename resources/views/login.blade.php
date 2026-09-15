<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} | Log in</title>

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/login.css') }}">

   
</head>

<body>

    <div class="login-container">

        <!-- Brand -->
        <div class="brand">

            <span class="brand-icon">
                <i class="fas fa-utensils"></i>
            </span>

            <span class="brand-name">
                Menu<span>Nano</span>
            </span>

        </div>


        <!-- Login Card -->
        <div class="login-card">

            <!-- Heading -->
            <h1 class="login-title">
                Welcome Back
            </h1>

            <p class="login-subtitle">
                Sign in to your account to continue
            </p>


            <!-- Login Errors -->
            @if ($errors->has('login'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $errors->first('login') }}
                </div>
            @endif


            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST">

                @csrf


                <!-- Email -->
                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <div class="input-wrapper">

                        <i class="far fa-envelope input-icon"></i>

                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email"
                            autocomplete="email" required>

                    </div>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <!-- Password -->
                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="input-wrapper">

                        <i class="fas fa-lock input-icon"></i>

                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter your password" autocomplete="current-password" required>

                        <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password">
                            <i class="far fa-eye"></i>
                        </button>

                    </div>

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <!-- Login Button -->
                <button type="submit" class="login-button">

                    <i class="fas fa-sign-in-alt mr-2"></i>

                    Sign In

                </button>

            </form>


            <!-- Footer -->
            <div class="login-footer">

                © {{ date('Y') }}
                {{ \App\Models\Setting::where('key', 'name')->first()->value ?? 'MenuNano' }}.
                All rights reserved.

            </div>

        </div>

    </div>


    <!-- Password Toggle -->
    <script src="{{ asset('dist/js/login.js') }}"></script>

</body>

</html>
