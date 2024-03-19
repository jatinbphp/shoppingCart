<div class="cart_select_items py-2">
    @if(count(getTotalCartProducts())>0)
        @if(!empty($cart_products))
            @foreach($cart_products as $keyCart => $valueCart)
                <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                    <div class="cart_single d-flex align-items-center">
                        <div class="cart_selected_single_thumb">
                            <a href="{{route('products.details', [$valueCart->id])}}">
                                @if(!empty($valueCart->product->product_image->image) && file_exists($valueCart->product->product_image->image))
                                    <img src="{{url($valueCart->product->product_image->image)}}" width="60" class="img-fluid" alt="">
                                @else 
                                    <img class="img-fluid" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                                @endif
                            </a>
                        </div>
                        <div class="cart_single_caption pl-2">
                            <h4 class="product_title fs-sm ft-medium mb-1 lh-1">{{$valueCart->product->product_name}}</h4>

                            <p class="mb-1 lh-1">
                                <span class="text-dark">Qty: {{$valueCart->quantity}} X {{ env('CURRENCY') }}{{ number_format($valueCart->product->price, 2) }}</span>
                            </p>

                            @if(!empty($valueCart->product_options))
                                @foreach($valueCart->product_options as $keyO => $keyV)
                                    @if($keyO=='COLOR')
                                        <p class="mb-1 lh-1">
                                            <span class="text-dark">{{$keyO}}: <i class="fas fa-square" style="color: {{$keyV}}  "></i></span>
                                        </p>
                                    @else
                                        <p class="mb-1 lh-1">
                                            <span class="text-dark">{{$keyO}}: {{$keyV}}</span>
                                        </p>
                                    @endif
                                @endforeach
                            @endif

                            <h4 class="fs-md ft-medium lh-1 mt-2">
                                {{ env('CURRENCY') }}{{ number_format(($valueCart->product->price*$valueCart->quantity), 2) }}
                            </h4>
                        </div>
                    </div>
                    <div class="fls_last">
                        {!! Form::button('<i class="ti-close"></i>', [
                            'class' => 'close_slide gray remove-cart',
                            'data-id' => $valueCart->product->id,
                            'data-url' => route('cart.remove'),
                            'data-type' => 'quick-view'
                        ]) !!}
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

@if(count(getTotalCartProducts())>0)
    <div class="cart_action px-3 py-3">
        <div class="form-group">
            <a href="{{route('checkout')}}" class="btn d-block full-width btn-dark">Checkout Now</a>
        </div>

        <div class="form-group">
            <a href="{{route('shopping-cart')}}" class="btn d-block full-width btn-dark-light">Shopping Cart</a>
        </div>
    </div>
@endif