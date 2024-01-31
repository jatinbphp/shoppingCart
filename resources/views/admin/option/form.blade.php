{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="control-label" for="name">Option Name :<span class="text-red">*</span></label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Option Name', 'id' => 'name']) !!}
            @if ($errors->has('name'))
                <span class="text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="col-md-12 control-label" for="status">Status :<span class="text-red">*</span></label>
            <div class="col-md-12">
                @foreach (\App\Models\Options::$status as $key => $value)
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

<!-- <div class="row" id="option_values_0">
    <div class="col-md-2">
        <div class="form-group{{ $errors->has('option_values') ? ' has-error' : '' }}">
            {!! Form::text("option_values[]", null, ['class' => 'form-control','required']) !!}
            @if ($errors->has('option_values'))
                <span class="text-danger">
                    <strong>{{ $errors->first('option_values') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-1">
        <button type="button" class="btn btn-info" id="optionVBtn"><i class="fa fa-plus"></i> </button>
    </div>
</div>
<div id="extraOption"></div>

@section('jquery')
<script type="text/javascript">
var optionValues = 0;

$('#optionVBtn').on('click', function(){
    optionValues = optionValues + 1;

    var exOptionContent = '<div class="row" id="option_values_'+optionValues+'">'+
        '<div class="col-md-2">'+
            '<div class="form-group">'+
                '<input type="text" name="option_values[]" class="form-control" required>'+
            '</div>'+
        '</div>'+
        '<div class="col-md-1">'+
            '<button type="button" class="btn btn-danger deleteExp" onClick="removeRow('+optionValues+')"><i class="fa fa-trash"></i></button>'+
        '</div>'+
        '</div>';
    $('#extraOption').append(exOptionContent);
});
</script>
@endsection -->