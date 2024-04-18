<ul class="nav nav-tabs" id="myTabs">
    <li class="nav-item">
        <a class="nav-link active" id="tab1" data-toggle="tab" href="#content1">Contact Information</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="tab2" data-toggle="tab" href="#content2">Social Information</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="tab3" data-toggle="tab" href="#content3">Menu</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="tab4" data-toggle="tab" href="#content4">Breadcrumb Image</a>
    </li>
    @if(!empty($settings->second_title))
    <li class="nav-item">
        <a class="nav-link" id="tab5" data-toggle="tab" href="#content5">{{$settings->second_title}}</a>
    </li>
    @endif
</ul>
<style type="text/css">
.nav-tabs .active {color: #007bff !important;}
.select2-container--default{width: 100% !important}
</style>
{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="tab-content mt-2">
    <div class="row tab-pane fade show active" id="content1">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('email_address') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'email_address', 'labelText' => 'Email Address', 'isRequired' => true])

                                {!! Form::text('email_address', $settings->email_address ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Email Address', 'id' => 'email_address']) !!}

                                @include('admin.common.errors', ['field' => 'email_address'])
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'phone_number', 'labelText' => 'Phone Number', 'isRequired' => true])

                                {!! Form::text('phone_number', $settings->phone_number ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Phone Number', 'id' => 'phone_number']) !!}

                                @include('admin.common.errors', ['field' => 'phone_number'])
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'address', 'labelText' => 'Address', 'isRequired' => true])

                                {!! Form::textarea('address', $settings->address ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Address', 'id' => 'address', 'rows' => 5]) !!}

                                @include('admin.common.errors', ['field' => 'address'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row tab-pane fade" id="content2">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('linkedin_url') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'linkedin_url', 'labelText' => 'Linkedin url', 'isRequired' => true])

                                {!! Form::url('linkedin_url', $settings->linkedin_url ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Linkedin Url', 'id' => 'linkedin_url']) !!}

                                @include('admin.common.errors', ['field' => 'linkedin_url'])
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('facebook_url') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'facebook_url', 'labelText' => 'Facebook Url', 'isRequired' => true])

                                {!! Form::url('facebook_url', $settings->facebook_url ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Facebook Url', 'id' => 'facebook_url']) !!}

                                @include('admin.common.errors', ['field' => 'facebook_url'])
                            </div>
                        </div>                    
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('twitter_url') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'twitter_url', 'labelText' => 'Twitter Url', 'isRequired' => true])

                                {!! Form::url('twitter_url', $settings->twitter_url ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Twitter Url', 'id' => 'twitter_url']) !!}

                                @include('admin.common.errors', ['field' => 'twitter_url'])
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('youtube_url') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'youtube_url', 'labelText' => 'Youtube Url', 'isRequired' => true])

                                {!! Form::url('youtube_url', $settings->youtube_url ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Youtube Url', 'id' => 'youtube_url']) !!}

                                @include('admin.common.errors', ['field' => 'youtube_url'])
                            </div>
                        </div>                    
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('instagram_url') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'instagram_url', 'labelText' => 'Instagram Url', 'isRequired' => true])

                                {!! Form::url('instagram_url', $settings->instagram_url ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Instagram Url', 'id' => 'instagram_url']) !!}

                                @include('admin.common.errors', ['field' => 'instagram_url'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row tab-pane fade" id="content3">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('header_menu_categories') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'header_menu_categories', 'labelText' => 'Which Categories menu do you want to display in header menu?', 'isRequired' => true])

                                {!! Form::select("header_menu_categories[]", $categories, !empty($settings['header_menu_categories']) ? explode(",", $settings['header_menu_categories']) : null, ["class" => "form-control select2 w-100", "id" => "header_menu_categories", "multiple" => "true", 'data-placeholder' => 'Please Select', "data-maximum-selection-length" => "3"]) !!}

                                @include('admin.common.errors', ['field' => 'header_menu_categories'])
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('footer_menu_categories') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'footer_menu_categories', 'labelText' => 'Which Categories menu do you want to display in footer menu?', 'isRequired' => true])

                                {!! Form::select("footer_menu_categories[]", $categories,  !empty($settings['footer_menu_categories']) ? explode(",", $settings['footer_menu_categories']) : null, ["class" => "form-control select2 w-100", "id" => "footer_menu_categories", "multiple" => "true", 'data-placeholder' => 'Please Select', "data-maximum-selection-length" => "5"]) !!}

                                @include('admin.common.errors', ['field' => 'footer_menu_categories'])
                            </div>
                        </div>
                        <div class="col-md-12 d-none">
                            <div class="form-group{{ $errors->has('filters_categories') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'filters_categories', 'labelText' => 'Which Categories do you want to display in filter?', 'isRequired' => true])

                                {!! Form::select("filters_categories[]", $categories,  !empty($settings['filters_categories']) ? explode(",", $settings['filters_categories']) : null, ["class" => "form-control select2 w-100", "id" => "filters_categories", "multiple" => "true", 'data-placeholder' => 'Please Select']) !!}

                                @include('admin.common.errors', ['field' => 'filters_categories'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row tab-pane fade" id="content4">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('breadcrumb_image') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'breadcrumb_image', 'labelText' => 'Breadcrumb Image', 'isRequired' => true])

                                <div class="">
                                    <div class="fileError">
                                        {!! Form::file('breadcrumb_image', ['class' => '', 'id'=> 'breadcrumb_image','accept'=>'image/*', 'onChange'=>'AjaxUploadImage(this)']) !!}
                                    </div>

                                    @if(!empty($settings['breadcrumb_image']) && file_exists($settings['breadcrumb_image']))
                                        <img src="{{asset($settings['breadcrumb_image'])}}" alt="Breadcrumb Image" style="border: 1px solid #ccc;margin-top: 5px;" width="150" id="DisplayImage">
                                    @else
                                        <img src=" {{url('assets/admin/dist/img/no-image.png')}}" alt="Breadcrumb Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
                                    @endif
                                </div>

                                @include('admin.common.errors', ['field' => 'breadcrumb_image'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row tab-pane fade" id="content5">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('first_title') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'first_title', 'labelText' => 'First Title', 'isRequired' => true])

                                {!! Form::text('first_title', $settings->first_title ?? null, ['class' => 'form-control', 'placeholder' => 'Enter First Title', 'id' => 'first_title']) !!}

                                @include('admin.common.errors', ['field' => 'first_title'])
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('second_title') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'second_title', 'labelText' => 'Second Title', 'isRequired' => true])

                                {!! Form::text('second_title', $settings->second_title ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Second Title', 'id' => 'second_title']) !!}

                                @include('admin.common.errors', ['field' => 'second_title'])
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'content', 'labelText' => 'Description', 'isRequired' => true])

                                {!! Form::textarea('content', $settings->content ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'content', 'rows' => 5]) !!}

                                @include('admin.common.errors', ['field' => 'content'])
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'image', 'labelText' => 'Background Image', 'isRequired' => true])

                                <div class="">
                                    <div class="fileError">
                                        {!! Form::file('image', ['class' => '', 'id'=> 'image','accept'=>'image/*', 'onChange'=>'AjaxUploadImage(this)']) !!}
                                    </div>

                                    @if(!empty($settings['image']) && file_exists($settings['image']))
                                        <img src="{{asset($settings['image'])}}" alt="Image" style="border: 1px solid #ccc;margin-top: 5px;" width="150" id="DisplayImage">
                                    @else
                                        <img src=" {{url('assets/admin/dist/img/no-image.png')}}" alt="Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
                                    @endif
                                </div>

                                @include('admin.common.errors', ['field' => 'image'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>