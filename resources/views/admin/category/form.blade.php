{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('parent_category_id') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'parent_category_id', 'labelText' => 'Select Parent Category', 'isRequired' => false])

            {!! Form::select("parent_category_id", $categories, null, ["class" => "form-control"]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'name', 'labelText' => 'Name', 'isRequired' => true])

            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name', 'id' => 'name']) !!}
            
            @include('admin.common.errors', ['field' => 'name'])
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'image', 'labelText' => 'Image', 'isRequired' => false])

            <div class="">
                <div class="fileError">
                    {!! Form::file('image', ['class' => '', 'id'=> 'image','accept'=>'image/*', 'onChange'=>'AjaxUploadImage(this)']) !!}
                </div>

                @if(!empty($block['image']) && file_exists($block['image']))
                    <img src="{{asset($block['image'])}}" alt="Categrory Image" style="border: 1px solid #ccc;margin-top: 5px;" width="150" id="DisplayImage">
                @else
                    <img src=" {{url('assets/admin/dist/img/no-image.png')}}" alt="Categrory Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'status', 'labelText' => 'Status', 'isRequired' => true])

            <div class="">
                @foreach (\App\Models\Category::$status as $key => $value)
                    @php $checked = !isset($category) && $key == 'active'?'checked':''; @endphp
                    <label>
                        {!! Form::radio('status', $key, null, ['class' => 'flat-red',$checked]) !!} <span style="margin-right: 10px">{{ $value }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</div>
