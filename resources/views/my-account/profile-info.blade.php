@extends('layouts.app')

@section('content')
    @include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'Profile Info']])

    <section class="middle">
        <div class="container">

            @include ('common.error')
            
            <div class="row align-items-start justify-content-between">
                @include('my-account.dashboard-menu', ['menu' => 'profile-info'])

                <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                    <div class="row align-items-center">

                        {!! Form::model($user_info,['url' => route('user.profile.update'),'method'=>'post','id' => 'profile-form','class' => 'row m-0','files'=>true]) !!}

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('categories_id', 'Which categories of products do you want to see?', ['class' => 'small text-dark ft-medium']) !!}

                                    {!! Form::select("categories_id[]", $categories, !empty($user_info['categories_id']) ? explode(",", $user_info['categories_id']) : null, ["class" => "form-control select2", "id" => "categories_id", "multiple" => "true", 'data-placeholder' => 'Please Select']) !!}

                                    @if ($errors->has('categories_id'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('categories_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name *', ['class' => 'small text-dark ft-medium']) !!}

                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}

                                    @if ($errors->has('name'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('email', 'Email ID *', ['class' => 'small text-dark ft-medium']) !!}

                                    {!! Form::text('email', null, ['class' => 'form-control']) !!}

                                    @if ($errors->has('email'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- Add validation for other fields similarly -->

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('password', 'Password', ['class' => 'small text-dark ft-medium']) !!}

                                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}

                                    @if ($errors->has('password'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'small text-dark ft-medium']) !!}

                                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) !!}

                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="alert alert-success">
                                    <h4><i class="fa fa-info"></i> Note:</h4>
                                    <p>Leave Password and Confirm Password empty if you are not going to change the password.</p>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('image', 'Image ', ['class' => 'small text-dark ft-medium']) !!}

                                    {!! Form::file('image', ['class' => 'form-control-file','onChange'=>'AjaxUploadImage(this)']) !!}

                                    @if(!empty($user_info['image']) && file_exists($user_info['image']))
                                        <img src="{{ asset($user_info['image']) }}" alt="User Image" style="border: 1px solid #ccc;margin-top: 5px;" width="150" id="DisplayImage">
                                    @else
                                        <img src="{{ url('assets/admin/dist/img/no-image.png') }}" alt="User Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
                                    @endif

                                    @if ($errors->has('image'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::submit('Save Changes', ['id' => 'submit-profile-form', 'class' => 'btn btn-dark']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
