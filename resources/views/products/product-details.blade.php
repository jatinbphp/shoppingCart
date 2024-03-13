@extends('layouts.app')

@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'Shop', $product['category']['full_name'], $product['product_name']]])

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
                    <div class="prt_01 mb-1">
                        <span class="text-light bg-info rounded px-2 py-1">
                            {{$product['category']['full_name']}}
                        </span>
                    </div>
                    <div class="prt_02 mb-3">
                        <h2 class="ft-bold mb-1">{{$product['product_name']}}</h2>
                        <div class="text-left">
                            <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star"></i>
                                <span class="small">(412 Reviews)</span>
                            </div>
                            <div class="elis_rty">
                                <span class="ft-medium text-muted line-through fs-md mr-2">
                                    {{ env('CURRENCY') }}{{ number_format(($product['price']+100), 2) }}
                                </span>
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
                                    @php
                                        $quantity = [];
                                        for ($i = 1; $i <= 10; $i++) {
                                            $quantity[$i] = $i;
                                        }
                                    @endphp

                                    {{ Form::select('quantity', $quantity, null, ['class' => 'mb-2 custom-select']) }}
                                </div>
                                <div class="col-12 col-lg">
                                    @guest
                                        <a href="{{route('login')}}" class="btn btn-block custom-height bg-dark mb-2">
                                            <i class="lni lni-heart mr-2"></i>Add to Cart
                                        </a>
                                    @else
                                        <button type="submit" class="btn btn-block custom-height bg-dark mb-2" id="add_to_cartproduct" data-type="product-details">
                                            <i class="lni lni-shopping-basket mr-2"></i>Add to Cart 
                                        </button>
                                    @endif
                                </div>
                                <div class="col-12 col-lg-auto">
                                    <!-- Wishlist -->
                                    @guest
                                        <a href="{{route('login')}}" class="btn custom-height btn-default btn-block mb-2 text-dark">
                                            <i class="lni lni-heart mr-2"></i>Wishlist
                                        </a>
                                    @else
                                        <button class="btn custom-height btn-default btn-block mb-2 text-dark snackbar-wishlist @if(in_array($product['id'], getWishlistProductIds())) active @endif" data-id="{{$product['id']}}" data-url="{{route('products.add.wishlist')}}" data-toggle="button">
                                            <i class="lni lni-heart mr-2"></i>Wishlist
                                        </button>
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
                        <a class="nav-link active" id="description-tab" href="#description" data-toggle="tab" role="tab" aria-controls="description" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#information" id="information-tab" data-toggle="tab" role="tab" aria-controls="information" aria-selected="false">Additional information</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#reviews" id="reviews-tab" data-toggle="tab" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- Description Content -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <div class="description_info">
                            {!! $product['description'] !!}
                        </div>
                    </div>
                    <!-- Additional Content -->
                    <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                        <div class="additionals">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th class="ft-medium text-dark">ID</th>
                                        <td>#{!! $product['id'] !!}</td>
                                    </tr>
                                    <tr>
                                        <th class="ft-medium text-dark">SKU</th>
                                        <td>{!! $product['sku'] !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Reviews Content -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="reviews_info">
                            <div class="single_rev d-flex align-items-start br-bottom py-3">
                                <div class="single_rev_thumb"><img src="{{url('assets/website/images/team-1.jpg')}}" class="img-fluid circle" width="90" alt="" /></div>
                                <div class="single_rev_caption d-flex align-items-start pl-3">
                                    <div class="single_capt_left">
                                        <h5 class="mb-0 fs-md ft-medium lh-1">Daniel Rajdesh</h5>
                                        <span class="small">30 jul 2021</span>
                                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum</p>
                                    </div>

                                    <div class="single_capt_right">
                                        <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="successMessage" style="display: none; color: green; font-size: 20px;">Review submitted successfully.</div>
                        <div class="reviews_rate">
                            @include('common.error')
                            {!! Form::model($user_data, ['url' => route('product.review.form'), 'method' => 'post', 'id' => 'reviewForm', 'class' => 'form-horizontal', 'files' => true]) !!}
                            {!! Form::hidden('redirects_to', URL::previous()) !!}
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <h4>Submit Rating</h4>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="revie_stars d-flex align-items-center justify-content-between px-2 py-2 gray rounded mb-2 mt-1">
                                    <div class="srt_013">
                                        <div class="submit-rating">
                                            <input id="star-5" type="radio" name="rating" value="5" />
                                            <label for="star-5" title="5 stars">
                                                <i class="active fa fa-star" aria-hidden="true"></i>
                                            </label>
                                            <input id="star-4" type="radio" name="rating" value="4" />
                                            <label for="star-4" title="4 stars">
                                                <i class="active fa fa-star" aria-hidden="true"></i>
                                            </label>
                                            <input id="star-3" type="radio" name="rating" value="3" checked="checked" />
                                            <label for="star-3" title="3 stars">
                                                <i class="active fa fa-star" aria-hidden="true"></i>
                                            </label>
                                            <input id="star-2" type="radio" name="rating" value="2" />
                                            <label for="star-2" title="2 stars">
                                                <i class="active fa fa-star" aria-hidden="true"></i>
                                            </label>
                                            <input id="star-1" type="radio" name="rating" value="1" />
                                            <label for="star-1" title="1 star">
                                                <i class="active fa fa-star" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                        @if ($errors->has('rating'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('rating') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="full_name">Full Name :<span class="text-red">*</span></label>
                                    {!! Form::text('full_name', $user_data->name ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Full Name', 'id' => 'full_name', 'required' => 'required']) !!}
                                    @if ($errors->has('full_name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="email_address">Email Address :<span class="text-red">*</span></label>
                                    {!! Form::text('email_address', $user_data->email ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Email Address', 'id' => 'email_address','required' => 'required']) !!}
                                    @if ($errors->has('email_address'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email_address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="description">Description :<span class="text-red">*</span></label>
                                    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'description','required' => 'required']) !!}
                                    @if ($errors->has('description'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group m-0">
                                    {!! Form::submit('Submit Review', ['class' => 'btn btn-white stretched-link hover-black']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(!empty($category_products))
<section class="middle pt-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Similar Products</h2>
                    <h3 class="ft-bold pt-3">Matching Producta</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="slide_items">
                    @foreach($category_products as $keySlider => $valueSlider)
                        <!-- single Item -->
                        <div class="single_itesm">
                            <div class="product_grid card b-0 mb-0">
                                @if(!empty($valueSlider->type))
                                    {!! customBadge($valueSlider->type) !!}
                                @endif

                                @guest
                                    <a href="{{route('login')}}" class="btn btn_love position-absolute ab-right">
                                        <i class="lni lni-heart"></i>
                                    </a>
                                @else
                                    <button class="btn btn_love position-absolute ab-right snackbar-wishlist @if(in_array($valueSlider->id, getWishlistProductIds())) active @endif" data-id="{{$valueSlider->id}}" data-url="{{route('products.add.wishlist')}}" data-toggle="button">
                                        <i class="lni lni-heart"></i>
                                    </button>
                                @endif

                                <div class="card-body p-0">
                                    <div class="shop_thumb position-relative">
                                        <a class="card-img-top d-block overflow-hidden" href="{{route('products.details', [$valueSlider->id])}}">
                                            @if(!empty($valueSlider->product_image->image) && file_exists($valueSlider->product_image->image))
                                                <img class="card-img-top" src="{{url($valueSlider->product_image->image)}}" alt="...">
                                            @else 
                                                <img class="card-img-top" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                                            @endif
                                        </a>

                                        <div class="edlio">
                                            <a href="javascript:void(0)" id="quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium" data-id="{{$valueSlider->id}}" data-url="{{route('products.quickview', [$valueSlider->id])}}">
                                                <i class="fas fa-eye mr-1"></i>Quick View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer b-0 p-3 pb-0 d-flex align-items-start justify-content-center">
                                    <div class="text-left">
                                        <div class="text-center">
                                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="product-detail.html">{{$valueSlider->product_name}}</a></h5>
                                            <div class="elis_rty">
                                                <span class="ft-bold fs-md text-dark">
                                                    {{ env('CURRENCY') }}{{ number_format($valueSlider->price, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
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

@section('jquery')
<script>
    $(document).ready(function() {
        $('#reviewForm').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            console.log(formData);
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: formData,
                success: function(response) {
                console.log(response);
                $('#successMessage').text('Review submitted successfully.').show();
                setTimeout(function() {
                    $('#successMessage').fadeOut('fast');
                }, 2000); 
            },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection