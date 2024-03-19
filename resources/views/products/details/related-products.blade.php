@if(!empty($category_products))
	<section class="middle pt-0">
	    <div class="container">
	        <div class="row justify-content-center">
	            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
	                <div class="sec_title position-relative text-center">
	                    <h2 class="off_title">Similar Products</h2>
	                    <h3 class="ft-bold pt-3">Related Products</h3>
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
	                                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{route('products.details', [$valueSlider->id])}}">{{$valueSlider->product_name}}</a></h5>
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