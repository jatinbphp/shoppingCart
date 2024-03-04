<!-- Wishlist -->
<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Wishlist">
    <div class="rightMenu-scroll">
        <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
            <h4 class="cart_heading fs-md ft-medium mb-0">Wishlist Products</h4>
            <button onclick="closeWishlist()" class="close_slide"><i class="ti-close"></i></button>
        </div>
        <div class="right-ch-sideBar">
            <div class="cart_select_items py-2">

                @if(!empty(getWishlistProductListWithDetails()))
                    @foreach(getWishlistProductListWithDetails() as $keyWishlist => $valueWishlist)
                        <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                            <div class="cart_single d-flex align-items-center">
                                <div class="cart_selected_single_thumb">
                                    <a href="javaScript:;"><img src="{{url('assets/website/images/4.jpg')}}" width="60" class="img-fluid" alt="" /></a>
                                </div>
                                <div class="cart_single_caption pl-2">
                                    <h4 class="product_title fs-sm ft-medium mb-0 lh-1">Women Striped Shirt Dress</h4>
                                    <p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span class="text-dark small">Red</span></p>
                                    <h4 class="fs-md ft-medium mb-0 lh-1">$129</h4>
                                </div>
                            </div>
                            <div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
                        </div>
                    @endforeach
                @endif

            </div>
            <div class="cart_action px-3 py-3">
                <div class="form-group">
                    <button type="button" class="btn d-block full-width btn-dark">Move To Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>