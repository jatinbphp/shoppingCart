@extends('layouts.app')

@section('content')
    @include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'Profile Info']])

    <section class="middle">
        <div class="container">
            @if (session('success'))
                <div id="success-message" class="alert alert-success">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('success-message').style.display = 'none';
                    }, 2000); 
                </script>
            @endif

            <div class="row align-items-start justify-content-between">
                @include('my-account.dashboard-menu', ['menu' => 'profile-info'])

                <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                    <div class="row align-items-center">
                        {!! Form::open(['route' => 'user.profile.update', 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'profile-form', 'class' => 'row m-0']) !!}
                            @csrf

                            <div class="callout callout-danger">
                                <h4><i class="fa fa-info"></i> Note:</h4>
                                <p>Leave Password and Confirm Password empty if you are not going to change the password.</p>
                            </div>

                            {!! Form::hidden('id', $user->id) !!}

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name *', ['class' => 'small text-dark ft-medium']) !!}
                                    {!! Form::text('name', old('name', $user->name), ['class' => 'form-control']) !!}
                                    @if ($errors->has('name'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        <script>
                                            document.getElementById('name').value = ''; // Reset the input value
                                        </script>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('email', 'Email ID *', ['class' => 'small text-dark ft-medium']) !!}
                                    {!! Form::text('email', old('email', $user->email), ['class' => 'form-control']) !!}
                                    @if ($errors->has('email'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        <script>
                                            document.getElementById('email').value = ''; // Reset the input value
                                        </script>
                                    @endif
                                </div>
                            </div>
                            <!-- Add validation for other fields similarly -->

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
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
                                    {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'control-label']) !!}
                                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) !!}
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('image', 'Image *', ['class' => 'small text-dark ft-medium']) !!}
                                    {!! Form::file('image', ['class' => 'form-control-file']) !!}
                                    @if(!empty($user['image']) && file_exists($user['image']))
                                        <img src="{{ asset($user['image']) }}" alt="User Image" style="border: 1px solid #ccc;margin-top: 5px;" width="150" id="DisplayImage">
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
