$(function () {
    //User Table
    var users_table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email',  name: 'email'},
            {data: 'phone',  name: 'phone'},
            {data: 'image', "width": "10%",  name: 'image', orderable: false, searchable: false, render: function (data,type,row){
                    return '<img src="'+data+'" height="50" alt="Image"/>';
                }
            },
            {data: 'status', "width": "12%",  name: 'status', orderable: false},    
            {data: 'action', "width": "15%",  name: 'action', orderable: false},                
        ]
    });

    //Category Table
    var category_table = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'categoryName', categoryName: 'categoryName'},
            {data: 'image', "width": "10%", name: 'image', orderable: false, searchable: false, render: function (data,type,row){
                    return '<img src="'+data+'" height="50" alt="Image"/>';
                }
            },
            {data: 'status', "width": "12%",  name: 'status', orderable: false},
            {data: 'action', "width": "15%",  name: 'action', orderable: false},
        ]
    });

    //Product Table
    var products_table = $('#productsTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'product_name', product_name: 'product_name'},
            {data: 'sku',  name: 'sku'},
            {data: 'status', "width": "12%",  name: 'status', orderable: false},
            {data: 'action', "width": "15%",  name: 'action', orderable: false},
        ]
    });

    //CMS Table
    var content_table = $('#contentTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'title', name: 'title'},
            {data: 'action', "width": "12%",  name: 'action', orderable: false},                
        ]
    });

    //Contact Us Table
    var contactus_table = $('#contactusTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'message', name: 'message'},
            {data: 'action', "width": "5%",  name: 'action', orderable: false},                
        ]
    });

    //Order Table 
    var orders_table = $('#ordersTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [100, 200, 300, 400, 500],
        ajax: $("#route_name").val(),
        columns: [
            { data: 'order_id', name: 'order_id'},
            { data: 'user_name', name: 'user_name'},
            { data: 'total_amount', name: 'total_amount'},
            { data: 'created_at', name: 'created_at'},
            { data: 'status', name: 'status', orderable: false},
            { data: 'action', "width": "14%", name: 'action', orderable: false},

        ]
    });

    //Delete Record
    $('.datatable-dynamic tbody').on('click', '.deleteRecord', function (event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        var url = $(this).attr("data-url");
        var section = $(this).attr("data-section");

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
                    url: url,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    success: function(data){
                        if(section=='users_table'){
                            users_table.row('.selected').remove().draw(false);    
                        } else if(section=='category_table'){
                            category_table.row('.selected').remove().draw(false);   
                        } else if(section=='products_table'){
                            products_table.row('.selected').remove().draw(false);   
                        } else if(section=='options_table'){
                            options_table.row('.selected').remove().draw(false);   
                        } else if(section=='contactus_table'){
                            contactus_table.row('.selected').remove().draw(false);   
                        } else if (section == 'orders_table') {
                            orders_table.row('.selected').remove().draw(false);
                        }
                 
                        swal("Deleted", "Your data successfully deleted!", "success");
                    }
                });
            } else {
                swal("Cancelled", "Your data safe!", "error");
            }
        });
    });

    //Change Status
    $('.datatable-dynamic tbody').on('click', '.assign_unassign', function (event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");
        var type = $(this).attr("data-type");
        var table_name = $(this).attr("data-table_name");
        var section = $(this).attr("data-table_name");

        var l = Ladda.create(this);
        l.start();
        $.ajax({
            url: url,
            type: "post",
            data: {
                'id': id,
                'type': type,
                'table_name': table_name,
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data){
                l.stop();

                if(type=='unassign'){
                    $('#assign_remove_'+id).hide();
                    $('#assign_add_'+id).show();
                } else {
                    $('#assign_remove_'+id).show();
                    $('#assign_add_'+id).hide();
                }

                if(section=='users_table'){
                    users_table.draw(false);
                } else if(section=='products_table'){
                    products_table.draw(false);   
                } else if(section=='products_table'){
                    products_table.draw(false);   
                } else if(section=='options_table'){
                    options_table.draw(false);   
                } 
            }
        });
    });

    //change order status
    $('#ordersTable tbody').on('change', '.orderStatus', function (event) {
            event.preventDefault();
            var orderId = $(this).attr('data-id');
            var status = $(this).val();
            swal({
                title: "Are you sure?",
                text: "To update status of this order",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                confirmButtonText: 'Yes, Sure',
                cancelButtonText: "No, cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: $("#order_update").val(),
                        type: "post",
                        data: {'id': orderId, 'status': status, '_token': $('meta[name=_token]').attr('content') },
                        success: function(data){
                            if(data.status == 1){
                                swal("Success", "Order status is updated", "success");
                            } else {
                                swal("Error", "Something is wrong!", "error");
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "Your data is safe!", "error");
                }
            });
        });

    //get Order Indo
    $('.datatable-dynamic tbody').on('click', '.order-info', function (event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");

        $.ajax({
            url: url,
            type: "GET",
            data: {
                'id': id,
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data){
                $('#oderModal .modal-content').html(data);
                $('#oderModal').modal('show');
            }
        });
    });

    //get Order Indo
    $('.datatable-dynamic tbody').on('click', '.view-info', function (event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");

        $.ajax({
            url: url,
            type: "GET",
            data: {
                'id': id,
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data){
                $('#commonModal .modal-content').html(data);
                $('#commonModal').modal('show');
            }
        });
    });
    
});

