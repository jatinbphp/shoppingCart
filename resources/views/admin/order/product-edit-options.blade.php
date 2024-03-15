@if(count($product_options)>0)
<div class="row edit-option">
    @foreach ($product_options as $key => $option)
        @if(count($option->product_option_values)>0)
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                    @include('admin.common.label', ['field' => 'options', 'labelText' => $option->option_name, 'isRequired' => true])

                    @if($option->option_name=='COLOR')
                        <div id="options">
                            @foreach ($option->product_option_values as $key => $option_value)

                                {!! Form::radio('options['.$option->id.']', $option_value->id, null, ['id' => 'option_'.$option_value->id, 'required' => 'required', 'checked' => isset($option_value_id) && $option_value_id == $option_value->id ? true : false]) !!}

                                {!! Form::label('option_'.$option_value->id, Html::tag('span', '', ['class' => 'color-box', 'style' => 'background-color: '.$option_value->option_value]), [], false) !!}

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