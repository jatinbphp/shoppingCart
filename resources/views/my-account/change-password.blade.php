@extends('layouts.app')

@section('content')
    @include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'Profile Info']])

    <section class="middle">
        <div class="container">

            @include ('common.error')
            
            <div class="row align-items-start justify-content-between">
                @include('common.dashboard-menu', ['menu' => 'change-password'])
                
                <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                    <div class="row align-items-center">
                        {!! Form::open(['route' => 'change.password.update', 'method' => 'post', 'class' => 'row m-0']) !!}

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('current_password', 'Current Password :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>

                                    {!! Form::password('current_password', ['class' => 'form-control', 'placeholder' => 'Current Password']) !!}
                                    @error('current_password')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('password', 'New Password :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>

                                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'New Password']) !!}
                                    @error('password')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('password_confirmation', 'Confirm Password :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>

                                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) !!}
                                    @error('password_confirmation')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::submit('Save Changes', ['class' => 'btn btn-dark']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection