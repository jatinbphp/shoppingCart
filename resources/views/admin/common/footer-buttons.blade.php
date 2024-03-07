<a href="{{ route($route) }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left pr-1"></i> Back</a>

@if($type=="update")
{!! Form::button('<i class="fa fa-edit pr-1"></i> Update', ['class' => 'btn btn-sm btn-info float-right', 'type' => 'submit']) !!}
@else
{!! Form::button('<i class="fa fa-save pr-1"></i> Save', ['class' => 'btn btn-sm btn-info float-right', 'type' => 'submit']) !!}
@endif