@extends('layouts.app')
@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'Shop', $product['categories'], $product['product_name']]])
<section class="middle">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <div class="quick_view_slide">
                    @if(!empty($product['product_images']))
                        @foreach($product['product_images'] as $keyImages => $valueImages)
                            @if(!empty($valueImages['image']) && file_exists($valueImages['image']))
                                <div class="single_view_slide">
                                    <img src="{{url($valueImages['image'])}}" class="img-fluid" alt="" />
                                </div>
                            @endif
                        @endforeach
                    @else 
                        <div class="single_view_slide">
                            <img class="img-fluid" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                <div class="prd_details pl-3">
                    <!-- <div class="prt_01 mb-1">
                        <span class="text-light bg-info rounded px-2 py-1">
                        </span>
                    </div> -->
                    <div class="prt_02 mb-3">
                        <h2 class="ft-bold mb-1">{{$product['product_name']}}</h2>

                        @if(!empty($product['categories']))
                            <div class="prt_04 mb-2">
                                <p class="align-items-center mb-0">
                                    <b class="pr-1">Categories : </b> {{$product['categories']}}
                                </p>
                            </div>
                        @endif

                        <div class="text-left">
                            <!-- @php
                                $average_rating = ($product['total_reviews'] > 0) ? $product['total_review_rating'] / $product['total_reviews'] : 0;
                                $filled_stars = round($average_rating);
                            @endphp
                            <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $filled_stars)
                                        <i class="fas fa-star filled"></i>
                                    @else
                                        <i class="fas fa-star"></i>
                                    @endif
                                @endfor
                                <a href="{{ route('reviews-list', ['productId' => $product->id]) }}"><span class="small">({{$product['total_reviews']}} Reviews)</span></a>
                            </div> -->
                            <div class="elis_rty">
                                <!-- <span class="ft-medium text-muted line-through fs-md mr-2">
                                    {{ env('CURRENCY') }}{{ number_format(($product['price']+100), 2) }}
                                </span> -->
                                <span class="ft-bold theme-cl fs-lg mr-2">
                                    {{ env('CURRENCY') }}{{ number_format($product['price'], 2) }}
                                </span>
                                <span class="ft-regular text-success bg-light-success py-1 px-2 fs-sm">In Stock</span>
                            </div>
                        </div>
                    </div>
                    <div class="prt_03 mb-4">
                        {!! substr($product['description'], 0, 300) !!}{{ strlen($product['description']) > 200 ? '...' : '' }}
                    </div>

                    {!! Form::open(['route' => 'cart.add-product', 'method' => 'post', 'id' => 'addProductToCartFormDetails']) !!}

                        {!! Form::hidden('product_id', $product['id']) !!}

                        @if(!empty($product['options']))
                            @foreach($product['options'] as $key => $value)
                                <div class="prt_04 mb-2">
                                    <p class="d-flex align-items-center mb-0 text-dark ft-medium">
                                        {{ucfirst(strtolower($value['option_name']))}}:
                                    </p>

                                    @if($value['option_name']!='COLOR')
                                        <div class="text-left pb-0 pt-2">
                                            @if(!empty($value['product_option_values']))
                                                @foreach($value['product_option_values'] as $keyOption => $valueOption)
                                                    <div class="form-check size-option form-option form-check-inline mb-2">
                                                        <input class="form-check-input" type="radio" name="options[{{$value['id']}}]" id="{{strtolower(str_replace(' ', '_', $value['option_name']))}}_{{$valueOption['id']}}" @if($keyOption==0) checked @endif value="{{$valueOption['id']}}">

                                                        <label class="form-option-label" for="{{strtolower(str_replace(' ', '_', $value['option_name']))}}_{{$valueOption['id']}}">{{ucwords($valueOption['option_value'])}}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-left pb-0 pt-2">
                                            @if(!empty($value['product_option_values']))
                                                @foreach($value['product_option_values'] as $keyOption => $valueOption)
                                                    <div class="form-check form-option form-check-inline mb-1">
                                                        <input class="form-check-input" type="radio" name="options[{{$value['id']}}]" @if($keyOption==0) checked @endif id="{{str_replace('#', '', $valueOption['option_value'])}}" value="{{$valueOption['id']}}">

                                                        <label class="form-option-label rounded-circle" for="{{str_replace('#', '', $valueOption['option_value'])}}">
                                                            <span class="form-option-color rounded-circle" style="background:{{$valueOption['option_value']}}"></span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif

                        <div class="prt_05 mb-4">
                            <div class="form-row mb-7">
                                <div class="col-12 col-lg-auto">
                                    {{ Form::number('quantity', 1, ['class' => 'mb-2 form-control', 'min' => '1']) }}
                                </div>
                                <div class="col-12 col-lg">
                                    @guest
                                        <a href="{{route('login')}}" class="btn btn-block custom-height bg-dark mb-2">
                                            <i class="lni lni-heart mr-2"></i>Add to Cart
                                        </a>
                                    @else
                                        {!! Form::button('<i class="lni lni-shopping-basket mr-2"></i>Add to Cart', [
                                            'type' => 'submit',
                                            'class' => 'btn btn-block custom-height bg-dark mb-2',
                                            'id' => 'add_to_cartproduct',
                                            'data-type' => 'product-details'
                                        ]) !!}
                                    @endif
                                </div>
                                <div class="col-12 col-lg-auto">
                                    <!-- Wishlist -->
                                    @guest
                                        <a href="{{route('login')}}" class="btn custom-height btn-default btn-block mb-2 text-dark">
                                            <i class="lni lni-heart mr-2"></i>Wishlist
                                        </a>
                                    @else
                                        {!! Form::button('<i class="lni lni-heart mr-2"></i>Wishlist', [
                                            'class' => 'btn custom-height btn-default btn-block mb-2 text-dark snackbar-wishlist' . (in_array($product['id'], getWishlistProductIds()) ? ' active' : ''),
                                            'data-id' => $product['id'],
                                            'data-url' => route('products.add.wishlist'),
                                            'data-toggle' => 'button'
                                        ]) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}

                    <div class="prt_06">
                        <p class="mb-0 d-flex align-items-center">
                            <span class="mr-4">Share:</span>
                            <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2" href="#!">
                            <i class="fab fa-twitter position-absolute"></i>
                            </a>
                            <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2" href="#!">
                            <i class="fab fa-facebook-f position-absolute"></i>
                            </a>
                            <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted" href="#!">
                            <i class="fab fa-pinterest-p position-absolute"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="middle">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12">
                <ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="description-tab" href="#description-tab" data-toggle="tab" role="tab" aria-controls="description-tab" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#information" id="information-tab" data-toggle="tab" role="tab" aria-controls="information" aria-selected="false">Additional information</a>
                    </li>
                    <!-- <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#reviews" id="reviews-tab" data-toggle="tab" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                    </li> -->
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- Description Content -->
                    <div class="tab-pane fade show active" id="description-tab" role="tabpanel" aria-labelledby="description-tab">
                        @include('products.details.description-info')
                    </div>

                    <!-- Additional Content -->
                    <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                        @include('products.details.additionals-info')
                    </div>

                    <!-- Reviews Content -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        @include('products.details.reviews-info')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('products.details.related-products')
@endsection