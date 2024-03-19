<h5 class="mb-4 ft-medium">Delivery Address</h5>
<div class="row mb-4">
    <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        <div class="panel-group pay_opy980" id="payaccordion">
            @if(!empty($user_addresses))
                @foreach($user_addresses as $keyA => $address)
                    <div class="panel panel-default border">
                        <div class="panel-heading" id="pay">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" role="button" data-parent="#payaccordion" href="#address_{{ $address->id }}" aria-expanded="{{ $keyA == 0 ? 'true' : 'false' }}" aria-controls="address_{{ $address->id }}">
                                    {{ $address->title }}
                                </a>
                            </h4>
                        </div>
                        <div id="address_{{$address->id}}" class="panel-collapse collapse {{ $keyA == 0 ? 'show' : '' }}" aria-labelledby="pay" data-parent="#payaccordion">
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
                    </div>
                @endforeach
            @endif

            <div class="panel panel-default border">
                <div class="panel-heading" id="dabit">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#payaccordion" data-target="#add-new" aria-expanded="{{ empty($user_addresses) ? 'true' : 'false' }}"  aria-controls="add-new" >
                            Add a New Address
                        </a>
                    </h4>
                </div>
                <div id="add-new" class="panel-collapse collapse {{ empty($user_addresses) ? 'show' : '' }}" aria-labelledby="dabit" data-parent="#payaccordion">
                    <div class="panel-body">
                        @include ('my-addresses.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>