<ul class="nav nav-tabs" id="myTabs">
    <li class="nav-item">
        <a class="nav-link active" id="tab1" data-toggle="tab" href="#content1">General Information</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(!isset($users)) disabled @endif" id="tab2" data-toggle="tab" href="#content2">Addresses</a>
    </li>
</ul>

{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="tab-content mt-2">
    <div class="row tab-pane fade show active" id="content1">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('categories_id') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'categories_id', 'labelText' => 'Which categories of products do you want to see?', 'isRequired' => false])

                                {!! Form::select("categories_id[]", $categories, !empty($users['categories_id']) ? explode(",", $users['categories_id']) : null, ["class" => "form-control select2", "id" => "categories_id", "multiple" => "true", 'data-placeholder' => 'Please Select']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'name', 'labelText' => 'Name', 'isRequired' => true])

                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name', 'id' => 'name']) !!}

                                @include('admin.common.errors', ['field' => 'name'])
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'email', 'labelText' => 'Email Address', 'isRequired' => true])

                                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email', 'id' => 'email']) !!}

                                @include('admin.common.errors', ['field' => 'email'])
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'phone', 'labelText' => 'Phone Number', 'isRequired' => true])

                                {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Enter Phone Number', 'id' => 'phone']) !!}

                                @include('admin.common.errors', ['field' => 'phone'])
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="callout callout-danger">
                                <h4><i class="fa fa-info"></i> Note:</h4>
                                <p>Leave Password and Confirm Password empty if you are not going to change the password.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                {!! Form::label('password', 'Password :', ['class' => 'control-label']) !!}@if (empty($users))<span class="text-red">*</span>@endif

                                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter Password', 'id' => 'password']) !!}

                                @include('admin.common.errors', ['field' => 'password'])
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                {!! Form::label('password_confirmation', 'Confirm Password :', ['class' => 'control-label']) !!}@if (empty($users))<span class="text-red">*</span>@endif

                                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm password', 'id' => 'password-confirm']) !!}

                                @include('admin.common.errors', ['field' => 'password_confirmation'])
                            </div>
                        </div>                    
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'image', 'labelText' => 'Image', 'isRequired' => false])

                                <div class="">
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
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'status', 'labelText' => 'Status', 'isRequired' => true])

                                <div class="">
                                    @foreach (\App\Models\User::$status as $key => $value)
                                        @php $checked = !isset($users) && $key == 'active'?'checked':''; @endphp
                                        <label>
                                            {!! Form::radio('status', $key, null, ['class' => 'flat-red',$checked]) !!} <span style="margin-right: 10px">{{ $value }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
    $addressesCounter = 1;
    @endphp
    <div class="row tab-pane fade" id="content2">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <h5>Add Addresses
                                {!! Form::button('<i class="fa fa-plus"></i> Add New', [
                                    'type' => 'button',
                                    'class' => 'btn btn-info btn-sm',
                                    'id' => 'addressBtn',
                                    'style' => 'float: right;'
                                ]) !!}
                            </h5>
                        </div>
                    </div>
                    @if(count($user_addresses)>0)
                        @foreach ($user_addresses as $key => $address) 
                            <div class="card user-addresses" id="address_{{ $address->id }}">
                                <div class="row p-2">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                                    @include('admin.common.label', ['field' => 'title', 'labelText' => 'Title', 'isRequired' => true])

                                                    {!! Form::text("addresses[old][$address->id][title]", $address->title, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'id' => 'title']) !!}
                                                    
                                                    @include('admin.common.errors', ['field' => 'title'])
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                {!! Form::button('<i class="fa fa-trash"></i>', [
                                                    'type' => 'button',
                                                    'class' => 'btn btn-danger',
                                                    'onclick' => 'removeAddressRow(' . $address->id . ', 0)',
                                                    'style' => 'margin-top: 30px;'
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                            @include('admin.common.label', ['field' => 'first_name', 'labelText' => 'First Name', 'isRequired' => true])

                                            {!! Form::text("addresses[old][$address->id][first_name]", $address->first_name, ['class' => 'form-control', 'placeholder' => 'Enter First Name', 'id' => 'first_name']) !!}
                                            
                                            @include('admin.common.errors', ['field' => 'first_name'])
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                            @include('admin.common.label', ['field' => 'last_name', 'labelText' => 'Last Name', 'isRequired' => true])

                                            {!! Form::text("addresses[old][$address->id][last_name]", $address->last_name, ['class' => 'form-control', 'placeholder' => 'Enter Last Name', 'id' => 'last_name']) !!}
                                                
                                            @include('admin.common.errors', ['field' => 'last_name'])
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                                            @include('admin.common.label', ['field' => 'company', 'labelText' => 'Company', 'isRequired' => false])

                                            {!! Form::text("addresses[old][$address->id][company]", $address->company, ['class' => 'form-control', 'placeholder' => 'Enter Company', 'id' => 'company']) !!}
                                            
                                            @include('admin.common.errors', ['field' => 'first_name'])
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('mobile_phone') ? ' has-error' : '' }}">
                                            @include('admin.common.label', ['field' => 'mobile_phone', 'labelText' => 'Mobile No', 'isRequired' => true])

                                            {!! Form::text("addresses[old][$address->id][mobile_phone]", $address->mobile_phone, ['class' => 'form-control', 'placeholder' => 'Enter Mobile No', 'id' => 'mobile_phone']) !!}
                                            
                                            @include('admin.common.errors', ['field' => 'mobile_phone'])
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('address_line1') ? ' has-error' : '' }}">
                                            @include('admin.common.label', ['field' => 'address_line1', 'labelText' => 'Address', 'isRequired' => true])

                                            {!! Form::textarea("addresses[old][$address->id][address_line1]", $address->address_line1, ['class' => 'form-control', 'placeholder' => 'Enter Address', 'id' => 'address_line1', 'rows' => '2']) !!}
                                            
                                            @include('admin.common.errors', ['field' => 'address_line1'])
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('address_line2') ? ' has-error' : '' }}">
                                            @include('admin.common.label', ['field' => 'address_line2', 'labelText' => 'Address (Line 2)', 'isRequired' => false])

                                            {!! Form::textarea("addresses[old][$address->id][address_line2]", $address->address_line2, ['class' => 'form-control', 'placeholder' => 'Enter Address Line 2', 'id' => 'address_line2', 'rows' => '2']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('pincode') ? ' has-error' : '' }}">
                                            @include('admin.common.label', ['field' => 'pincode', 'labelText' => 'ZIP / Pincode', 'isRequired' => true])

                                            {!! Form::text("addresses[old][$address->id][pincode]", $address->pincode, ['class' => 'form-control', 'placeholder' => 'Enter ZIP / Pincode', 'id' => 'pincode']) !!}
                                            
                                            @include('admin.common.errors', ['field' => 'pincode'])
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                            @include('admin.common.label', ['field' => 'country', 'labelText' => 'Country', 'isRequired' => true])

                                            {!! Form::text("addresses[old][$address->id][country]", 'United Kingdom', ['class' => 'form-control', 'placeholder' => 'Enter Country', 'id' => 'country', 'readonly']) !!}
                                            
                                            @include('admin.common.errors', ['field' => 'country'])
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                            @include('admin.common.label', ['field' => 'state', 'labelText' => 'State', 'isRequired' => true])

                                            {!! Form::text("addresses[old][$address->id][state]", $address->state, ['class' => 'form-control', 'placeholder' => 'Enter State', 'id' => 'state']) !!}
                                            
                                            @include('admin.common.errors', ['field' => 'state'])
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                            @include('admin.common.label', ['field' => 'city', 'labelText' => 'City / Town', 'isRequired' => true])


                                            {!! Form::text("addresses[old][$address->id][city]", $address->city, ['class' => 'form-control', 'placeholder' => 'Enter City / Town', 'id' => 'city']) !!}
                                            
                                            @include('admin.common.errors', ['field' => 'city'])
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('additional_information') ? ' has-error' : '' }}">
                                            @include('admin.common.label', ['field' => 'additional_information', 'labelText' => 'Additional Information', 'isRequired' => false])

                                            {!! Form::textarea("addresses[old][$address->id][additional_information]", $address->additional_information, ['class' => 'form-control', 'placeholder' => 'Enter Additional Information', 'id' => 'additional_information', 'rows' => '2']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                            $addressesCounter = $address->id;
                            @endphp
                        @endforeach
                    @else
                        <div class="card user-addresses" id="address_1">
                            <div class="row p-2">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">

                                        @include('admin.common.label', ['field' => 'title', 'labelText' => 'Title', 'isRequired' => true])

                                        {!! Form::text('addresses[new][1][title]', null, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'id' => 'title']) !!}

                                        @include('admin.common.errors', ['field' => 'title'])
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'first_name', 'labelText' => 'First Name', 'isRequired' => true])

                                        {!! Form::text('addresses[new][1][first_name]', null, ['class' => 'form-control', 'placeholder' => 'Enter First Name', 'id' => 'first_name']) !!}
                                        
                                        @include('admin.common.errors', ['field' => 'first_name'])
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'last_name', 'labelText' => 'Last Name', 'isRequired' => true])

                                        {!! Form::text('addresses[new][1][last_name]', null, ['class' => 'form-control', 'placeholder' => 'Enter Last Name', 'id' => 'last_name']) !!}
                                        
                                        @include('admin.common.errors', ['field' => 'last_name'])
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'company', 'labelText' => 'Company', 'isRequired' => false])

                                        {!! Form::text('addresses[new][1][company]', null, ['class' => 'form-control', 'placeholder' => 'Enter Company', 'id' => 'company']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group{{ $errors->has('mobile_phone') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'mobile_phone', 'labelText' => 'Mobile No', 'isRequired' => true])

                                        {!! Form::text('addresses[new][1][mobile_phone]', null, ['class' => 'form-control', 'placeholder' => 'Enter Mobile No', 'id' => 'mobile_phone']) !!}
                                        
                                        @include('admin.common.errors', ['field' => 'mobile_phone'])
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('address_line1') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'address_line1', 'labelText' => 'Address', 'isRequired' => true])

                                        {!! Form::textarea('addresses[new][1][address_line1]', null, ['class' => 'form-control', 'placeholder' => 'Enter Address', 'id' => 'address_line1', 'rows' => '2']) !!}

                                        @include('admin.common.errors', ['field' => 'address_line1'])
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('address_line2') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'address_line2', 'labelText' => 'Address (Line 2)', 'isRequired' => false])

                                        {!! Form::textarea('addresses[new][1][address_line2]', null, ['class' => 'form-control', 'placeholder' => 'Enter Address Line 2', 'id' => 'address_line2', 'rows' => '2']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group{{ $errors->has('pincode') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'pincode', 'labelText' => 'ZIP / Pincode', 'isRequired' => true])

                                        {!! Form::text('addresses[new][1][pincode]', null, ['class' => 'form-control', 'placeholder' => 'Enter ZIP / Pincode', 'id' => 'pincode']) !!}

                                        @include('admin.common.errors', ['field' => 'pincode'])
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'country', 'labelText' => 'Country', 'isRequired' => true])

                                        {!! Form::text('addresses[new][1][country]', 'United Kingdom', ['class' => 'form-control', 'placeholder' => 'Enter Country', 'id' => 'country', 'readonly']) !!}
                                        
                                        @include('admin.common.errors', ['field' => 'country'])
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'state', 'labelText' => 'State', 'isRequired' => true])

                                        {!! Form::text('addresses[new][1][state]', null, ['class' => 'form-control', 'placeholder' => 'Enter State', 'id' => 'state']) !!}

                                        @include('admin.common.errors', ['field' => 'state'])
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'city', 'labelText' => 'City / Town', 'isRequired' => true])

                                        {!! Form::text('addresses[new][1][city]', null, ['class' => 'form-control', 'placeholder' => 'Enter City / Town', 'id' => 'city']) !!}

                                        @include('admin.common.errors', ['field' => 'city'])
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('additional_information') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'additional_information', 'labelText' => 'Additional Information', 'isRequired' => false])

                                        {!! Form::textarea('addresses[new][1][additional_information]', null, ['class' => 'form-control', 'placeholder' => 'Enter Additional Information', 'id' => 'additional_information', 'rows' => '2']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="extraAddress"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('jquery')
<script type="text/javascript">
var addressCounter = {{$addressesCounter}};

$('#addressBtn').on('click', function(){
    addressCounter = addressCounter + 1;

    var exAddressContent = '<div class="card user-addresses" id="address_'+addressCounter+'">'+
            '<div class="row p-2">'+
                
                '<div class="col-md-12">'+
                    '<div class="row">'+
                        '<div class="col-md-11">'+
                            '<div class="form-group">'+
                                '<label class="control-label" for="title">Title :<span class="text-red">*</span></label>'+
                                '<input type="text" name="addresses[new]['+addressCounter+'][title]" class="form-control" required- placeholder="Enter Title">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-1">'+
                            '<button type="button" class="btn btn-danger" onClick="removeAddressRow('+addressCounter+', 0)" style="margin-top: 30px;"><i class="fa fa-trash"></i></button>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="first_name">First Name :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][first_name]" class="form-control" required- placeholder="Enter First Name">'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="last_name">Last Name :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][last_name]" class="form-control" required- placeholder="Enter Last Name">'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="company">Company :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][company]" class="form-control" required- placeholder="Enter Company">'+
                    '</div>'+
                '</div>'+
                    
                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="mobile_phone">Mobile No :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][mobile_phone]" class="form-control" required- placeholder="Enter Mobile No">'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="address_line1">Address :<span class="text-red">*</span></label>'+
                        '<textarea name="addresses[new]['+addressCounter+'][address_line1]" class="form-control" required- placeholder="Enter Address" rows="2"></textarea>'+
                    '</div>'+
                '</div>'+
                       
                '<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="address_line2">Address (Line 2) :</label>'+
                        '<textarea name="addresses[new]['+addressCounter+'][address_line2]" class="form-control" required- placeholder="Enter Address Line 2" rows="2"></textarea>'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="pincode">ZIP / Pincode :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][pincode]" class="form-control" required- placeholder="Enter ZIP / Pincode">'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="country">Country :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][country]" class="form-control" required- placeholder="Enter Country" value="United Kingdom" readonly>'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="state">State :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][state]" class="form-control" required- placeholder="Enter State">'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="city">City / Town :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][city]" class="form-control" required- placeholder="Enter City / Town">'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-12">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="additional_information">Additional Information :</label>'+
                        '<textarea name="addresses[new]['+addressCounter+'][additional_information]" class="form-control" required- placeholder="Enter Additional Information" rows="2"></textarea>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>';
    $('#extraAddress').append(exAddressContent);
});


function removeAddressRow(divId, type){
    const removeRowAlert = createAddressAlert("Are you sure?", "Do want to delete this row", "warning");
    swal(removeRowAlert, function(isConfirm) {
        if (isConfirm) {
            var flag =  deleteRow(divId, type);
            if(flag){
                swal.close();
            }
        } else{
             swal("Cancelled", "Your data safe!", "error");
        }
    });
}

//remove the row
function deleteRow(divId, type){
    $('#address_'+divId).remove();
    if ($(".user-addresses").length == 0) {
        $('#addressBtn').click();
    }
    return 1;  
}

function createAddressAlert(title, text, type) {
    return {
        title: title,
        text: text,
        type: type,
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: "No, cancel",
        closeOnConfirm: false,
        closeOnCancel: false
    };
}

$(function() {
    $(document).on("change",".uploadFile", function(){
        var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
            }
        }
    });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection