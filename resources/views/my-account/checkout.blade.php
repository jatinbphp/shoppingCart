@extends('layouts.app')

@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'Checkout']])

<section class="middle">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-12 col-lg-7 col-md-12">
                <form>
                    <h5 class="mb-4 ft-medium">Billing Details</h5>
                    <div class="row mb-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">First Name *</label>
                                <input type="text" class="form-control" placeholder="First Name" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Last Name *</label>
                                <input type="text" class="form-control" placeholder="Last Name" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Email *</label>
                                <input type="email" class="form-control" placeholder="Email" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Company</label>
                                <input type="text" class="form-control" placeholder="Company Name (optional)" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Address 1 *</label>
                                <input type="text" class="form-control" placeholder="Address 1" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Address 2</label>
                                <input type="text" class="form-control" placeholder="Address 2" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Country *</label>
                                <select class="custom-select">
                                    <option value="1" selected="">India</option>
                                    <option value="2">United State</option>
                                    <option value="3">United Kingdom</option>
                                    <option value="4">China</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">City / Town *</label>
                                <input type="text" class="form-control" placeholder="City / Town" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">ZIP / Postcode *</label>
                                <input type="text" class="form-control" placeholder="Zip / Postcode" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Mobile Number *</label>
                                <input type="text" class="form-control" placeholder="Mobile Number" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Additional Information</label>
                                <textarea class="form-control ht-50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12 d-block">
                            <input id="createaccount" class="checkbox-custom" name="createaccount" type="checkbox">
                            <label for="createaccount" class="checkbox-custom-label">Create An Account?</label>
                        </div>
                    </div>
                    <h5 class="mb-4 ft-medium">Payments</h5>
                    <div class="row mb-4">
                        <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                            <div class="panel-group pay_opy980" id="payaccordion">
                                <div class="panel panel-default border">
                                    <div class="panel-heading" id="pay">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" role="button" data-parent="#payaccordion" href="#payPal" aria-expanded="true"  aria-controls="payPal" class="">PayPal<img src="assets/img/paypal.html" class="img-fluid" alt=""></a>
                                        </h4>
                                    </div>
                                    <div id="payPal" class="panel-collapse collapse show" aria-labelledby="pay" data-parent="#payaccordion">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="text-dark">PayPal Email</label>
                                                <input type="text" class="form-control simple" placeholder="paypal@gmail.com">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-dark btm-md full-width">Pay 400.00 USD</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default border">
                                    <div class="panel-heading" id="stripes">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" role="button" data-parent="#payaccordion" href="#stripePay" aria-expanded="false"  aria-controls="stripePay" class="">Stripe<img src="assets/img/strip.html" class="img-fluid" alt=""></a>
                                        </h4>
                                    </div>
                                    <div id="stripePay" class="collapse" aria-labelledby="stripes" data-parent="#payaccordion">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="text-dark">Card Holder Name *</label>
                                                        <input type="text" class="form-control" placeholder="Dhananjay Preet" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="text-dark">Card Number *</label>
                                                        <input type="text" class="form-control" placeholder="5426 4586 5485 4759" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="text-dark">Expire Month *</label>
                                                        <select class="custom-select">
                                                            <option value="1" selected="">January</option>
                                                            <option value="2">February</option>
                                                            <option value="3">March</option>
                                                            <option value="4">April</option>
                                                            <option value="5">May</option>
                                                            <option value="6">June</option>
                                                            <option value="7">July</option>
                                                            <option value="8">August</option>
                                                            <option value="9">September</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="text-dark">Expire Year *</label>
                                                        <select class="custom-select">
                                                            <option value="1" selected="">2010</option>
                                                            <option value="2">2018</option>
                                                            <option value="3">2019</option>
                                                            <option value="4">2020</option>
                                                            <option value="5">2021</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="text-dark">CVC *</label>
                                                        <input type="text" class="form-control" placeholder="CVV*">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <input id="ak-2" class="checkbox-custom" name="ak-2" type="checkbox">
                                                        <label for="ak-2" class="checkbox-custom-label">By Continuing, you ar'e agree to conditions</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group text-center">
                                                        <a href="#" class="btn btn-dark full-width">Pay 202.00 USD</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default border">
                                    <div class="panel-heading" id="dabit">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#payaccordion" data-target="#debitPay" aria-expanded="false"  aria-controls="debitPay" class="">Debit Or Credit<img src="assets/img/debit.html" class="img-fluid" alt=""></a>
                                        </h4>
                                    </div>
                                    <div id="debitPay" class="panel-collapse collapse" aria-labelledby="dabit" data-parent="#payaccordion">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="text-dark">Card Holder Name *</label>
                                                        <input type="text" class="form-control" placeholder="Card Holder Name" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="text-dark">Card Number *</label>
                                                        <input type="text" class="form-control" placeholder="7589 6356 8547 9120" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="text-dark">Expire Month *</label>
                                                        <select class="custom-select">
                                                            <option value="1" selected="">January</option>
                                                            <option value="2">February</option>
                                                            <option value="3">March</option>
                                                            <option value="4">April</option>
                                                            <option value="5">May</option>
                                                            <option value="6">June</option>
                                                            <option value="7">July</option>
                                                            <option value="8">August</option>
                                                            <option value="9">September</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="text-dark">Expire Year *</label>
                                                        <select class="custom-select">
                                                            <option value="1" selected="">2010</option>
                                                            <option value="2">2018</option>
                                                            <option value="3">2019</option>
                                                            <option value="4">2020</option>
                                                            <option value="5">2021</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="text-dark">CVC *</label>
                                                        <input type="text" class="form-control" placeholder="CVV*" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <input id="al-2" class="checkbox-custom" name="al-2" type="checkbox">
                                                        <label for="al-2" class="checkbox-custom-label">By Continuing, you ar'e agree to conditions</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group text-center">
                                                        <a href="#" class="btn btn-dark full-width">Pay 202.00 USD</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            @php
            $subTotal = 0;
            @endphp
            @if(!empty($cart_products))
            <div class="col-12 col-lg-4 col-md-12">
                <div class="d-block mb-3">
                    <h5 class="mb-4">Order Items ({{count($cart_products)}})</h5>
                    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
                        @foreach($cart_products as $key => $value)
                            <li class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        <a target="_blank" href="{{route('products.details', [$value->id])}}">
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
                <a class="btn btn-block btn-dark mb-3" href="javascript:void(0)">Place Your Order</a>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection