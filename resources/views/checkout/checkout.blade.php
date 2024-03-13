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
        <div class="row justify-content-between">
            <div class="col-12 col-lg-7 col-md-12">
                {!! Form::open(['method' => 'post', 'id' => 'checkoutForm']) !!}

                    <h5 class="mb-4 ft-medium">Delivery Address</h5>
                    <div class="row mb-4">
                        <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                            <div class="panel-group pay_opy980" id="payaccordion">

                                @if(!empty($user_addresses))
                                    @foreach($user_addresses as $keyA => $address)
                                        <div class="panel panel-default border">
                                            <div class="panel-heading" id="pay">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" role="button" data-parent="#payaccordion" href="#address_{{ $address->id }}" aria-expanded="{{ $keyA == 0 ? 'true' : 'false' }}" aria-controls="address_{{ $address->id }}">
                                                        {{ $address->title }}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="address_{{$address->id}}" class="panel-collapse collapse {{ $keyA == 0 ? 'show' : '' }}" aria-labelledby="pay" data-parent="#payaccordion">
                                                <div class="panel-body">
                                                    <h5 class="ft-medium mb-1">
                                                        {{ $address->first_name}} {{$address->last_name}}
                                                    </h5>

                                                    <p>
                                                        @if (!empty($address->title))
                                                            {{ $address->title }}
                                                        @endif

                                                        @if (!empty($address->company))
                                                            <br>{{ $address->company }}
                                                        @endif

                                                        @if (!empty($address->address_line1))
                                                            <br>{{ $address->address_line1 }},
                                                        @endif

                                                        @if (!empty($address->address_line2))
                                                            <br>{{ $address->address_line2 }},
                                                        @endif

                                                        @if (!empty($address->city) || !empty($address->state) || !empty($address->country) || !empty($address->pincode))
                                                            <br>
                                                            @if (!empty($address->pincode)) {{ $address->pincode }} - @endif
                                                            @if (!empty($address->city)) {{ $address->city }}, @endif
                                                            @if (!empty($address->state)) {{ $address->state }}, @endif
                                                            @if (!empty($address->country)) {{ $address->country }} @endif
                                                        @endif
                                                    </p>

                                                    @if(!empty($address->mobile_phone))
                                                        <p>
                                                            <span class="text-dark ft-medium">Call:</span> 
                                                            <a href="tel:{{$address->mobile_phone}}">{{$address->mobile_phone}}</a><br>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="panel panel-default border">
                                    <div class="panel-heading" id="dabit">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#payaccordion" data-target="#add-new" aria-expanded="{{ empty($user_addresses) ? 'true' : 'false' }}"  aria-controls="add-new" >
                                                Add a New Address
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="add-new" class="panel-collapse collapse {{ empty($user_addresses) ? 'show' : '' }}" aria-labelledby="dabit" data-parent="#payaccordion">
                                        <div class="panel-body">
                                            @include ('my-addresses.form')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h5 class="mb-4 ft-medium">Delivery Method</h5>
                    <div class="row mb-4">
                        <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                            <div class="panel-group pay_opy980" id="payaccordion">
                                <div class="panel panel-default border">
                                    <div class="panel-heading" id="pay">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" role="button" data-parent="#payaccordion" href="#FEDEX" aria-expanded="true"  aria-controls="FEDEX" >
                                                Fedex
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="FEDEX" class="panel-collapse collapse show" aria-labelledby="pay" data-parent="#payaccordion">
                                        <div class="panel-body">
                                            <label class="text-dark">5 WORKING DAYS - {{env('CURRENCY').number_format(7.14, 2);}} (tax incl.)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default border">
                                    <div class="panel-heading" id="c_o_d">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#payaccordion" data-target="#COD" aria-expanded="false" aria-controls="COD" >
                                                Cash On Delivery
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="COD" class="panel-collapse collapse" aria-labelledby="c_o_d" data-parent="#payaccordion">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <label class="text-dark">5 WORKING DAYS - {{env('CURRENCY').number_format(7.14, 2);}} (tax incl.)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>

            @php
            $subTotal = 0;
            @endphp
            @if(!empty($cart_products))
            <div class="col-12 col-lg-4 col-md-12">
                <div class="d-block mb-3">
                    <h5 class="mb-4">Order Items ({{count($cart_products)}})</h5>
                    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
                        @foreach($cart_products as $key => $value)
                            <li class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        <a target="_blank" href="{{route('products.details', [$value->id])}}">
                                            @if(!empty($value->product->product_image->image) && file_exists($value->product->product_image->image))
                                                <img class="img-fluid" src="{{url($value->product->product_image->image)}}" alt="...">
                                            @else 
                                                <img class="img-fluid" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col d-flex align-items-center">
                                        <div class="cart_single_caption pl-2">
                                            <h4 class="product_title fs-md ft-medium mb-1 lh-1">
                                                {{$value->product->product_name}}
                                            </h4>

                                            <p class="mb-1 lh-1">
                                                <span class="text-dark"><b>Qty:</b> {{$value->quantity}} X {{ env('CURRENCY') }}{{ number_format($value->product->price, 2) }}</span>
                                            </p>

                                            @if(!empty($value->product_options))
                                                @foreach($value->product_options as $keyO => $keyV)
                                                    @if($keyO=='COLOR')
                                                        <p class="mb-1 lh-1">
                                                            <span class="text-dark"><b>{{$keyO}}:</b> <i class="fas fa-square" style="color:  {{$keyV}}  "></i></span>
                                                        </p>
                                                    @else
                                                        <p class="mb-1 lh-1">
                                                            <span class="text-dark"><b>{{$keyO}}:</b> {{$keyV}}</span>
                                                        </p>
                                                    @endif
                                                @endforeach
                                            @endif

                                            <h4 class="fs-md ft-medium mb-3 lh-1">
                                                {{ env('CURRENCY') }}{{ number_format(($value->product->price*$value->quantity), 2) }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @php
                            $subTotal = ($subTotal+($value->product->price*$value->quantity));
                            @endphp
                        @endforeach
                    </ul>
                </div>
                <div class="card mb-4 gray">
                    <div class="card-body">
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Subtotal</span> 
                                <span class="ml-auto text-dark ft-medium">{{ env('CURRENCY') }}{{ number_format($subTotal, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Total</span> <span class="ml-auto text-dark ft-medium">
                                    {{ env('CURRENCY') }}{{ number_format($subTotal, 2) }}
                                </span>
                            </li>
                            <li class="list-group-item fs-sm text-center">
                                Shipping cost calculated at Checkout *
                            </li>
                        </ul>
                    </div>
                </div>
                <a class="btn btn-block btn-dark mb-3" href="javascript:void(0)">Place Your Order</a>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection