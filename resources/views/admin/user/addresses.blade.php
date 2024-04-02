<div class="card user-addresses" id="address_{{ $addressCounter }}">
    <div class="row p-2">
        
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-11">
                    <div class="form-group">
                        <label class="control-label" for="title">Title :<span class="text-red">*</span></label>
                        <input type="text" name="addresses[new][{{ $addressCounter }}][title]" class="form-control" required- placeholder="Enter Title">
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger" onClick="removeAddressRow({{ $addressCounter }}, 0)" style="margin-top: 30px;"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="first_name">First Name :<span class="text-red">*</span></label>
                <input type="text" name="addresses[new][{{ $addressCounter }}][first_name]" class="form-control" required- placeholder="Enter First Name">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="last_name">Last Name :<span class="text-red">*</span></label>
                <input type="text" name="addresses[new][{{ $addressCounter }}][last_name]" class="form-control" required- placeholder="Enter Last Name">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="company">Company :<span class="text-red">*</span></label>
                <input type="text" name="addresses[new][{{ $addressCounter }}][company]" class="form-control" required- placeholder="Enter Company">
            </div>
        </div>
            
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="mobile_phone">Mobile No :<span class="text-red">*</span></label>
                <input type="text" name="addresses[new][{{ $addressCounter }}][mobile_phone]" class="form-control" required- placeholder="Enter Mobile No">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="address_line1">Address :<span class="text-red">*</span></label>
                <textarea name="addresses[new][{{ $addressCounter }}][address_line1]" class="form-control" required- placeholder="Enter Address" rows="2"></textarea>
            </div>
        </div>
               
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="address_line2">Address (Line 2) :</label>
                <textarea name="addresses[new][{{ $addressCounter }}][address_line2]" class="form-control" required- placeholder="Enter Address Line 2" rows="2"></textarea>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="pincode">ZIP / Pincode :<span class="text-red">*</span></label>
                <input type="text" name="addresses[new][{{ $addressCounter }}][pincode]" class="form-control" required- placeholder="Enter ZIP / Pincode">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="country">Country :<span class="text-red">*</span></label>
                <input type="text" name="addresses[new][{{ $addressCounter }}][country]" class="form-control" required- placeholder="Enter Country" value="United Kingdom" readonly>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="state">State :<span class="text-red">*</span></label>
                <input type="text" name="addresses[new][{{ $addressCounter }}][state]" class="form-control" required- placeholder="Enter State">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="city">City / Town :<span class="text-red">*</span></label>
                <input type="text" name="addresses[new][{{ $addressCounter }}][city]" class="form-control" required- placeholder="Enter City / Town">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label" for="additional_information">Additional Information :</label>
                <textarea name="addresses[new][{{ $addressCounter }}][additional_information]" class="form-control" required- placeholder="Enter Additional Information" rows="2"></textarea>
            </div>
        </div>
    </div>
</div>