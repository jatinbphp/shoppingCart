@if(count($product_options)>0)
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 edit-option">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        {!! Html::tag('h5', 'Select Options', ['class' => 'modal-title']) !!}
                        <hr class="p-0 m-0">
                        <span class="text-danger options_error"></span>
                    </div>
                </div>
                <div class="row">
                    @foreach ($product_options as $key => $option)
                        @if(count($option->product_option_values)>0)
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                                    @include('admin.common.label', ['field' => 'title', 'labelText' => $option->option_name, 'isRequired' => true])

                                    @if($option->option_name=='COLOR')
                                        <div id="options" required="">
                                            @foreach ($option->product_option_values as $key => $option_value)
                                                <input type="radio" id="option_{{$option_value->id}}" name="options[{{$option->id}}]" value="{{$option_value->id}}" required @if($key==0) checked @endif>
                                                
                                                {!! Form::label('option_'.$option_value->id, Html::tag('span', '', ['class' => 'color-box', 'style' => 'background-color: '.$option_value->option_value]), [], false) !!}
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
        {!! Html::tag('span', 'Please add an option to the product. then after you can this product on the order.', ['class' => 'text-danger']) !!}
    </div>
@endif