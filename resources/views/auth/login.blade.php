@extends('layouts.app')

@section('content')
    <div class="login-container">
        <h1 class="gradient-text">My-Site</h1>
        <div class="login-card">
            <div class="login-title">
                <h4>{{ __('  login In Acount ') }}</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf


                    <input id="email" type="email" class="input-field @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email ">
                    @error('email')
                        <div class="error-message"><strong>{{ $message }}</strong></div>
                    @enderror


                    <input id="password" type="password" class="input-field @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password" placeholder="current-password ">
                    @error('password')
                        <div class="error-message"><strong>{{ $message }}</strong></div>
                    @enderror


                    <div style="margin-bottom: 15px;">
                        <label style="color: white;">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            {{ __('remember') }}
                        </label>
                    </div>


                    <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                        <button type="submit" class="login-button">{{ __(' login') }}</button>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="login-button"
                                style="background-color: gray; text-decoration: none; display: inline-block; text-align: center; padding: 10px 20px;">
                                {{ __('register ') }}
                            </a>
                        @endif
                    </div>


                </form>
            </div>
        </div>
    </div>
    <style>
        html {
            font-size: 16px;
        }

        .login-container {
            background-color: #0c0c0c;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h1.gradient-text {
            font-size: 5.5rem;
            font-weight: bold;
            background: linear-gradient(270deg, blue, rgb(131, 96, 245), lightblue, rgb(131, 96, 245), blue);
            background-size: 600% 100%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: waveColors 10s ease-in-out infinite;
            text-align: center;
        }

        @keyframes waveColors {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .login-card {
            background-color: #1e1e1e;
            padding: 1.5rem;
            border-radius: 0.75rem;
            width: 100%;
            max-width: 22rem;
            text-align: center;
        }

        .login-title {
            margin-bottom: 30px;
            color: #fff;
            font-size: 1.25rem;
        }

        .input-field {
            padding: 12px;
            margin-bottom: 15px;
            width: 100%;
            border-radius: 0.5rem;
            border: 1px solid #444;
            background-color: #333;
            color: #fff;
            outline: none;
            font-size: 0.9rem;
        }

        .login-button {
            padding: 0.75rem 1.5rem;
            background-color: #27b70a;
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
            width: 100%;
            font-size: 0.95rem;
        }

        .error-message {
            color: red;
            margin-top: 0.75rem;
            font-size: 0.8rem;
        }


        @media (max-width: 600px) {
            h1.gradient-text {
                font-size: 2rem;
            }

            .login-card {
                padding: 1rem;
            }

            .input-field {
                font-size: 0.85rem;
            }

            .login-button {
                font-size: 0.9rem;
            }
        }
    </style>
@endsection
