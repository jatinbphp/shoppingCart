@extends('layouts.app')

@section('content')
    @include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'Profile Info']])

    <section class="middle">
        <div class="container">

            @include ('common.error')
            
            <div class="row align-items-start justify-content-between">
                @include('common.dashboard-menu', ['menu' => 'profile-info'])

                <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                    <div class="row align-items-center">

                        {!! Form::model($user_info,['url' => route('profile-info-update'),'method'=>'post','id' => 'profile-form','class' => 'row m-0','files'=>true]) !!}

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('categories_id', 'Which categories of products do you want to see? :', ['class' => 'text-dark ft-medium']) !!}

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
                                    {!! Form::label('name', 'Name :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>

                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}

                                    @if ($errors->has('name'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('email', 'Email Address :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>

                                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email Address']) !!}

                                    @if ($errors->has('email'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('phone', 'Phone Number :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>

                                    {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone Number']) !!}

                                    @if ($errors->has('phone'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('image', 'Image :', ['class' => 'text-dark ft-medium']) !!}

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