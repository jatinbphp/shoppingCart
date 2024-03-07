@extends('layouts.app')

@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'Wishlist']])

<section class="middle">
    <div class="container">
        <div class="row justify-content-center justify-content-between">

            @include ('my-account.dashboard-menu', ['menu' => 'wishlists'])
        
            @if(!empty($wishlists))
                <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                    <div class="row align-items-center">
                        @foreach($wishlists as $key => $value)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                <div class="product_grid card b-0">
                                    <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                    <button class="btn btn_love position-absolute ab-right theme-cl text-danger"><i class="fas fa-times"></i></button>
                                    <div class="card-body p-0">
                                        <div class="shop_thumb position-relative">
                                            <a class="card-img-top d-block overflow-hidden" href="{{route('products.details', [$value->product->id])}}">
                                                @if(!empty($value->product->product_image->image) && file_exists($value->product->product_image->image))
                                                    <img class="card-img-top" src="{{url($value->product->product_image->image)}}" alt="...">
                                                @endif
                                            </a>

                                            <div class="edlio">
                                                <a href="javascript:void(0)" id="quickview" class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center text-white fs-sm ft-medium" data-id="{{$value->product->id}}" data-url="{{route('products.quickview', [$value->product->id])}}">
                                                    <i class="fas fa-eye mr-1"></i>Quick View
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                        <div class="text-left">
                                            <div class="text-center">
                                                <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1">
                                                    <a href="product-detail.html">{{$value->product->product_name}}</a>
                                                </h5>

                                                <div class="elis_rty"><span class="ft-bold fs-md text-dark">{{ env('CURRENCY') }}{{ number_format($value->product->price, 2) }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 text-center pt-4 pb-4 text-center">
                            <a href="#" class="btn stretched-link borders m-auto"><i class="lni lni-reload mr-2"></i>Load More</a>
                        </div>
                    </div>
                </div>
            @else 
                <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                    <div class="row align-items-center">
                        <p>Your wishlist is empty.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection