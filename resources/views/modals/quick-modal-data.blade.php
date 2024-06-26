{!! Form::open(['route' => 'cart.add-product', 'method' => 'post', 'id' => 'addProductToCartForm']) !!}
    <div class="modal-headers">
        {!! Html::tag('button', '<span class="ti-close"></span>', [
            'type' => 'button',
            'class' => 'close',
            'data-dismiss' => 'modal',
            'aria-label' => 'Close'
        ]) !!}
    </div>
    <div class="modal-body">
        <div class="quick_view_wrap align-items-center">
            <div class="quick_view_thmb text-center" id="quick_view_thmb">
                <img class="img-fluid" src="{{url('assets/website/images/loader.gif')}}?v={{ time()}}" alt="...">
            </div>
            <div class="quick_view_capt">
                <div class="prd_details">
                    <!-- <div class="prt_01 mb-1">
                        <span class="text-light bg-info rounded px-2 py-1"></span>
                    </div> -->
                    <div class="prt_02 mb-2">
                        <h2 class="ft-bold mb-1">{{$info['product_name']}}</h2>

                        @if(!empty($info['categories']))
                            <div class="prt_04 mb-2">
                                <p class="align-items-center mb-0">
                                    <b class="pr-1">Categories : </b> {{$info['categories']}}
                                </p>
                            </div>
                        @endif

                        <div class="text-left">
                            <!-- @php
                                $average_rating = ($info['total_reviews'] > 0) ? $info['total_review_rating'] / $info['total_reviews'] : 0;
                                $filled_stars = round($average_rating);
                            @endphp
                            <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $filled_stars)
                                        <i class="fas fa-star filled"></i>
                                    @else
                                        <i class="fas fa-star"></i>
                                    @endif
                                @endfor
                                <span class="small">({{$info['total_reviews']}} Reviews)</span>
                            </div> -->
                            <div class="elis_rty">
                                <!-- <span class="ft-medium text-muted line-through fs-md mr-2">
                                    {{ env('CURRENCY') }}{{ number_format(($info['price']+100), 2) }}
                                </span> -->
                                <span class="ft-bold theme-cl fs-lg mr-2">
                                    {{ env('CURRENCY') }}{{ number_format($info['price'], 2) }}
                                </span>
                                <!-- <span class="ft-regular text-success bg-light-success py-1 px-2 fs-sm">In Stock</span> -->
                            </div>
                        </div>
                    </div>
                    <div class="prt_03 mb-3">
                        {!! substr($info['description'], 0, 300) !!}{{ strlen($info['description']) > 200 ? '...' : '' }}
                    </div>

                    @if(!empty($info['options']))
                        @foreach($info['options'] as $key => $value)
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

                    {!! Form::hidden("product_id", $info['id'], null, ["class" => "form-control", "id" => "product_id"]) !!}

                    <div class="prt_05 mb-4">
                        <div class="form-row mb-7">
                            <div class="col-12 col-lg-auto">
                                {{ Form::number('quantity', 1, ['class' => 'mb-2 form-control', 'min' => '1']) }}
                            </div>
                            <div class="col-12 col-lg">
                                @guest
                                    <a href="{{route('login')}}" class="btn btn-block custom-height bg-dark mb-2">
                                        <i class="lni lni-heart mr-2"></i>Add to Cart
                                    </a>
                                @else
                                    {!! Form::button('<i class="lni lni-shopping-basket mr-2"></i>Add to Cart', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-block custom-height bg-dark mb-2',
                                        'id' => 'add_to_cartproduct'
                                    ]) !!}
                                @endif
                            </div>
                            <div class="col-12 col-lg-auto">
                                <!-- Wishlist -->
                                @guest
                                    <a href="{{route('login')}}" class="btn custom-height btn-default btn-block mb-2 text-dark">
                                        <i class="lni lni-heart mr-2"></i>Wishlist
                                    </a>
                                @else
                                    {!! Form::button('<i class="lni lni-heart mr-2"></i>Wishlist', [
                                        'class' => 'btn custom-height btn-default btn-block mb-2 text-dark snackbar-wishlist ' . (in_array($info['id'], getWishlistProductIds()) ? 'active' : ''),
                                        'data-id' => $info['id'],
                                        'data-url' => route('products.add.wishlist'),
                                        'data-toggle' => 'button'
                                    ]) !!}
                                @endif
                            </div>
                        </div>
                    </div>
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
{!! Form::close() !!}