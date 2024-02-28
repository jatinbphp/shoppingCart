@extends('layouts.app')

@section('content')
<section class="">
    <div class="container">
        <div class="row align-items-start justify-content-between">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
                <!-- <div class="card-header">{{ __('Reset Password') }}</div> -->

                <form class="border p-3 rounded" method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label>{{ __('Email Address') }} :<span class="text-danger">*</span></label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>{{ __('Password') }} :<span class="text-danger">*</span></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>{{ __('Confirm Password') }} :<span class="text-danger">*</span></label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
