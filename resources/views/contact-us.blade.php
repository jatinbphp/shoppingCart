@extends('layouts.app')

@section('content')

<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="middle">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Contact Us</h2>
                    <h3 class="ft-bold pt-3">Get In Touch</h3>
                </div>
                @include ('common.error')
            </div>
        </div>
        <div class="row align-items-start justify-content-between">
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="card-wrap-body mb-4">
                    <h4 class="ft-medium mb-3 theme-cl">Store Address</h4>
                    <p>{{get_settings()['address']}}</p>
                </div>
                <div class="card-wrap-body mb-3">
                    <h4 class="ft-medium mb-3 theme-cl">Make a Call</h4>
                    <h6 class="ft-medium mb-1">Customer Care:</h6>
                    <p class="mb-2">{{get_settings()['phone_number']}}</p>
                    <h6 class="ft-medium mb-1">Careers:</h6>
                    <p>{{get_settings()['phone_number']}}</p>
                </div>
                <div class="card-wrap-body mb-3">
                    <h4 class="ft-medium mb-3 theme-cl">Drop A Mail</h4>
                    <p>Fill out our form and we will contact you within 24 hours.</p>
                    <p class="lh-1 text-dark">{{get_settings()['email_address']}}</p>
                </div>
            </div>
            <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">
                {!! Form::open(['url' => route('contact.form.submit'), 'id' => 'ContactForm', 'class' => 'form-horizontal','files'=>true]) !!}
                    @csrf
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="small text-dark ft-medium">Your Name *</label>
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Your Name', 'id' => 'name']) !!}
                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="small text-dark ft-medium">Your Email *</label>
                            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Your Email', 'id' => 'email']) !!}
                            @if ($errors->has('email'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="small text-dark ft-medium">Subject *</label>
                            {!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => 'Type Your Subject', 'id' => 'subject']) !!}
                            @if ($errors->has('subject'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('subject') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="small text-dark ft-medium">Message *</label>
                            {!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => 'Type Your Message', 'id' => 'message']) !!}
                            @if ($errors->has('message'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
