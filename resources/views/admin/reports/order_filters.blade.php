<div class="row">
    @if(isset($products))
        <div class="col-md-3">
            <div class="form-group">
                @include('admin.common.label', ['field' => 'product_id', 'labelText' => 'Product', 'isRequired' => false])

                {!! Form::select("product_id", ['' => 'Please Select'] + ($products->toArray() ?? []), null, ["class" => "form-control select2", "id" => "product_id"]) !!}           
            </div>
        </div>
    @endif

    @if(isset($users))
        <div class="col-md-3">
            <div class="form-group">
                @include('admin.common.label', ['field' => 'user_id', 'labelText' => 'User', 'isRequired' => false])

                {!! Form::select("user_id", ['' => 'Please Select'] + ($users->toArray() ?? []), null, ["class" => "form-control select2", "id" => "user_id"]) !!}           
            </div>
        </div>
    @endif

    <div class="col-md-3">
        <div class="form-group">
            @include('admin.common.label', ['field' => 'status', 'labelText' => 'Order Status', 'isRequired' => false])

            <select name="status" class="form-control" id="status">
                <option value="">Please Select</option>
                @foreach (\App\Models\Order::$allStatus as $key => $value)
                    <option value="{{ $key }}">{{ucfirst($value)}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            @include('admin.common.label', ['field' => 'daterange', 'labelText' => 'Date Ordered', 'isRequired' => false])

            {!! Form::text('daterange', null, ['class' => 'form-control', 'placeholder' => 'Please select']) !!}
        </div>
    </div>
    <div class="col-md-2" style="margin-top: 30px;">
        {!! Form::button('<i class="fa fa-times" aria-hidden="true"></i>', [
            'type' => 'button',
            'id' => 'clear-filter',
            'class' => 'btn btn-danger',
            'data-type' => $type
        ]) !!}
        
        {!! Form::button('<i class="fa fa-filter" aria-hidden="true"></i>', [
            'type' => 'button',
            'id' => 'apply-filter',
            'class' => 'btn btn-info',
            'data-type' => $type
        ]) !!}
    </div>
</div>