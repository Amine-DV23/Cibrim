@extends('layouts.app')

@section('content')
    <div class="container" style="display: flex; justify-content: center; padding: 20px;">
        <div class="row justify-content-center" style="width: 100%; max-width: 450px;">
            <div class="col-md-12">
                <div class="card shadow-lg rounded-3">
                    <div class="card-header text-center" style="background-color: #4285F4; color: white; font-size: 1.5rem;">
                        <strong>{{ __('تسجيل الدخول') }}</strong>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Field -->
                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('البريد الإلكتروني') }}</label>
                                <div class="col-md-8">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('كلمة المرور') }}</label>
                                <div class="col-md-8">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Remember Me Checkbox -->
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">{{ __('تذكرني') }}</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="row mb-0">
                                <div class="col-md-12 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary w-48">
                                        {{ __('تسجيل الدخول') }}
                                    </button>

                                    @if (Route::has('register'))
                                        <a class="btn btn-secondary w-48" href="{{ route('register') }}">
                                            {{ __('تسجيل حساب') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
