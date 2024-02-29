<div class="modal-headers">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span class="ti-close"></span>
    </button>
</div>
<div class="modal-body">
    <div class="quick_view_wrap">
        <div class="quick_view_thmb">
            <div class="quick_view_slide">

                <!-- @if(!empty($info->product_image))
                    @if(!empty($info->product_image->image) && file_exists($info->product_image->image))
                        <div class="single_view_slide">
                            <img src="{{url($info->product_image->image)}}" class="img-fluid" alt="" />
                        </div>
                    @endif
                @endif -->

                @if(!empty($info['product_images']))
                    @foreach($info['product_images'] as $keyImages => $valueImages)
                        @if(!empty($valueImages['image']) && file_exists($valueImages['image']))
                            <div class="single_view_slide">
                                <img src="{{url($valueImages['image'])}}" class="img-fluid" alt="" />
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        <div class="quick_view_capt">
            <div class="prd_details">
                <div class="prt_01 mb-1"><span class="text-light bg-info rounded px-2 py-1">{{$info['category']['full_name']}}</span></div>
                <div class="prt_02 mb-2">
                    <h2 class="ft-bold mb-1">{{$info['product_name']}}</h2>
                    <div class="text-left">
                        <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star"></i>
                            <span class="small">(412 Reviews)</span>
                        </div>
                        <div class="elis_rty">
                            <span class="ft-medium text-muted line-through fs-md mr-2">
                                {{ env('CURRENCY') }}{{ number_format(($info['price']+100), 2) }}
                            </span>
                            <span class="ft-bold theme-cl fs-lg mr-2">
                                {{ env('CURRENCY') }}{{ number_format($info['price'], 2) }}
                            </span>
                            <span class="ft-regular text-success bg-light-success py-1 px-2 fs-sm">In Stock</span>
                        </div>
                    </div>
                </div>
                <div class="prt_03 mb-3">
                    {!! $info['description'] !!}
                </div>

                @if(!empty($info['options']))
                    @foreach($info['options'] as $key => $value)
                        <div class="prt_04 mb-2">
                            <p class="d-flex align-items-center mb-0 text-dark ft-medium">{{ucwords($value['option_name'])}}:</p>
                            <div class="text-left pb-0 pt-2">
                                @if(!empty($value['product_option_values']))
                                    @foreach($value['product_option_values'] as $keyOption => $valueOption)
                                        <div class="form-check size-option form-option form-check-inline mb-2">
                                            <input class="form-check-input" type="radio" name="options[$value['id']" id="{{strtolower(str_replace(' ', '_', $value['option_name']))}}_{{$valueOption['id']}}">
                                            <label class="form-option-label" for="{{strtolower(str_replace(' ', '_', $value['option_name']))}}_{{$valueOption['id']}}">{{ucwords($valueOption['option_value'])}}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="prt_04 mb-2">
                    <p class="d-flex align-items-center mb-0 text-dark ft-medium">Color:</p>
                    <div class="text-left">
                        <div class="form-check form-option form-check-inline mb-1">
                            <input class="form-check-input" type="radio" name="color8" id="white8">
                            <label class="form-option-label rounded-circle" for="white8"><span class="form-option-color rounded-circle blc7"></span></label>
                        </div>
                        <div class="form-check form-option form-check-inline mb-1">
                            <input class="form-check-input" type="radio" name="color8" id="blue8">
                            <label class="form-option-label rounded-circle" for="blue8"><span class="form-option-color rounded-circle blc2"></span></label>
                        </div>
                        <div class="form-check form-option form-check-inline mb-1">
                            <input class="form-check-input" type="radio" name="color8" id="yellow8">
                            <label class="form-option-label rounded-circle" for="yellow8"><span class="form-option-color rounded-circle blc5"></span></label>
                        </div>
                        <div class="form-check form-option form-check-inline mb-1">
                            <input class="form-check-input" type="radio" name="color8" id="pink8">
                            <label class="form-option-label rounded-circle" for="pink8"><span class="form-option-color rounded-circle blc3"></span></label>
                        </div>
                        <div class="form-check form-option form-check-inline mb-1">
                            <input class="form-check-input" type="radio" name="color8" id="red">
                            <label class="form-option-label rounded-circle" for="red"><span class="form-option-color rounded-circle blc4"></span></label>
                        </div>
                        <div class="form-check form-option form-check-inline mb-1">
                            <input class="form-check-input" type="radio" name="color8" id="green">
                            <label class="form-option-label rounded-circle" for="green"><span class="form-option-color rounded-circle blc6"></span></label>
                        </div>
                    </div>
                </div>
                <div class="prt_04 mb-4">
                    <p class="d-flex align-items-center mb-0 text-dark ft-medium">Size:</p>
                    <div class="text-left pb-0 pt-2">
                        <div class="form-check size-option form-option form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="size" id="28" checked="">
                            <label class="form-option-label" for="28">28</label>
                        </div>
                        <div class="form-check form-option size-option  form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="size" id="30">
                            <label class="form-option-label" for="30">30</label>
                        </div>
                        <div class="form-check form-option size-option  form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="size" id="32">
                            <label class="form-option-label" for="32">32</label>
                        </div>
                        <div class="form-check form-option size-option  form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="size" id="34">
                            <label class="form-option-label" for="34">34</label>
                        </div>
                        <div class="form-check form-option size-option  form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="size" id="36">
                            <label class="form-option-label" for="36">36</label>
                        </div>
                        <div class="form-check form-option size-option  form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="size" id="38">
                            <label class="form-option-label" for="38">38</label>
                        </div>
                        <div class="form-check form-option size-option  form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="size" id="40">
                            <label class="form-option-label" for="40">40</label>
                        </div>
                    </div>
                </div>
                <div class="prt_05 mb-4">
                    <div class="form-row mb-7">
                        <div class="col-12 col-lg-auto">
                            <!-- Quantity -->
                            <select class="mb-2 custom-select">
                                <option value="1" selected="">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="col-12 col-lg">
                            <!-- Submit -->
                            <button type="submit" class="btn btn-block custom-height bg-dark mb-2">
                            <i class="lni lni-shopping-basket mr-2"></i>Add to Cart 
                            </button>
                        </div>
                        <div class="col-12 col-lg-auto">
                            <!-- Wishlist -->
                            <button class="btn custom-height btn-default btn-block mb-2 text-dark" data-toggle="button">
                            <i class="lni lni-heart mr-2"></i>Wishlist
                            </button>
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