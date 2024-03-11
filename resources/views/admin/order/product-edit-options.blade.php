<style type="text/css">
.color-box{display:inline-block;width:20px;height:20px;margin-right:5px;border:2px solid #ccc}
#options input[type="radio"]{display:none}
#options input[type="radio"] + label{cursor:pointer}
#options input[type="radio"]:checked + label .color-box{border-color:#000}
</style>

@if(count($product_options)>0)
<div class="row">
    @foreach ($product_options as $key => $option)
        @if(count($option->product_option_values)>0)
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                    <label class="control-label" for="options">{{$option->option_name}} :<span class="text-red">*</span></label>
                    @if($option->option_name=='COLOR')
                        <div id="options">
                            @foreach ($option->product_option_values as $key => $option_value)
                                <input type="radio" id="option_{{$option_value->id}}" name="options[{{$option->id}}]" value="{{$option_value->id}}" required @if(isset($option_value_id) && !empty($option_value_id)) @if($option_value_id==$option_value->id) {{'checked'}} @endif @endif>
                                <label for="option_{{$option_value->id}}">
                                    <span class="color-box" style="background-color: {{$option_value->option_value}};"></span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <select id="options" name="options[{{$option->id}}]" class="form-control" required>
                            @foreach ($option->product_option_values as $key => $option_value)
                                <option value="{{$option_value->id}}" @if(isset($option_value_id) && !empty($option_value_id)) @if($option_value_id==$option_value->id) {{'selected'}} @endif @endif>{{$option_value->option_value}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>
@endif