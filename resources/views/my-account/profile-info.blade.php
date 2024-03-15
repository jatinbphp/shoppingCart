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
                                    @include('common.label', ['field' => 'categories_id', 'labelText' => 'Which categories of products do you want to see?', 'isRequired' => false])

                                    {!! Form::select("categories_id[]", $categories, !empty($user_info['categories_id']) ? explode(",", $user_info['categories_id']) : null, ["class" => "form-control select2", "id" => "categories_id", "multiple" => "true", 'data-placeholder' => 'Please Select']) !!}
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    @include('common.label', ['field' => 'name', 'labelText' => 'Name', 'isRequired' => true])

                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}

                                    @include('common.errors', ['field' => 'name'])
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    @include('common.label', ['field' => 'email', 'labelText' => 'Email Address', 'isRequired' => true])

                                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email Address']) !!}

                                    @include('common.errors', ['field' => 'email'])
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    @include('common.label', ['field' => 'phone', 'labelText' => 'Phone Number', 'isRequired' => true])

                                    {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone Number']) !!}

                                    @include('common.errors', ['field' => 'phone'])
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    @include('common.label', ['field' => 'image', 'labelText' => 'Image', 'isRequired' => false])

                                    {!! Form::file('image', ['class' => 'form-control-file','onChange'=>'AjaxUploadImage(this)']) !!}

                                    @if(!empty($user_info['image']) && file_exists($user_info['image']))
                                        <img src="{{ asset($user_info['image']) }}" alt="User Image" style="border: 1px solid #ccc;margin-top: 5px;" width="150" id="DisplayImage">
                                    @else
                                        <img src="{{ url('assets/admin/dist/img/no-image.png') }}" alt="User Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
                                    @endif

                                    @include('common.errors', ['field' => 'image'])
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