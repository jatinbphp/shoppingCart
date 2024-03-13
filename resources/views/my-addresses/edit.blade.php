@extends('layouts.app')

@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'Edit Address']])

<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
            @include ('my-account.dashboard-menu', ['menu' => 'addresses'])

            <div class="col-12 col-md-12 col-lg-8 col-xl-8">

                {!! Form::model($address,['url' => route('addresses.update',['address'=>$address->id]),'method'=>'patch','id' => 'userAddressForm','class' => 'form-horizontal','files'=>true]) !!}
                
                <div class="row">
                    <div class="col-12 col-lg-12 col-xl-12 col-md-12 mb-3">
                        <h4 class="ft-medium fs-lg">Edit Address</h4>
                    </div>
                </div>

                @include ('my-addresses.form')
                
                {!! Form::submit('Update', ['class' => 'btn btn-dark full-width']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection
