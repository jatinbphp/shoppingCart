{!! Form::hidden('redirects_to', URL::previous()) !!}
<style type="text/css">
.dataTables_length, #orderProductTable_filter, .dataTables_info, .dataTables_paginate{display: none;}
</style>
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
            <label class="control-label" for="user_id">Select User :<span class="text-red">*</span></label>
            <select id="user_id" name="user_id" class="form-control">
                <option value="">--Select User--</option>
                @foreach ($users as $key => $user)
                    <option value="{{$user->id}}">{{$user->name}} ({{$user->email}})</option>
                @endforeach
            </select>
            @if ($errors->has('user_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('address_id') ? ' has-error' : '' }}">
            <label class="control-label" for="address_id">Select User Address:<span class="text-red">*</span></label>
            <select id="address_id" name="address_id" class="form-control">
                <option value="">--Select Address--</option>
            </select>
            @if ($errors->has('address_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('address_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <input type="hidden" id="route_name" value="{{ route('orders.index_product') }}">
        <table id="orderProductTable" class="table table-bordered table-striped datatable-dynamic">
            <thead>
                <tr>
                    <th>Product</th>
                    <th style="width: 15%;">SKU</th>
                    <th style="width: 10%;">Quantity</th>
                    <th style="width: 15%;">Unit Price</th>
                    <th style="width: 15%;">Total</th>
                    <th style="width: 5%;">
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal" style="float: right;"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right" colspan="4">Sub-Total</th>
                    <td class="text-right" id="sub_total">0.00</td>
                    <td></td>
                </tr>
                <tr>
                    <th class="text-right" colspan="4">Total</th>
                    <td class="text-right" id="grand_total">0.00</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>  
    </div>

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('delivey_method') ? ' has-error' : '' }}">
            <label class="control-label" for="delivey_method">Delivey Method :<span class="text-red">*</span></label>
            <select name="delivey_method" class="form-control" id="delivey_method">
                @foreach (\App\Models\Order::$allDeliveryMethod as $key => $value)
                    <option value="{{ $key }}" class="flat-red">{{ $value }}</option>
                @endforeach
            </select>
            @if ($errors->has('delivey_method'))
                <span class="text-danger">
                    <strong>{{ $errors->first('delivey_method') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
            <label class="control-label" for="notes">Leave a message :<span class="text-red">*</span></label></br>
            <small>If you would like to add a comment about your order, please write it in the field below.</small>
            {!! Form::textarea('notes', null, ['class' => 'form-control', 'placeholder' => 'Enter Notes', 'id' => 'notes', 'rows' => '2']) !!}
            @if ($errors->has('notes'))
                <span class="text-danger">
                    <strong>{{ $errors->first('notes') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
@section('jquery')
<script type="text/javascript">
$(document).ready(function(){

    //Order Product Table 
    var orders_products_table = $('#orderProductTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [100, 200, 300, 400, 500],
        ajax: $("#route_name").val(),
        columns: [
            { data: 'product_name', name: 'product_name', orderable: false },
            { data: 'sku', name: 'sku', orderable: false },
            { data: 'quantity', name: 'quantity', orderable: false },
            { data: 'unit_price', name: 'unit_price', class: 'text-right', orderable: false },
            { data: 'total', name: 'total', class: 'text-right', orderable: false },
            { data: 'action', name: 'action', orderable: false },
        ],
        // Callback function after the table is drawn
        drawCallback: function(settings) {

            if (orders_products_table.data().length === 0) {
                $('#orderProductTable tfoot').hide()
            } else {
                $('#orderProductTable tfoot').show()
                var total = 0;
                orders_products_table.rows({page: 'current'}).every(function() {
                    total += parseFloat(this.data().total.replace(/[^\d.-]/g, ''));
                });

                var formattedTotal = total.toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD'
                });

                $('#sub_total, #grand_total').text(formattedTotal);
            }
        }
    });

    function reloadOrderProductsTable() {
        orders_products_table.ajax.reload(null, false);
    }

    // get product options
    $('#product_id').change(function(){
        // Call your function here
        var product_id = $(this).val();

        $.ajax({
            url: "{{route('products.getoptions')}}",
            type: "POST",
            data: {
                _token: '{{csrf_token()}}',
                'product_id': product_id,
             },
            success: function(data){                        
                $("#ajaxOption").html(data);
            }
        });
    });

    //get Addresses
    $('#user_id').change(function(){
        // Call your function here
        var user_id = $(this).val();
        if (user_id) {
            $.ajax({
                url: "{{ route('addresses.by_user', ':userId') }}".replace(':userId', user_id),
                type: "GET",
                data: {
                    _token: '{{csrf_token()}}',
                    'user_id': user_id,
                 },
                success: function(data){                        
                    $('#address_id').empty().append('<option value="">Select Address</option>');
                    data.forEach(function(address) {
                        $('#address_id').append('<option value="' + address.id + '">' + address.title + '</option>');
                    });
                }
            });
        } else {
            $('#address_id').empty().append('<option value="">Select Address</option>');
        }
    });

    // Add product in the Cart
    $(document).on("click", "#add_product", function(e) {
        e.preventDefault();
        var form = $(this).closest("form");

        $('.product_id').html('');
        $('.quantity').html('');
        $('.options_error').html('');

        // AJAX request
        $.ajax({
            url: form.attr("action"),
            type: 'POST',
            data: form.serialize(),
            success: function(response){
                $("#ajaxOption").empty();
                $('#myModal').modal('hide');
                $('#addProductForm')[0].reset(); // Resetting the form
                reloadOrderProductsTable();
                swal("Success", "Your product has been added to the order!", "success");
            },
            error: function(xhr, status, error){
                var errors = JSON.parse(xhr.responseText).errors;
                $.each(errors, function(key, value) {

                    if(key=='product_id' || key=='quantity'){
                        $('.'+key).html('<strong>' + value + '</strong>');
                    } else {
                        $('.options_error').html('<strong>All options field is required.</strong>');
                    }

                });
            }
        });
    });
});
</script>
@endsection