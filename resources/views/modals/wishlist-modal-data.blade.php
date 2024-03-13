<div class="cart_select_items py-2">
    @if(count(getWishlistProductIds())>0)
        @if(!empty($wishlist_products))
            @foreach($wishlist_products as $keyWishlist => $valueWishlist)
                <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                    <div class="cart_single d-flex align-items-center">
                        <div class="cart_selected_single_thumb">
                            <a href="{{route('products.details', [$valueWishlist->id])}}">
                                @if(!empty($valueWishlist->product_image->image) && file_exists($valueWishlist->product_image->image))
                                    <img src="{{url($valueWishlist->product_image->image)}}" width="60" class="img-fluid" alt="">
                                @else 
                                    <img class="img-fluid" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                                @endif
                            </a>
                        </div>
                        <div class="cart_single_caption pl-2">
                            <h4 class="product_title fs-sm ft-medium mb-0 lh-1">{{$valueWishlist->product_name}}</h4>
                            <!-- <p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span class="text-dark small">Red</span></p> -->
                            <h4 class="fs-md ft-medium lh-1 mt-2">
                                {{ env('CURRENCY') }}{{ number_format($valueWishlist->price, 2) }}
                            </h4>
                        </div>
                    </div>
                    <div class="fls_last">
                        <button class="close_slide gray remove-wishlist" data-id="{{$valueWishlist->id}}" data-url="{{route('products.add.wishlist')}}"><i class="ti-close"></i></button>
                    </div>
                </div>
            @endforeach
        @endif
    @else 
        <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
            <div class="cart_single d-flex align-items-center">
                <p>Your wishlist is empty.</p>
            </div>
        </div>
    @endif
</div>

@if(count(getWishlistProductIds())>4)
    <div class="cart_action px-3 py-3">
        <div class="form-group">
            <a href="{{route('wishlist')}}" class="btn d-block full-width btn-dark">View All</a>
        </div>
    </div>
@endif