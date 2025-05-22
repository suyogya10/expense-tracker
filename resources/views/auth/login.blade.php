@extends('layouts.auth')
<style>
    .loader-circle {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        border: 3px solid white;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
        transform: translate(-50%, -50%);
    }

    @keyframes spin {
        to {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    .btn.animating {
        width: 50px !important;
        height: 50px !important;
        border-radius: 50% !important;
        padding: 0 !important;
        transition: all 0.4s ease-in-out;
        text-indent: -9999px;
        overflow: hidden;
    }
</style>

@section('main-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">{{ __('Login') }}</h1>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger border-left-danger" role="alert">
                                            <ul class="pl-4 my-2">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('login') }}" class="user">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="email"
                                                placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}"
                                                required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password"
                                                placeholder="{{ __('Password') }}" required>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="remember">{{ __('Remember Me') }}</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button id="loginBtn" type="submit"
                                                class="btn btn-primary btn-user btn-block position-relative overflow-hidden">
                                                <span class="btn-text">{{ __('Login') }}</span>
                                                <div class="loader-circle d-none"></div>
                                            </button>

                                        </div>

                                    </form>

                                    <hr>

                                    @if (Route::has('password.request'))
                                        <div class="text-center">
                                            <a class="small" href="{{ route('password.request') }}">
                                                {{ __('Forgot Password?') }}
                                            </a>
                                        </div>
                                    @endif

                                    @if (Route::has('register'))
                                        <div class="text-center">
                                            <a class="small"
                                                href="{{ route('register') }}">{{ __('Create an Account!') }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form.user");
            const btn = document.getElementById("loginBtn");
            const loader = btn.querySelector(".loader-circle");
            const btnText = btn.querySelector(".btn-text");

            form.addEventListener("submit", function() {
                btn.classList.add("animating");
                loader.classList.remove("d-none");
                btnText.classList.add("invisible");
            });

            @if ($errors->any())
                // Revert animation on validation failure
                btn.classList.remove("animating");
                loader.classList.add("d-none");
                btnText.classList.remove("invisible");
            @endif
        });
    </script>

@endsection
