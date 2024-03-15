@extends('layouts.app')
@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'Add Address']])
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
            @include ('common.dashboard-menu', ['menu' => 'addresses'])

            <div class="col-12 col-md-12 col-lg-8 col-xl-8">

                {!! Form::open(['url' => route('addresses.store'), 'id' => 'userAddressForm', 'class' => 'form-horizontal','files'=>true]) !!}

                <div class="row">
                    <div class="col-12 col-lg-12 col-xl-12 col-md-12 mb-3">
                        <h4 class="ft-medium fs-lg">Add New Address</h4>
                    </div>
                </div>

                @include ('my-addresses.form')
                
                {!! Form::submit('Save', ['class' => 'btn btn-dark full-width']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection