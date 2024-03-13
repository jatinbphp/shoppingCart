{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'title', 'labelText' => 'Title', 'isRequired' => true])

            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'id' => 'title']) !!}

            @include('admin.common.errors', ['field' => 'title'])
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'description', 'labelText' => 'Description', 'isRequired' => true])

            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'description']) !!}

            @include('admin.common.errors', ['field' => 'description'])
        </div>
    </div>
</div>