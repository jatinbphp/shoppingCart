@extends('layouts.app')
@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'Shopping Cart']])
<section class="middle">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>Shopping Cart</h2>
                </div>
            </div>
        </div>
        @php
        $subTotal = 0;
        @endphp
        @if(count($cart_products)>0)
            <div class="row justify-content-between">
                <div class="col-12 col-lg-7 col-md-12">
                    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
                        @foreach($cart_products as $key => $value)
                            <li class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        <a target="_blank" href="{{route('products.details', [$value->product->id])}}">
                                            @if(!empty($value->product->product_image->image) && file_exists($value->product->product_image->image))
                                                <img class="img-fluid" src="{{url($value->product->product_image->image)}}" alt="...">
                                            @else 
                                                <img class="img-fluid" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col d-flex align-items-center justify-content-between">
                                        <div class="cart_single_caption pl-2">
                                            <h4 class="product_title fs-md ft-medium mb-2 lh-2">{{$value->product->product_name}}</h4>
                                            <p class="mb-2 lh-2">Qty: {{ env('CURRENCY') }}{{ number_format($value->product->price, 2) }} X {{$value->quantity}}</p>

                                            @if(!empty($value->product_options))
                                                @foreach($value->product_options as $keyO => $keyV)
                                                    @if($keyO=='COLOR')
                                                        <p class="mb-2 lh-2">
                                                            <span class="text-dark">{{$keyO}}: <i class="fas fa-square" style="color:  {{$keyV}}  "></i></span>
                                                        </p>
                                                    @else
                                                        <p class="mb-2 lh-2">
                                                            <span class="text-dark">{{$keyO}}: {{$keyV}}</span>
                                                        </p>
                                                    @endif
                                                @endforeach
                                            @endif

                                            <p class="mb-2 lh-1">Total: {{ env('CURRENCY') }}{{ number_format(($value->product->price*$value->quantity), 2) }}</p>

                                            <!-- @php
                                                $quantity = [];
                                                for ($i = 1; $i <= 10; $i++) {
                                                    $quantity[$i] = $i;
                                                }
                                            @endphp

                                            {{ Form::select('quantity', $quantity, $value->quantity, ['class' => 'mb-2 custom-select w-auto', 'id' => 'update-quantity', 'data-id' => $value->id, 'data-url' => route('cart.update-quantity')]) }} -->

                                        </div>
                                        <div class="fls_last">
                                            {!! Form::button('<i class="ti-close"></i>', [
                                                'class' => 'close_slide gray remove-cart',
                                                'data-id' => $value->product->id,
                                                'data-url' => route('cart.remove'),
                                                'data-type' => 'page-view'
                                            ]) !!}

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
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card mb-4 gray mfliud">
                        <div class="card-body">
                            <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">
                                        {{ env('CURRENCY') }}{{ number_format($subTotal, 2) }}
                                    </span>
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
                    <a class="btn btn-block btn-dark mb-3" href="{{route('checkout')}}">Proceed to Checkout</a>
                    <a class="btn-link text-dark ft-medium" href="{{route('products')}}">
                        <i class="ti-back-left mr-2"></i> Continue Shopping
                    </a>
                </div>
            </div>
        @else
            <div class="cart_single d-flex align-items-center text-center">
                <p>Your cart is empty.</p>
            </div>
        @endif
    </div>
</section>
@endsection