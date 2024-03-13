@extends('layouts.app')

@section('content')
<section class="">
    <div class="container">
        <div class="row align-items-start justify-content-between">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <h2 class="text-center">{{ __('Forgot Password') }}</h2>

                <form class="border p-3 rounded" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group">
                        <label>{{ __('Email Address') }} :<span class="text-danger">*</span></label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>

                    @if (Route::has('login'))
                        <div class="row mb-3">
                            <div class="col-xl-12">
                                <div class="form-group mb-3">
                                    <p>If you already have an account with us, please login at the <a href="{{ route('login') }}">{{ __('Login') }} here</a>.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
