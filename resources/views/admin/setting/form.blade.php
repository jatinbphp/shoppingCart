{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('email_address') ? ' has-error' : '' }}">
            <label class="control-label" for="email_address">Email Address :<span class="text-red">*</span></label>
            {!! Form::text('email_address', $settings->email_address ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Email Address', 'id' => 'email_address']) !!}
            @if ($errors->has('email_address'))
                <span class="text-danger">
                    <strong>{{ $errors->first('email_address') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
            <label class="control-label" for="phone_number">Phone Number :<span class="text-red">*</span></label>
            {!! Form::text('phone_number', $settings->phone_number ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Phone Number', 'id' => 'phone_number']) !!}
            @if ($errors->has('phone_number'))
                <span class="text-danger">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('linkedin_url') ? ' has-error' : '' }}">
            <label class="control-label" for="linkedin_url">Linkedin url :<span class="text-red">*</span></label>
            {!! Form::text('linkedin_url', $settings->linkedin_url ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Linkedin Url', 'id' => 'linkedin_url']) !!}
            @if ($errors->has('linkedin_url'))
                <span class="text-danger">
                    <strong>{{ $errors->first('linkedin_url') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('facebook_url') ? ' has-error' : '' }}">
            <label class="control-label" for="facebook_url">Facebook Url :<span class="text-red">*</span></label>
            {!! Form::text('facebook_url', $settings->facebook_url ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Facebook Url', 'id' => 'facebook_url']) !!}
            @if ($errors->has('facebook_url'))
                <span class="text-danger">
                    <strong>{{ $errors->first('facebook_url') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('twitter_url') ? ' has-error' : '' }}">
            <label class="control-label" for="twitter_url">Twitter Url	 :<span class="text-red">*</span></label>
            {!! Form::text('twitter_url', $settings->twitter_url ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Twitter Url', 'id' => 'twitter_url']) !!}
            @if ($errors->has('twitter_url'))
                <span class="text-danger">
                    <strong>{{ $errors->first('twitter_url') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('youtube_url') ? ' has-error' : '' }}">
            <label class="control-label" for="youtube_url"> Youtube Url :<span class="text-red">*</span></label>
            {!! Form::text('youtube_url', $settings->youtube_url ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Youtube Url', 'id' => 'youtube_url']) !!}
            @if ($errors->has('youtube_url'))
                <span class="text-danger">
                    <strong>{{ $errors->first('youtube_url') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('instagram_url') ? ' has-error' : '' }}">
            <label class="control-label" for="instagram_url">Instagram Url :<span class="text-red">*</span></label>
            {!! Form::text('instagram_url', $settings->instagram_url ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Instagram Url', 'id' => 'instagram_url']) !!}
            @if ($errors->has('instagram_url'))
                <span class="text-danger">
                    <strong>{{ $errors->first('instagram_url') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            <label class="control-label" for="address">Address	 :<span class="text-red">*</span></label>
            {!! Form::textarea('address', $settings->address ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Address', 'id' => 'address', 'rows' => 5]) !!}
            @if ($errors->has('address'))
                <span class="text-danger">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
                    
<div class="col-md-12">
    <div class="form-group{{ $errors->has('header_menu_categories') ? ' has-error' : '' }}">
        <label class="control-label" for="header_menu_categories">Which Categories menu do you want to display in header menu?:</label>

        {!! Form::select("header_menu_categories[]", $categories, !empty($settings['header_menu_categories']) ? explode(",", $settings['header_menu_categories']) : null, ["class" => "form-control select2", "id" => "header_menu_categories", "multiple" => "true", 'data-placeholder' => 'Please Select']) !!}

        @if ($errors->has('header_menu_categories'))
            <span class="text-danger">
                <strong>{{ $errors->first('header_menu_categories') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="col-md-12">
    <div class="form-group{{ $errors->has('footer_menu_categories') ? ' has-error' : '' }}">
        <label class="control-label" for="footer_menu_categories">Which Categories menu do you want to display in footer menu?:</label>

        {!! Form::select("footer_menu_categories[]", $categories,  !empty($settings['footer_menu_categories']) ? explode(",", $settings['footer_menu_categories']) : null, ["class" => "form-control select2", "id" => "footer_menu_categories", "multiple" => "true", 'data-placeholder' => 'Please Select']) !!}

        @if ($errors->has('footer_menu_categories'))
            <span class="text-danger">
                <strong>{{ $errors->first('footer_menu_categories') }}</strong>
            </span>
        @endif
    </div>
</div>

