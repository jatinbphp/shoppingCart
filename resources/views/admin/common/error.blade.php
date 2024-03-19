@if(Session::has('success'))
    <div class="alert alert-success">
        {!! Form::button('&times;', [
            'class' => 'close',
            'data-dismiss' => 'alert'
        ]) !!}
        {{Session::get('success')}}
    </div>
@elseif(Session::has('danger'))
    <div class="alert alert-danger">
        {!! Form::button('&times;', [
            'class' => 'close',
            'data-dismiss' => 'alert'
        ]) !!}
        {{Session::get('danger')}}
    </div>
@elseif(Session::has('warning'))
    <div class="alert alert-warning">
        {!! Form::button('&times;', [
            'class' => 'close',
            'data-dismiss' => 'alert'
        ]) !!}
        {{Session::get('warning')}}
    </div>
@endif