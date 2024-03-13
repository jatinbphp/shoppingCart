{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'title', 'labelText' => 'Title', 'isRequired' => true])

            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'id' => 'title']) !!}

            @include('admin.common.errors', ['field' => 'title'])
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('subtitle') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'subtitle', 'labelText' => 'Subtitle', 'isRequired' => true])

            {!! Form::text('subtitle', null, ['class' => 'form-control', 'placeholder' => 'Enter Subtitle', 'id' => 'subtitle']) !!}

            @include('admin.common.errors', ['field' => 'subtitle'])
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'description', 'labelText' => 'Description', 'isRequired' => true])

            {!! Form::text('description', null, ['class' => 'form-control', 'id' => 'description']) !!}

            @include('admin.common.errors', ['field' => 'description'])            
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'image', 'labelText' => 'Image', 'isRequired' => true])

            <div class="">
                <div class="fileError">
                    {!! Form::file('image', ['class' => '', 'id'=> 'image','accept'=>'image/*', 'onChange'=>'AjaxUploadImage(this)']) !!}
                </div>

                @if(!empty($banner['image']) && file_exists($banner['image']))
                    <img src="{{asset($banner['image'])}}" alt="Banner Image" style="border: 1px solid #ccc;margin-top: 5px;" width="150" id="DisplayImage">
                @else
                    <img src=" {{url('assets/admin/dist/img/no-image.png')}}" alt="Banner Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
                @endif
                </br>
                @include('admin.common.errors', ['field' => 'image'])
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'status', 'labelText' => 'Status', 'isRequired' => true])

            <div class="">
                @foreach (\App\Models\Banner::$status as $key => $value)
                    @php $checked = !isset($banner) && $key == 'active'?'checked':''; @endphp
                    <label>
                        {!! Form::radio('status', $key, null, ['class' => 'flat-red',$checked]) !!} <span style="margin-right: 10px">{{ $value }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</div>