@if(count($product_options)>0)
<div class="row">
    @foreach ($product_options as $key => $option)
        @if(count($option->product_option_values)>0)
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                    <label class="control-label" for="options">{{$option->option_name}} :<span class="text-red">*</span></label>
                    <select id="options" name="options[{{$option->id}}]" class="form-control" required>
                        @foreach ($option->product_option_values as $key => $option_value)
                            <option value="{{$option_value->id}}" @if(isset($option_value_id) && !empty($option_value_id)) @if($option_value_id==$option_value->id) {{'selected'}} @endif @endif>{{$option_value->option_value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                
        @endif
    @endforeach
</div>
@endif