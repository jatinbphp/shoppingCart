@extends('layouts.app')

@section('content')
<section class="middle">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>Reset Password</h2>
                </div>
            </div>
        </div>
        <div class="row align-items-start justify-content-between">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
                {!! Form::open(['route' => 'password.update', 'class' => 'border p-3 rounded']) !!}
                    {{ Form::hidden('token', $token) }}
                    <div class="form-group">
                        @include('common.label', ['field' => 'email', 'labelText' => 'Email Address', 'isRequired' => true])

                        {{ Form::email('email', isset($email) ? $email : old('email'), ['id' => 'email', 'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'required' => true, 'autocomplete' => 'email', 'autofocus' => true]) }}

                        @include('common.errors', ['field' => 'email'])
                    </div>

                    <div class="form-group">
                        @include('common.label', ['field' => 'password', 'labelText' => 'Password', 'isRequired' => true])

                        {{ Form::password('password', ['id' => 'password', 'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'required' => true, 'autocomplete' => 'new-password']) }}

                        @include('common.errors', ['field' => 'password'])
                    </div>

                    <div class="form-group">
                        @include('common.label', ['field' => 'password_confirmation', 'labelText' => 'Confirm Password', 'isRequired' => true])

                        {{ Form::password('password_confirmation', ['id' => 'password-confirm', 'class' => 'form-control', 'required' => true, 'autocomplete' => 'new-password']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::submit(__('Reset Password'), ['class' => 'btn btn-md full-width bg-dark text-light fs-md ft-medium']) }}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection