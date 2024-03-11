<style type="text/css">
.color-box{display:inline-block;width:20px;height:20px;margin-right:5px;border:2px solid #ccc}
#options input[type="radio"]{display:none}
#options input[type="radio"] + label{cursor:pointer}
#options input[type="radio"]:checked + label .color-box{border-color:#000}
</style>

@if(count($product_options)>0)
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <p class="h5"><b>Select Options</b></p>
                        <hr class="p-0 m-0">
                        <span class="text-danger options_error"></span>
                    </div>
                </div>
                <div class="row">
                    @foreach ($product_options as $key => $option)
                        @if(count($option->product_option_values)>0)
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                                    <label class="control-label" for="options">{{$option->option_name}} :<span class="text-red">*</span></label>
                                    @if($option->option_name=='COLOR')
                                        <div id="options" required="">
                                            @foreach ($option->product_option_values as $key => $option_value)
                                                <input type="radio" id="option_{{$option_value->id}}" name="options[{{$option->id}}]" value="{{$option_value->id}}" required @if($key==0) checked @endif>
                                                
                                                <label for="option_{{$option_value->id}}">
                                                    <span class="color-box" style="background-color: {{$option_value->option_value}};"></span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @else
                                        <select id="options" name="options[{{$option->id}}]" class="form-control" required>
                                            <option value="">Please Select</option>
                                            @foreach ($option->product_option_values as $key => $option_value)
                                                <option value="{{$option_value->id}}">{{$option_value->option_value}}</option>
                                            @endforeach
                                        </select>
                                    @endif        
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <span class="text-danger">Please add an option to the product. then after you can this product on the order.</span>
    </div>
@endif