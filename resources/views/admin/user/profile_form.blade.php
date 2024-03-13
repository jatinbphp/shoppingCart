<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'name', 'labelText' => 'Name', 'isRequired' => true])

            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}

            @include('admin.common.errors', ['field' => 'name'])
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'email', 'labelText' => 'Email Address', 'isRequired' => true])
            
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'email']) !!}

            @include('admin.common.errors', ['field' => 'email'])
        </div>
    </div>
    <div class="col-md-12">
        <div class="callout callout-danger">
            <h4><i class="fa fa-info"></i> Note:</h4>
            <p>Leave Password and Confirm Password empty if you are not going to change the password.</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'password', 'labelText' => 'Password', 'isRequired' => false])

            {!! Form::password('password', ['placeholder' => 'Password', 'id' => 'password', 'class' => 'form-control']) !!}
            
            @include('admin.common.errors', ['field' => 'password'])
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'password_confirmation', 'labelText' => 'Confirm Password', 'isRequired' => false])

            {!! Form::password('password_confirmation', ['placeholder' => 'Confirm password', 'id' => 'password-confirm', 'class' => 'form-control']) !!}
            
            @include('admin.common.errors', ['field' => 'password_confirmation'])
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'image', 'labelText' => 'Image', 'isRequired' => false])

            <div class="col-md-12">
                <div class="fileError">
                    {!! Form::file('image', ['class' => '', 'id'=> 'image','accept'=>'image/*', 'onChange'=>'AjaxUploadImage(this)']) !!}
                </div>

                @if(!empty($user['image']) && file_exists($user['image']))
                    <img src="{{asset($user['image'])}}" alt="User Image" style="border: 1px solid #ccc;margin-top: 5px;" width="150" id="DisplayImage">
                @else
                    <img src=" {{url('assets/admin/dist/img/no-image.png')}}" alt="User Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
                @endif
            </div>
        </div>
    </div>
</div>
