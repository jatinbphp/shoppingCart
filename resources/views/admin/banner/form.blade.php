{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            <label class="control-label" for="title">Title :<span class="text-red">*</span></label>
            {!! Form::text('title', $banner->title ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'id' => 'title']) !!}
            @if ($errors->has('title'))
                <span class="text-danger">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('subtitle') ? ' has-error' : '' }}">
            <label class="control-label" for="subtitle">Subtitle :<span class="text-red">*</span></label>
            {!! Form::text('subtitle', $banner->subtitle ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Subtitle', 'id' => 'subtitle']) !!}
            @if ($errors->has('subtitle'))
                <span class="text-danger">
                    <strong>{{ $errors->first('subtitle') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="control-label" for="address">Description   :<span class="text-red">*</span></label>
            {!! Form::textarea('description', $banner->description ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'description', 'rows' => 3]) !!}
            @if ($errors->has('description'))
                <span class="text-danger">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            <label class="control-label" for="image">Image :<span class="text-red">*</span></label>
            <div class="">
                <div class="fileError">
                    {!! Form::file('image', ['class' => '', 'id'=> 'image','accept'=>'image/*', 'onChange'=>'AjaxUploadImage(this)']) !!}
                </div>

                @if(!empty($banner['image']) && file_exists($banner['image']))
                    {!! Form::hidden('hidden_image', $banner->image ?? null) !!}
                    <img src="{{asset($banner['image'])}}" alt="Banner Image" style="border: 1px solid #ccc;margin-top: 5px;" width="150" id="DisplayImage">
                @else
                    <img src=" {{url('assets/admin/dist/img/no-image.png')}}" alt="Banner Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
                @endif

                @if ($errors->has('image'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="control-label" for="status">Status :<span class="text-red">*</span></label>
            <div class="">
                @foreach (\App\Models\Banner::$status as $key => $value)
                        @php $checked = !isset($banner) && $key == 'active'?'checked':''; @endphp
                    <label>
                        {!! Form::radio('status', $key, null, ['class' => 'flat-red',$checked]) !!} <span style="margin-right: 10px">{{ $value }}</span>
                    </label>
                @endforeach
                <br class="statusError">
                @if ($errors->has('status'))
                    <span class="text-danger" id="statusError">
                        <strong>{{ $errors->first('status') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
