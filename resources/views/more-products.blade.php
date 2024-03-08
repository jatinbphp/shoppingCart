@foreach($products as $key => $value)
    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
        <div class="product_grid card b-0">
            <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">New</div>

            @guest
                <a href="{{route('login')}}" class="btn btn_love position-absolute ab-right">
                    <i class="far fa-heart"></i>
                </a>
            @else
                <button class="btn btn_love position-absolute ab-right snackbar-wishlist @if(in_array($value->id, getWishlistProductIds())) active @endif" data-id="{{$value->id}}" data-url="{{route('products.add.wishlist')}}" data-toggle="button">
                    <i class="far fa-heart"></i>
                </button>
            @endif

            <div class="card-body p-0">
                <div class="shop_thumb position-relative">
                    <a target="_blank" class="card-img-top d-block overflow-hidden" href="{{route('products.details', [$value->id])}}">
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
            <div class="card-footer b-0 p-0 pt-2 bg-white">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="text-left">
                        <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star"></i>
                            <span class="small">(5 Reviews)</span>
                        </div>
                    </div>
                    <!-- <div class="text-right">
                        <button class="btn auto btn_love snackbar-wishlist"><i class="far fa-heart"></i></button> 
                    </div> -->
                </div>
                <div class="text-left">
                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1">
                        <a href="product-detail.html">{{ $value->product_name ?? "-"}}</a>
                    </h5>
                    <div class="elis_rty">
                        <span class="ft-bold text-dark fs-sm">{{ env('CURRENCY') }}{{ number_format($value->price ?? 0, 2) }}</span>
                    </div>
                    <div class="d-none">
                        <p class="mt-3 mb-4">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum are deleniti atque corrupti quos dolores</p>
                        <a href="javascript:void(0);" class="btn stretched-link borders  snackbar-addcart">Add To Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach