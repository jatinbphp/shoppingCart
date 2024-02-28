@extends('layouts.app')

@section('content')
<section class="">
    <div class="container">
        <div class="row align-items-start justify-content-between">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
                <form class="border p-3 rounded" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label>{{ __('Email Address') }} :<span class="text-danger">*</span></label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Email Address') }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>{{ __('Password') }} :<span class="text-danger">*</span></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="flex-1">
                                <input id="dd" class="checkbox-custom" name="dd" type="checkbox">
                                <label for="dd" class="checkbox-custom-label">{{ __('Remember Me') }}</label>
                            </div>
                            <div class="eltio_k2">
                                <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">
                            {{ __('Login') }}
                        </button>
                    </div>

                    <!-- @if (Route::has('register'))
                        <div class="row mb-3">
                            <div class="col-xl-12">
                                <div class="form-group mb-3">
                                    <p>If you no have an account with us, please register at the <a href="{{ route('register') }}">{{ __('Register') }} here</a>.</p>
                                </div>
                            </div>
                        </div>
                    @endif -->
                </form>
            </div>
        </div>
    </div>
</section>
@endsection