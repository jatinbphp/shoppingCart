<div class="row">

    @if(isset($products))
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="product_id">Product :<span class="text-red d-none">*</span></label> 
                {!! Form::select("product_id", ['' => 'Please Select'] + ($products->toArray() ?? []), null, ["class" => "form-control select2", "id" => "product_id"]) !!}           
            </div>
        </div>
    @endif

    @if(isset($users))
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="user_id">User :<span class="text-red d-none">*</span></label> 
                {!! Form::select("user_id", ['' => 'Please Select'] + ($users->toArray() ?? []), null, ["class" => "form-control select2", "id" => "user_id"]) !!}           
            </div>
        </div>
    @endif

    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" for="status">Order Status :<span class="text-red d-none">*</span></label>
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
            <label class="control-label" for="daterange">Date Ordered :<span class="text-red d-none">*</span></label>
            <input class="form-control" type="text" name="daterange" placeholder="Please select" />
        </div>
    </div>
    <div class="col-md-2" style="margin-top: 30px;">
        <button type="button" id="clear-filter" class="btn btn-danger" data-type="{{$type}}"><i class="fa fa-times" aria-hidden="true"></i></button>
        <button type="button" id="apply-filter" class="btn btn-info" data-type="{{$type}}"><i class="fa fa-filter" aria-hidden="true"></i></button>
    </div>
</div>