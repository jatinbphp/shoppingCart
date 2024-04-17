{!! Form::label($field, $labelText . ' :', ['class' => 'text-dark ft-medium']) !!}
@if($isRequired)
    <span class="text-red">*</span>
@endif