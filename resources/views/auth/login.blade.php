@extends('layouts.app')
@section('content')
<section class="">
    <div class="container">
        <div class="row align-items-start justify-content-between">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
                
                <h2 class="text-center">{{ __('Login') }}</h2>

                {!! Form::open(['route' => 'login', 'class' => 'border p-3 rounded']) !!}

                    <div class="form-group">
                        @include('common.label', ['field' => 'email', 'labelText' => 'Email Address', 'isRequired' => true])

                        {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => __('Email Address'), 'required', 'autocomplete' => 'email', 'autofocus']) }}

                        @include('common.errors', ['field' => 'email'])
                    </div>

                    <div class="form-group">
                        @include('common.label', ['field' => 'password', 'labelText' => 'Password', 'isRequired' => true])

                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('Password'), 'required', 'autocomplete' => 'current-password']) }}

                        @include('common.errors', ['field' => 'password'])
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
                        {{ Form::submit(__('Login'), ['class' => 'btn btn-md full-width bg-dark text-light fs-md ft-medium']) }}
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
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection