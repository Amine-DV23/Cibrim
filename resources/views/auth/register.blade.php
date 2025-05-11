@extends('layouts.app')

@section('content')
    <div class="login-container">
        <h1 class="gradient-text">My-Site</h1>

        <div class="login-card">
            <div class="card-header text-center">
                <h4>{{ __('  register In Acount') }}</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf


                    <input id="name" type="text" class="input-field @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="  name">
                    @error('name')
                        <span class="error-message" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror


                    <input id="email" type="email" class="input-field @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" placeholder=" email">
                    @error('email')
                        <span class="error-message" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror


                    <input id="password" type="password" class="input-field @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password" placeholder="password ">
                    @error('password')
                        <span class="error-message" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror


                    <input id="password-confirm" type="password" class="input-field" name="password_confirmation" required
                        autocomplete="new-password" placeholder=" confirm-password ">


                    <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">

                        <button type="submit" class="login-button"
                            style="padding: 10px 20px;  border: none; cursor: pointer;">
                            {{ __(' register ') }}
                        </button>

                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="login-button"
                                style="padding: 10px 20px; background-color: gray; color: white; text-decoration: none; display: inline-block; text-align: center; border: none;">
                                {{ __('login ') }}
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
            padding: 1rem;
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
            margin-bottom: 1.5rem;
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
            margin-bottom: 1.5rem;
            color: #fff;
            font-size: 1.25rem;
        }

        .input-field {
            padding: 0.75rem;
            margin-bottom: 1rem;
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
            margin-bottom: 1.5rem;
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
