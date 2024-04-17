@php
$subTotal = 0;
@endphp
<div class="d-block mb-3">
    <h5 class="mb-4">Order Items ({{count($cart_products)}})</h5>
    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
        @foreach($cart_products as $key => $value)
            <li class="list-group-item">
                <div class="row align-items-center">
                    <div class="col-3">
                        <a target="_blank" href="{{route('products.details', [$value->product->id])}}">
                            @if(!empty($value->product->product_image->image) && file_exists($value->product->product_image->image))
                                <img class="img-fluid" src="{{url($value->product->product_image->image)}}" alt="...">
                            @else 
                                <img class="img-fluid" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                            @endif
                        </a>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="cart_single_caption pl-2">
                            <h4 class="product_title fs-md ft-medium mb-1 lh-1">
                                {{$value->product->product_name}}
                            </h4>

                            <p class="mb-1 lh-1">
                                <span class="text-dark"><b>Qty:</b> {{$value->quantity}} X {{ env('CURRENCY') }}{{ number_format($value->product->price, 2) }}</span>
                            </p>

                            @if(!empty($value->product_options))
                                @foreach($value->product_options as $keyO => $keyV)
                                    @if($keyO=='COLOR')
                                        <p class="mb-1 lh-1">
                                            <span class="text-dark"><b>{{$keyO}}:</b> <i class="fas fa-square" style="color:  {{$keyV}}  "></i></span>
                                        </p>
                                    @else
                                        <p class="mb-1 lh-1">
                                            <span class="text-dark"><b>{{$keyO}}:</b> {{$keyV}}</span>
                                        </p>
                                    @endif
                                @endforeach
                            @endif

                            <h4 class="fs-md ft-medium mb-3 lh-1">
                                {{ env('CURRENCY') }}{{ number_format(($value->product->price*$value->quantity), 2) }}
                            </h4>
                        </div>
                    </div>
                </div>
            </li>
            @php
            $subTotal = ($subTotal+($value->product->price*$value->quantity));
            @endphp
        @endforeach
    </ul>
</div>
<div class="card mb-4 gray">
    <div class="card-body">
        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                <span>Subtotal</span> 
                <span class="ml-auto text-dark ft-medium">{{ env('CURRENCY') }}{{ number_format($subTotal, 2) }}</span>
            </li>
            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                <span>Total</span> <span class="ml-auto text-dark ft-medium">
                    {{ env('CURRENCY') }}{{ number_format($subTotal, 2) }}
                </span>
            </li>
            <li class="list-group-item fs-sm text-center">
                Shipping cost calculated at Checkout *
            </li>
        </ul>
    </div>
</div>