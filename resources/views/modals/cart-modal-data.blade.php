<div class="cart_select_items py-2">
    @if(count(getCartProductIds())>0)
        @if(!empty($cart_products))
            @foreach($cart_products as $keyCart => $valueCart)
                <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                    <div class="cart_single d-flex align-items-center">
                        <div class="cart_selected_single_thumb">
                            <a href="{{route('products.details', [$valueCart->id])}}">
                                @if(!empty($valueCart->product_image->image) && file_exists($valueCart->product_image->image))
                                    <img src="{{url($valueCart->product_image->image)}}" width="60" class="img-fluid" alt="">
                                @else 
                                    <img class="img-fluid" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                                @endif
                            </a>
                        </div>
                        <div class="cart_single_caption pl-2">
                            <h4 class="product_title fs-sm ft-medium mb-0 lh-1">{{$valueCart->product_name}}</h4>
                            <h4 class="fs-md ft-medium lh-1 mt-2">
                                {{ env('CURRENCY') }}{{ number_format($valueCart->price, 2) }}
                            </h4>
                        </div>
                    </div>
                    <div class="fls_last">
                        <button class="close_slide gray remove-cart" data-id="{{$valueCart->id}}" data-url="{{route('products.remove.cart')}}" data-type="quick-view"><i class="ti-close"></i></button>
                    </div>
                </div>
            @endforeach
        @endif
    @else 
        <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
            <div class="cart_single d-flex align-items-center">
                <p>Your Cart is empty.</p>
            </div>
        </div>
    @endif
</div>

@if(count(getCartProductIds())>1)
    <div class="cart_action px-3 py-3">
        <div class="form-group">
            <a href="{{route('my-account.checkout')}}" class="btn d-block full-width btn-dark">Checkout Now</a>
        </div>
    </div>
@endif