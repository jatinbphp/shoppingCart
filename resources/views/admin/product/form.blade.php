{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
            <label class="control-label" for="category_id">Select Category :<span class="text-red">*</span></label>

            <select id="category_id" name="category_id" class="form-control">
                <option value="">--Select Category--</option>
                @foreach ($categories as $key => $val)
                    @php $selected = isset($product) && $product->category_id == $val->id?'selected':''; @endphp
                    <option value="{{$val->id}}" {{$selected}}>{{$val->categoryName}}</option>
                @endforeach
            </select>

            @if ($errors->has('category_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('category_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
            <label class="control-label" for="product_name">Product Name :<span class="text-red">*</span></label>
            {!! Form::text('product_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Product Name', 'id' => 'product_name']) !!}
            @if ($errors->has('product_name'))
                <span class="text-danger">
                    <strong>{{ $errors->first('product_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
            <label class="control-label" for="sku">SKU :<span class="text-red">*</span></label>
            {!! Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'Enter SKU', 'id' => 'sku']) !!}
            @if ($errors->has('sku'))
                <span class="text-danger">
                    <strong>{{ $errors->first('sku') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="control-label" for="description">Description :<span class="text-red">*</span></label>
            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'description', 'rows' => '4']) !!}
            @if ($errors->has('description'))
                <span class="text-danger">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
            <label class="control-label" for="price">Price :<span class="text-red">*</span></label>
            {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Enter Price', 'id' => 'price']) !!}
            @if ($errors->has('price'))
                <span class="text-danger">
                    <strong>{{ $errors->first('price') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="col-md-12 control-label" for="status">Status :<span class="text-red">*</span></label>
            <div class="col-md-12">
                @foreach (\App\Models\Products::$status as $key => $value)
                        @php $checked = !isset($product) && $key == 'active'?'checked':''; @endphp
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
