<div class="row mb-2">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            @include('common.label', ['field' => 'title', 'labelText' => 'Title', 'isRequired' => true])
            
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title']) !!}

            @include('common.errors', ['field' => 'title'])
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            @include('common.label', ['field' => 'first_name', 'labelText' => 'First Name', 'isRequired' => true])

            {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}

            @include('common.errors', ['field' => 'first_name'])
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            @include('common.label', ['field' => 'last_name', 'labelText' => 'Last Name', 'isRequired' => true])

            {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}

            @include('common.errors', ['field' => 'last_name'])
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            @include('common.label', ['field' => 'company', 'labelText' => 'Company', 'isRequired' => false])

            {!! Form::text('company', null, ['class' => 'form-control', 'placeholder' => 'Company Name (optional)']) !!}

            @include('common.errors', ['field' => 'company'])
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            @include('common.label', ['field' => 'mobile_phone', 'labelText' => 'Mobile Number', 'isRequired' => true])

            {!! Form::text('mobile_phone', null, ['class' => 'form-control', 'placeholder' => 'Mobile Number']) !!}

            @include('common.errors', ['field' => 'mobile_phone'])
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            @include('common.label', ['field' => 'address_line1', 'labelText' => 'Address', 'isRequired' => true])

            {!! Form::text('address_line1', null, ['class' => 'form-control', 'placeholder' => 'Address']) !!}

            @include('common.errors', ['field' => 'address_line1'])
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            @include('common.label', ['field' => 'address_line2', 'labelText' => 'Address (Line 2)', 'isRequired' => false])

            {!! Form::text('address_line2', null, ['class' => 'form-control', 'placeholder' => 'Address (Line 2)']) !!}
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            @include('common.label', ['field' => 'country', 'labelText' => 'Country', 'isRequired' => true])

            {!! Form::text('country', 'United Kingdom', ['class' => 'form-control', 'readonly' => 'true']) !!}

            @include('common.errors', ['field' => 'country'])
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            @include('common.label', ['field' => 'state', 'labelText' => 'State', 'isRequired' => true])
            
            {!! Form::text('state', null, ['class' => 'form-control', 'placeholder' => 'State']) !!}

            @include('common.errors', ['field' => 'state'])
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            @include('common.label', ['field' => 'city', 'labelText' => 'City', 'isRequired' => true])

            {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'City / Town']) !!}

            @include('common.errors', ['field' => 'city'])
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            @include('common.label', ['field' => 'pincode', 'labelText' => 'ZIP / Pincode', 'isRequired' => true])

            {!! Form::text('pincode', null, ['class' => 'form-control', 'placeholder' => 'Zip / Pincode']) !!}

            @include('common.errors', ['field' => 'pincode'])
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            @include('common.label', ['field' => 'additional_information', 'labelText' => 'Additional Information', 'isRequired' => false])
            
            {!! Form::textarea('additional_information', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>