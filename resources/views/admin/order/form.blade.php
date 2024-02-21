{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
            <label class="control-label" for="user_id">Select User :<span class="text-red">*</span></label>
            {!! Form::select("user_id", $users, null, ["class" => "form-control select2", "id" => "user_id"]) !!}
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
            {!! Form::select("address_id", ['' => 'Please Select'], null, ["class" => "form-control select2", "id" => "address_id"]) !!}
            @if ($errors->has('address_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('address_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <input type="hidden" id="route_name" value="{{ route('orders.index_product') }}">
        <input type="hidden" id="order_id" name="order_id" value="{{ isset($order) ? $order->id : 0}}">
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
                    <th class="text-right" colspan="4">Sub-Total :</th>
                    <td class="text-right" id="sub_total">0.00</td>
                    <td></td>
                </tr>
                <tr>
                    <th class="text-right" colspan="4">Total :</th>
                    <td class="text-right" id="grand_total">0.00</td>
                    <td></td>
                </tr>
            </tfoot>
        </table> 
         
    </div>

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('address_id') ? ' has-error' : '' }}">
            {!! Form::hidden('products', null, ['class' => 'form-control', 'id' => 'products']) !!}
            @if ($errors->has('products'))
                <span class="text-danger">
                    <strong>{{ $errors->first('products') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="control-label" for="status">Select Status :<span class="text-red">*</span></label>
            <select name="status" class="form-control" id="status">
                @foreach (\App\Models\Order::$allStatus as $key => $value)
                    <option value="{{ $value }}" class="flat-red">{{ucfirst($value)}}</option>
                @endforeach
            </select>
            @if ($errors->has('status'))
                <span class="text-danger">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('delivey_method') ? ' has-error' : '' }}">
            <label class="control-label" for="delivey_method">Select Delivey Method :<span class="text-red">*</span></label>
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
            <label class="control-label w-100" for="notes">Leave a message :</label>
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

    var isFirstLoad = true;

    //Order Product Table 
    var orders_products_table = $('#orderProductTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false, // Hide search box
        paging: false, // Hide pagination
        info: false, // Hide information about number of records
        ajax: {
            url: $("#route_name").val(),
            type: "GET",
            data: function(d) {
                // Pass order_id based on isFirstLoad
                d.first_time_load = isFirstLoad ? 0 : 1,
                d.order_id = $("#order_id").val();
            }
        },
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
                $("#products").val();
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

                $("#products").val(1);
            }

            // After the first load, set isFirstLoad to false
            isFirstLoad = false;
        }
    });

    //Delete Record
    $('.datatable-dynamic tbody').on('click', '.deleteCartRecord', function (event) {
        event.preventDefault();
        var id = $(this).attr("data-id");

        swal({
            title: "Are you sure?",
            text: "You want to delete this record?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "{{ route('orders.delete_product', [':cart_id']) }}".replace(':cart_id', id),
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    success: function(data){
                        reloadOrderProductsTable();
                        swal("Deleted", "Your data successfully deleted!", "success");
                    }
                });
            } else {
                swal("Cancelled", "Your data safe!", "error");
            }
        });
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

    if($("#user_id").val()){
        setTimeout(function(){
            $('#user_id').val($("#user_id").val()).trigger('change');

            @if(isset($order->id))
                setTimeout(function() {
                    $('#address_id').val({{ $order->address_id}}).trigger('change');
                }, 500);
            @endif
        }, 500);
    }

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
                    $('#address_id').empty().append('<option value="">Please Select</option>');
                    $('#address_id').select2('destroy').select2();
                    data.forEach(function(address) {
                        $('#address_id').append('<option value="' + address.id + '">' + address.title + '</option>');
                    });
                }
            });
        } else {
            $('#address_id').empty().append('<option value="">Please Select</option>');
            $('#address_id').select2('destroy').select2();
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

    $(document).on("click", "#plus", function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var quantityInput = $('#quantity'+id);
        var currentValue = parseInt(quantityInput.val());
        quantityInput.val(currentValue + 1);
        updateQty(id, 2);
    });

    $(document).on("click", "#minus", function(e) {
        var id = $(this).data("id");
        var quantityInput = $('#quantity'+id);
        var currentValue = parseInt(quantityInput.val());
        if (currentValue > 1) {
            quantityInput.val(currentValue - 1);
            updateQty(id, 1);
        }
    });

    function updateQty(id, type) {
        $.ajax({
            url: "{{ route('orders.update_qty') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                type: type
            },
            success: function(data) {                        
                reloadOrderProductsTable();
            }
        });
    }


    //Edit Option
    $('.datatable-dynamic tbody').on('click', '.editOption', function (event) {
        event.preventDefault();
        var option_id = $(this).attr("data-option_id");
        var option_value_id = $(this).attr("data-option_value_id");
        var product_id = $(this).attr("data-product_id");
        var id = $(this).attr("data-id");

        $('#edit_cart_id').val(id);
        $('#edit_option_id').val(option_id);
        $('#edit_product_id').val(product_id);

        $.ajax({
            url: "{{route('products.editoption')}}",
            type: "POST",
            data: {
                _token: '{{csrf_token()}}',
                'product_id': product_id,
                'option_value_id': option_value_id,
                'option_id': option_id,
                'cart_id': id,
             },
            success: function(data){          
                $('#myOptionModal').modal('show');              
                $("#ajaxEditOption").html(data);
            }
        });
    });

    // edit product option in the Cart
    $(document).on("click", "#edit_product", function(e) {
        e.preventDefault();
        var form = $(this).closest("form");

        // AJAX request
        $.ajax({
            url: form.attr("action"),
            type: 'POST',
            data: form.serialize(),
            success: function(response){
                $("#ajaxEditOption").empty();
                $('#myOptionModal').modal('hide');
                $('#editProductOptionForm')[0].reset(); // Resetting the form
                reloadOrderProductsTable();
                swal("Success", "Your product option has been updated to the order!", "success");
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