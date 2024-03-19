<h5 class="mb-2 ft-medium">Delivery Address</h5>
<div class="row mb-4">
    <div class="col-12 col-lg-12 col-xl-12 col-md-12">

        <style>
        #payaccordion article{border:1px solid #eaeff5;padding:1em}
        #payaccordion input[type="radio"]{appearance:none;position:fixed;top:-100vh;left:-100vh}
        #payaccordion input[type="radio"] ~ div{max-height:0;overflow:hidden;transition:max-height .5s}
        #payaccordion input[type="radio"]:checked ~ div{max-height:inherit}
        input[type="radio"]{position:absolute;opacity:0}
        #payaccordion .article-lable{display:block;cursor:pointer;padding-left:30px;position:relative}
        #payaccordion .article-lable::before{content:"";position:absolute;width:18px;height:18px;background:#edeef3;border-radius:50%;border:none;left:0;top:0;display:flex;align-items:center;justify-content:center;font-size:10px;color:#fff;transition:all ease .4s}
        #payaccordion input[type="radio"]:checked + .article-lable::before{content:"\e64c";font-family:'themify';background:#009acd}
        #payaccordion [type="radio"]:checked + label:after,#payaccordion [type="radio"]:not(:checked) + label:after{background:none!important}
        </style>

        <div class="panel-group" id="payaccordion">
            <div class="accordion">
                @if(!empty($user_addresses))
                    @foreach($user_addresses as $keyA => $address)
                        <article class="panel panel-default border">
                            <input id="address_{{ $address->id }}" type="radio" name="address_id" {{ $keyA == 0 ? 'checked' : '' }} value="{{ $address->id }}">
                            <label class="article-lable" for="address_{{ $address->id }}">
                                <h5>{{ $address->title }}</h5>
                            </label>
                            <div id="address_{{ $address->id }}" class="panel-collapse collapse show" aria-labelledby="pay" data-parent="#payaccordion">
                                <div class="panel-body">
                                    <h5 class="ft-medium mb-1">
                                        {{ $address->first_name}} {{$address->last_name}}
                                    </h5>
                                    <p>
                                        @if (!empty($address->title))
                                            {{ $address->title }}
                                        @endif

                                        @if (!empty($address->company))
                                            <br>{{ $address->company }}
                                        @endif

                                        @if (!empty($address->address_line1))
                                            <br>{{ $address->address_line1 }},
                                        @endif

                                        @if (!empty($address->address_line2))
                                            <br>{{ $address->address_line2 }},
                                        @endif

                                        @if (!empty($address->city) || !empty($address->state) || !empty($address->country) || !empty($address->pincode))
                                            <br>
                                            @if (!empty($address->pincode)) {{ $address->pincode }} - @endif
                                            @if (!empty($address->city)) {{ $address->city }}, @endif
                                            @if (!empty($address->state)) {{ $address->state }}, @endif
                                            @if (!empty($address->country)) {{ $address->country }} @endif
                                        @endif
                                    </p>

                                    @if(!empty($address->mobile_phone))
                                        <p>
                                            <span class="text-dark ft-medium">Call:</span> 
                                            <a href="tel:{{$address->mobile_phone}}">{{$address->mobile_phone}}</a><br>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                @endif

                <article class="panel panel-default border">
                    <input id="address_new" type="radio" name="address_id" {{ empty($user_addresses) ? 'checked' : '' }} value="0">
                    <label class="article-lable" for="address_new">
                        <h5>Add a New Address</h5>
                    </label>
                    <div id="address_new" class="panel-collapse collapse show" aria-labelledby="pay" data-parent="#payaccordion">
                        <div class="panel-body">
                            @include ('my-addresses.form')
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>