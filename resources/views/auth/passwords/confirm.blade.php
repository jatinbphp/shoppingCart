@extends('layouts.app')

@section('content')
<section class="">
    <div class="container">
        <div class="row align-items-start justify-content-between">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
                
                <h2 class="text-center">{{ __('Confirm Password') }}</h2>

                {{ __('Please confirm your password before continuing.') }}

                <form class="border p-3 rounded" method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="form-group">
                        <label>{{ __('Email Address') }} :<span class="text-danger">*</span></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">
                            {{ __('Confirm Password') }}
                        </button>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="row mb-3">
                            <div class="col-xl-12">
                                <div class="form-group mb-3">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
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
