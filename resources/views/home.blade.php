@extends('layouts.app')

@section('content')
<div class="home-slider margin-bottom-0">
    <div class="item" data-overlay="3" style="background-image: url('{{ isset($banner->image[0]) ? url($banner->image[0]) : "" }}');">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="home-slider-container">
                        <div class="home-slider-desc text-center">
                            <div class="home-slider-title mb-4">
                                <h5 class="fs-lg ft-ft-medium mb-0">{{ $banner->title ?? "" }}</h5>
                                <h1 class="mb-1 ft-bold lg-heading">{!! $banner->description ?? "" !!}</h1>
                                <span class="trending text-light">{{ $banner->subtitle ?? "" }}</span>
                            </div>
                            <a href="{{ route('products') }}" class="btn stretched-link light-borders ft-bold">Shop Now<i class="lni lni-arrow-right ml-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="item" data-overlay="3" style="background-image: url('{{ isset($banner->image[1]) ? url($banner->image[1]) : "" }}');">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="home-slider-container">
                        <div class="home-slider-desc text-center">
                            <div class="home-slider-title mb-4">
                                <h5 class="fs-lg ft-ft-medium mb-0">{{ $banner->title ?? "" }}</h5>
                                <h1 class="mb-1 ft-bold lg-heading">{!! $banner->description ?? "" !!}</h1>
                                <span class="trending text-light">{{ $banner->subtitle ?? "" }}</span>
                            </div>
                            <a href="{{ route('products') }}" class="btn stretched-link light-borders ft-bold">Shop Now<i class="lni lni-arrow-right ml-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="item" data-overlay="3" style="background-image: url('{{ isset($banner->image[2]) ? url($banner->image[2]) : "" }}');">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="home-slider-container">
                        <div class="home-slider-desc text-center">
                            <div class="home-slider-title mb-4">
                                <h5 class="fs-lg ft-ft-medium mb-0">{{ $banner->title ?? "" }}</h5>
                                <h1 class="mb-1 ft-bold lg-heading">{!! $banner->description ?? "" !!}</h1>
                                <span class="trending text-light">{{ $banner->subtitle ?? "" }}</span>
                            </div>
                            <a href="{{ route('products') }}" class="btn stretched-link light-borders ft-bold">Shop Now<i class="lni lni-arrow-right ml-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="middle">
    <div class="container">
        <div class="row no-gutters exlio_gutters">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="single_cats">
                    <a href="javaScript:;" class="cards card-overflow card-scale lg_height">
                        <div class="bg-image" style="background: url('{{url("assets/website/images/b-8.png")}}'); background-repeat:no-repeat;"></div>
                        <div class="ct_body">
                            <div class="ct_body_caption left">
                                <h2 class="m-0 ft-bold lh-1 fs-md text-upper">Women Clothes</h2>
                                <span>3272 Items</span>
                            </div>
                            <div class="ct_footer left">
                                <span class="stretched-link fs-md">Browse Items <i class="ti-arrow-circle-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="single_cats">
                    <a href="javaScript:;" class="cards card-overflow card-scale md_height">
                        <div class="bg-image" style="background: url('{{url("assets/website/images/b-5.pngs")}}'); background-repeat:no-repeat;"></div>
                        <div class="ct_body">
                            <div class="ct_body_caption left">
                                <h2 class="m-0 ft-bold lh-1 fs-md text-upper">Men's Wear</h2>
                                <span>7632 Items</span>
                            </div>
                            <div class="ct_footer left">
                                <span class="stretched-link fs-md">Browse Items <i class="ti-arrow-circle-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <!-- row -->
                <div class="row no-gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="single_cats">
                            <a href="javaScript:;" class="cards card-overflow card-scale md_height">
                                <div class="bg-image" style="background: url('{{url("assets/website/images/b-3.png")}}'); background-repeat:no-repeat;"></div>
                                <div class="ct_body">
                                    <div class="ct_body_caption left">
                                        <h2 class="m-0 ft-bold lh-1 fs-md text-upper">Kid's Wear</h2>
                                        <span>4072 Items</span>
                                    </div>
                                    <div class="ct_footer left">
                                        <span class="stretched-link fs-md">Browse Items <i class="ti-arrow-circle-right"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="single_cats">
                            <a href="javaScript:;" class="cards card-overflow card-scale lg_height">
                                <div class="bg-image" style="background: url('{{url("assets/website/images/b-7.png")}}'); background-repeat:no-repeat;"></div>
                                <div class="ct_body">
                                    <div class="ct_body_caption left">
                                        <h2 class="m-0 ft-bold lh-1 fs-md text-upper">Men's Jackets</h2>
                                        <span>9652 Items</span>
                                    </div>
                                    <div class="ct_footer left">
                                        <span class="stretched-link fs-md">Browse Items <i class="ti-arrow-circle-right"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Trendy Products</h2>
                    <h3 class="ft-bold pt-3">Our Trending Products</h3>
                </div>
            </div>
        </div>
        
        <div class="row align-items-center rows-products">
            @if(!empty($products))
                @foreach($products as $key => $value)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                            <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="{{route('products.details', [$value->id])}}">
                                        @if(!empty($value->product_image->image) && file_exists($value->product_image->image))
                                            <img class="card-img-top" src="{{url($value->product_image->image)}}" alt="...">
                                        @endif
                                    </a>
                                    <div class="edlio">
                                        <a href="javascript:void(0)" id="quickview" class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center text-white fs-sm ft-medium" data-id="{{$value->id}}" data-url="{{route('products.quickview', [$value->id])}}">
                                            <i class="fas fa-eye mr-1"></i>Quick View
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                <div class="text-left">
                                    <div class="text-center">
                                        <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single.html">{{$value->product_name}}</a></h5>
                                        <div class="elis_rty">
                                            <span class="ft-bold fs-md text-dark">
                                                {{ env('CURRENCY') }}{{ number_format($value->price, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="position-relative text-center">
                    <a href="{{ route('products') }}" class="btn stretched-link borders">Explore More<i class="lni lni-arrow-right ml-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-cover" data-overlay="5" style="background: url('{{url("assets/website/images/banner-3.jpg")}}'); background-repeat:no-repeat fixed;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9 col-md-12 col-sm-12">
                <div class="deals_wrap text-center">
                    <h4 class="ft-medium text-light">Get up to -40% Off</h4>
                    <h2 class="ft-bold text-light">Only Summer Collections</h2>
                    <p class="text-light">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.</p>
                    <div class="mt-5">
                        <a href="{{ route('products') }}" class="btn btn-white stretched-link">Start Shopping <i class="lni lni-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(!empty($category_products))
    <section>
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="myTab" role="tablist">
                        @foreach($category_products as $index => $category)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if($index === 0) active @endif" href="#category{{$index}}" data-toggle="tab" role="tab" aria-controls="category{{$index}}" aria-selected="@if($index === 0) true @else false @endif">{{$category->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        
                        @foreach($category_products as $index => $category)
                            <div class="tab-pane fade @if($index === 0) show active @endif" id="category{{$index}}" role="tabpanel" aria-labelledby="category{{$index}}-tab">
                                <div class="tab_product">
                                    <div class="row rows-products">
                                        @foreach($category->products as $product)
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                                <div class="product_grid card b-0">
                                                    <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                                    <button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                                    <div class="card-body p-0">
                                                        <div class="shop_thumb position-relative">
                                                            <a class="card-img-top d-block overflow-hidden" href="{{route('products.details', [$product->id])}}">
                                                                @if(!empty($product->product_image->image) && file_exists($product->product_image->image))
                                                                    <img class="card-img-top" src="{{url($product->product_image->image)}}" alt="...">
                                                                @endif
                                                            </a>
                                                            
                                                            <div class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center">
                                                                <div class="edlio">
                                                                    <a href="javascript:void(0)" id="quickview" class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center text-white fs-sm ft-medium" data-id="{{$product->id}}" data-url="{{route('products.quickview', [$product->id])}}">
                                                                        <i class="fas fa-eye mr-1"></i>Quick View
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                                        <div class="text-left">
                                                            <div class="text-center">
                                                                <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="shop-single.html">{{$value->product_name}}</a></h5>
                                                                <div class="elis_rty"><span class="ft-bold fs-md text-dark">{{ env('CURRENCY') }}{{ number_format($value->price, 2) }}</span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
@endsection