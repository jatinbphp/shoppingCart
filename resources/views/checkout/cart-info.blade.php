@php
$subTotal = 0;
$out_of_stock = 1;
@endphp
<div class="d-block mb-3">
    <h5 class="mb-4">Order Items ({{count($cart_products)}})</h5>
    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
        @foreach($cart_products as $key => $value)
            <li class="list-group-item">
                <div class="row align-items-center">
                    <div class="col-4">
                        <a target="_blank" href="{{route('products.details', [$value->product->id])}}">
                            @if(!empty($value->product->product_image->image) && file_exists($value->product->product_image->image))
                                <img class="img-fluid" src="{{url($value->product->product_image->image)}}" alt="...">
                            @else 
                                <img class="img-fluid" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                            @endif
                        </a>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="cart_single_caption">
                            <h4 class="product_title fs-md ft-medium mb-1 lh-1">
                                {{$value->product->product_name}}
                            </h4>

                            <p class="mb-1 lh-1">
                                <span class="text-dark">Qty: {{$value->quantity}} X {{ env('CURRENCY') }}{{ number_format($value->product->price, 2) }}</span>
                            </p>

                            @if(!empty($value->product_options))
                                @foreach($value->product_options as $keyO => $keyV)
                                    @if($keyO=='COLOR')
                                        <p class="mb-1 lh-1">
                                            <span class="text-dark">{{$keyO}}: <i class="fas fa-square" style="color:  {{$keyV}}  "></i></span>
                                        </p>
                                    @else
                                        <p class="mb-1 lh-1">
                                            <span class="text-dark">{{$keyO}}: {{$keyV}}</span>
                                        </p>
                                    @endif
                                @endforeach
                            @endif

                            <p class="mb-1 lh-1">
                                {{ env('CURRENCY') }}{{ number_format(($value->product->price*$value->quantity), 2) }}
                            </p>

                            @if($value->out_of_stock==0)
                                <p class="mb-1 lh-2 text-danger">This product is currently out of stock. We have only <?php echo $value->total_stock_quantity; ?> quantity left.</p>

                                @php
                                $out_of_stock = 0;
                                @endphp
                            @endif
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
@if($out_of_stock==1)
    {!! Form::submit('Place Your Order', ['class' => 'btn btn-block btn-dark mb-3']) !!}
@else
    {!! Form::button('Place Your Order', ['class' => 'btn btn-block btn-dark mb-3', 'id' => 'out_of_stock_button']) !!}
@endif