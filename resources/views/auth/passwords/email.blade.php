@extends('layouts.app')
@section('content')
<section class="middle">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>Forgot Password</h2>
                </div>
            </div>
        </div>
        <div class="row align-items-start justify-content-between">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                {!! Form::open(['route' => 'password.email', 'class' => 'border p-3 rounded']) !!}
                    <div class="form-group">
                        @include('common.label', ['field' => 'email', 'labelText' => 'Email Address', 'isRequired' => true])

                        {{ Form::email('email', old('email'), ['id' => 'email', 'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'required' => true, 'autocomplete' => 'email', 'autofocus' => true ]) }}

                        @include('common.errors', ['field' => 'email'])
                    </div>

                    <div class="form-group">
                        {{ Form::submit(__('Send Password Reset Link'), ['class' => 'btn btn-md full-width bg-dark text-light fs-md ft-medium']) }}
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
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection