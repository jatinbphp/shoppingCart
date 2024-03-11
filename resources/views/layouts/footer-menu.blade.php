<footer class="light-footer">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                    <div class="footer_widget">
                        <img src="{{url('assets/website/images/logo.png')}}" class="img-footer small mb-2" alt="" />

                        @if(!empty(get_settings()['address']))
                        <div class="address mt-3">
                            <a href="javaScript:;">{{get_settings()['address']}}</a>
                        </div>
                        @endif

                        <div class="address mt-3">
                            @if(!empty(get_settings()['phone_number']))
                                <a href="tel:{{get_settings()['phone_number']}}">{{get_settings()['phone_number']}}</a><br>
                            @endif
                            @if(!empty(get_settings()['email_address']))
                                <a href="mailto:{{get_settings()['email_address']}}">{{get_settings()['email_address']}}</a>
                            @endif
                        </div>
                        <div class="address mt-3">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a target="_blank" href="@if(!empty($settings->facebook_url)) {{$settings->facebook_url}} @else javascript:void(0); @endif">
                                        <i class="lni lni-facebook-filled"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a target="_blank" href="@if(!empty($settings->twitter_url)) {{$settings->twitter_url}} @else javascript:void(0); @endif">
                                        <i class="lni lni-twitter-filled"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a target="_blank" href="@if(!empty($settings->youtube_url)) {{$settings->youtube_url}} @else javascript:void(0); @endif">
                                        <i class="lni lni-youtube"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a target="_blank" href="@if(!empty($settings->instagram_url)) {{$settings->instagram_url}} @else javascript:void(0); @endif">
                                        <i class="lni lni-instagram-filled"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a target="_blank" href="@if(!empty($settings->linkedin_url)) {{$settings->linkedin_url}} @else javascript:void(0); @endif">
                                        <i class="lni lni-linkedin-original"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Supports</h4>
                        <ul class="footer-menu">
                            <li><a href="javaScript:;">Size Guide</a></li>
                            <li><a href="javaScript:;">Shipping & Returns</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Shop</h4>
                        <ul class="footer-menu">
                            <li><a href="javaScript:;">Men's Shopping</a></li>
                            <li><a href="javaScript:;">Women's Shopping</a></li>
                            <li><a href="javaScript:;">Kids's Shopping</a></li>
                            <li><a href="javaScript:;">Accessories</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Company</h4>
                        <ul class="footer-menu">
                            <li><a href="{{route('about-us')}}">About Us</a></li>
                            <li><a href="{{route('contact-us')}}">Contact Us</a></li>
                            <li><a href="{{route('faq')}}">FAQ's</a></li>
                            <li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
                            <li><a href="{{route('terms-conditions')}}">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Subscribe</h4>
                        <p>Receive updates, hot deals, discounts sent straignt in your inbox daily</p>
                        <div class="foot-news-last">
                        <div class="input-group">              
                            <div class="form-group">
                                <div class="input-group">
                                    {!! Form::text('subscriber_email', old('subscriber_email'), ['id' => 'subscriber_email', 'class' => 'form-control' . ($errors->has('subscriber_email') ? ' is-invalid' : ''), 'placeholder' => 'Email Address']) !!}
                                    <div class="input-group-append">
                                        <button type="button" id="submit-subscriber-form" class="input-group-text bg-dark b-0 text-light" data-url="{{ route('subscriber.form.submit') }}"><i class="lni lni-arrow-right"></i></button>
                                    </div>
                                </div>
                                @if ($errors->has('email'))
                                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                @endif
                                <div id="subscribe_message"></div>
                            </div>
                        </div>
                        <div class="address mt-3">
                            <h5 class="fs-sm">Secure Payments</h5>
                            <div class="scr_payment">
                                <img src="{{url('assets/website/images/card.png')}}" class="img-fluid" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 col-md-12 text-center">
                    <p class="mb-0">© 2024 Blu Leisure. Designd By <a href="#">Nxsol</a>.</p>
                </div>
            </div>
        </div>
    </div>
</footer>