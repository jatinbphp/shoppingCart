@if(!empty(getTrendingProducts()))
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="sec_title position-relative text-center">
                        <h2 class="text-light off_title">Your Products</h2>
                        <h3 class="text-light ft-bold pt-3">Your Products</h3>
                    </div>
                </div>
            </div>
            <div class="row align-items-center rows-products">
                @foreach(getTrendingProducts() as $key => $value)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">

                            @if(!empty($value->type))
                                {!! customBadge($value->type) !!}
                            @endif

                            @guest
                                <a href="{{route('login')}}" class="btn btn_love position-absolute ab-right snackbar-wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                            @else
                                {!! Form::button('<i class="far fa-heart"></i>', [
                                    'class' => 'btn btn_love position-absolute ab-right snackbar-wishlist ' . (in_array($value->id, getWishlistProductIds()) ? 'active' : ''),
                                    'data-id' => $value->id,
                                    'data-url' => route('products.add.wishlist'),
                                    'data-toggle' => 'button'
                                ]) !!}

                            @endif
                            
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="{{route('products.details', [$value->id])}}">
                                        @if(!empty($value->product_image->image) && file_exists($value->product_image->image))
                                            <img class="card-img-top" src="{{url($value->product_image->image)}}" alt="...">
                                        @else 
                                            <img class="card-img-top" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                                        @endif
                                    </a>
                                    <div class="edlio">
                                        <a href="javascript:void(0)" id="quickview" class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center text-white fs-sm ft-medium" data-id="{{$value->id}}" data-url="{{route('products.quickview', [$value->id])}}">
                                            <i class="fas fa-eye mr-1"></i>Quick View
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footers b-0 py-3 px-2 dark_bg d-flex align-items-start justify-content-center">
                                <div class="text-left">
                                    <div class="text-center">
                                        <h5 class="fw-bolder fs-md text-light mb-0 lh-1 mb-1"><a href="shop-single.html" class="text-light">{{$value->product_name}}</a></h5>
                                        <div class="elis_rty">
                                            <span class="ft-bold fs-md text-light">
                                                {{ env('CURRENCY') }}{{ number_format($value->price, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
@endif