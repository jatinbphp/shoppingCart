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
                            <li><a href="javaScript:;">Contact Us</a></li>
                            <li><a href="javaScript:;">About Page</a></li>
                            <li><a href="javaScript:;">Size Guide</a></li>
                            <li><a href="javaScript:;">Shipping & Returns</a></li>
                            <li><a href="javaScript:;">FAQ's Page</a></li>
                            <li><a href="javaScript:;">Privacy</a></li>
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
                            <li><a href="javaScript:;">Home</a></li>
                            <li><a href="javaScript:;">About</a></li>
                            <li><a href="javaScript:;">Contact Us</a></li>
                            <li><a href="javaScript:;">Login</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Subscribe</h4>
                        <p>Receive updates, hot deals, discounts sent straignt in your inbox daily</p>
                        <div class="foot-news-last">
                        <div class="input-group">              
                            {!! Form::open(['route' => 'subscriber.form.submit', 'method' => 'post', 'id' => 'subscribeForm']) !!}
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <div class="input-group">
                                    {!! Form::text('email', old('email'), ['id' => 'email', 'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email Address']) !!}
                                    <div class="input-group-append">
                                        <button type="button" id="submitForm" class="input-group-text bg-dark b-0 text-light"><i class="lni lni-arrow-right"></i></button>
                                    </div>
                                </div>
                                @if ($errors->has('email'))
                                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                @endif
                                <div id="subscribe_message"></div>
                            </div>
                            {!! Form::close() !!}
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

@section('jquery')
<script type="text/javascript">
$(document).ready(function() {
    $('#submitForm').click(function() {
        var email = $('#email').val();
        if (!email) {
            $('#subscribe_message').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Email field is required.</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            setTimeout(function() {
                $('#subscribe_message').empty();
            }, 2000);
            return;
        } else if (!isValidEmail(email)) {
            $('#subscribe_message').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Please enter a valid email address.</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            setTimeout(function() {
                $('#subscribe_message').empty();
            }, 2000);
            return;
        }
        console.log(!email);
        $.ajax({
            url: '{{ route("subscriber.form.submit") }}',
            type: 'POST',
            data: {
                '_token': $('input[name="_token"]').val(),
                'email': email
            },
            success: function(response) {
                $('#subscribe_message').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>' + response.message + '</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                setTimeout(function() {
                    $('#subscribe_message').empty();
                }, 2000);
                $('#email').val(''); 
            },
            error: function(xhr) {
                var errors = xhr.responseJSON;
                if ($.isEmptyObject(errors) == false) {
                    $.each(errors.errors, function(key, value) {
                        $('#subscribe_message').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>' + value + '</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        setTimeout(function() {
                            $('#subscribe_message').empty();
                        }, 2000);
                    });
                }
            }
        });
    });
});
function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
</script>

@endsection