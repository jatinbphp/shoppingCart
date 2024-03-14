<div class="row mb-2">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::label('title', 'Title :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title']) !!}
            @error('title')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::label('first_name', 'First Name :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>
            {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
            @error('first_name')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::label('last_name', 'Last Name :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>
            {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
            @error('first_name')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::label('company', 'Company :', ['class' => 'text-dark ft-medium']) !!}
            {!! Form::text('company', null, ['class' => 'form-control', 'placeholder' => 'Company Name (optional)']) !!}
            @error('company')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::label('mobile_phone', 'Mobile Number :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>
            {!! Form::text('mobile_phone', null, ['class' => 'form-control', 'placeholder' => 'Mobile Number']) !!}
            @error('mobile_phone')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::label('address_line1', 'Address :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>
            {!! Form::text('address_line1', null, ['class' => 'form-control', 'placeholder' => 'Address']) !!}
            @error('address_line1')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::label('address_line2', 'Address (Line 2) :', ['class' => 'text-dark ft-medium']) !!}
            {!! Form::text('address_line2', null, ['class' => 'form-control', 'placeholder' => 'Address (Line 2)']) !!}
            @error('address_line2')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::label('country', 'Country :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>
            {!! Form::text('country', 'United Kingdom', ['class' => 'form-control', 'readonly' => 'true']) !!}
            @error('country')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::label('state', 'State :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>
            {!! Form::text('state', null, ['class' => 'form-control', 'placeholder' => 'State']) !!}
            @error('state')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::label('city', 'City / Town :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>
            {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'City / Town']) !!}
            @error('city')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::label('pincode', 'ZIP / Pincode :', ['class' => 'text-dark ft-medium']) !!}<span class="text-red">*</span>
            {!! Form::text('pincode', null, ['class' => 'form-control', 'placeholder' => 'Zip / Pincode']) !!}
            @error('pincode')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::label('additional_information', 'Additional Information :', ['class' => 'text-dark ft-medium']) !!}
            {!! Form::textarea('additional_information', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>