<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
    <div class="footer_widget">
        <img src="{{url('assets/website/images/logo.png')}}?{{ time() }}" class="img-footer small mb-2" alt="" />

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