@extends('layouts.app')
@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'Shopping Cart', 'Checkout']])
<section class="middle">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>
        @include ('common.error')
        {!! Form::open(['url' => route('checkout-order-placed'), 'id' => 'CheckoutForm', 'class' => 'form-horizontal','files'=>true]) !!}
            <div class="row justify-content-between">
                <div class="col-12 col-lg-7 col-md-12">
                    @include('checkout.delivery-address')

                    @include('checkout.delivery-method')
                </div>
                
                @if(count($cart_products)>0)
                    <div class="col-12 col-lg-5 col-md-12">
                        @include('checkout.cart-info')
                    </div>
                @endif
            </div>
        {!! Form::close() !!}
    </div>
</section>
@endsection