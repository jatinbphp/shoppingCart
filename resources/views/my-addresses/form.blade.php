<div class="row mb-2">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <label class="text-dark">First Name *</label>
            {!! Form::text('first_name', $user_addresses->first_name ?? null, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
            @error('first_name')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <label class="text-dark">Last Name *</label>
            {!! Form::text('last_name', $user_addresses->last_name ?? null, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
            @error('first_name')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-none">
        <div class="form-group">
            <label class="text-dark">Email *</label>
            {!! Form::email('email', $user_addresses->email ?? null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
            @error('email')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label class="text-dark">Company</label>
            {!! Form::text('company', $user_addresses->company ?? null, ['class' => 'form-control', 'placeholder' => 'Company Name (optional)']) !!}
            @error('company')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label class="text-dark">Address 1 *</label>
            {!! Form::text('address_line1', old('address_line1', $user_addresses->address_line1 ?? null), ['class' => 'form-control', 'placeholder' => 'Address 1']) !!}
            @error('address_line1')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label class="text-dark">Address 2</label>
            {!! Form::text('address_line2', old('address_line2', $user_addresses->address_line2 ?? null), ['class' => 'form-control', 'placeholder' => 'Address 2 (optional)']) !!}
            @error('address_line2')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label class="text-dark">Country *</label>
            {!! Form::select('country', [
                'United Kingdom' => 'United Kingdom',
            ], old('country', $user_addresses->country ?? null), ['class' => 'custom-select']) !!}
            @error('country')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label class="text-dark">State *</label>
            {!! Form::text('state', old('state', $user_addresses->state ?? null), ['class' => 'form-control', 'placeholder' => 'State']) !!}
            @error('state')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label class="text-dark">City / Town *</label>
            {!! Form::text('city', old('city', $user_addresses->city ?? null), ['class' => 'form-control', 'placeholder' => 'City / Town']) !!}
            @error('city')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label class="text-dark">ZIP / Postcode *</label>
            {!! Form::text('pincode', old('pincode', $user_addresses->pincode ?? null), ['class' => 'form-control', 'placeholder' => 'Zip / Postcode']) !!}
            @error('pincode')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label class="text-dark">Mobile Number *</label>
            {!! Form::text('mobile_phone', old('mobile_phone', $user_addresses->mobile_phone ?? null), ['class' => 'form-control', 'placeholder' => 'Mobile Number']) !!}
            @error('mobile_phone')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            {!! Form::checkbox('is_default', 1, $user_addresses->is_default ?? null, ['id' => 'delivery', 'class' => 'checkbox-custom']) !!}
            <label for="delivery" class="checkbox-custom-label">Set Default delivery address</label>
            @error('is_default')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>