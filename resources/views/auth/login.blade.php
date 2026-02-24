<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-body">
    <div class="login-wrapper">
        <h2 class="login-title">Inicia Sesión</h2>
        
        <!-- Session Status -->
        @if (session('status'))
            <div class="login-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" />
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-group-checkbox">
                <label for="remember_me" class="checkbox-label">
                    <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                    <span class="checkbox-text">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="form-actions">
                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" class="submit-button">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</body>
</html>
