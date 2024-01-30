@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$menu}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">{{$menu}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @include ('admin.error')
            <div id="responce" class="alert alert-success" style="display: none">
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('category.create') }}"><button class="btn btn-info float-right" type="button"><i class="fa fa-plus pr-1"></i> Add New</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="categoryTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th style="width: 15%;">Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('jquery')
<script type="text/javascript">
    $(function () {
        var table = $('#categoryTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 100,
            lengthMenu: [ 100, 200, 300, 400, 500 ],
            ajax: "{{ route('category.index') }}",
            columns: [
                {data: 'categoryName', "width": "55%", categoryName: 'categoryName'},
                {data: 'image', "width": "15%", name: 'image', orderable: false, searchable: false, render: function (data,type,row){
                        return '<img src="{{url('/')}}/'+data+'" height="50" alt="Image"/>';
                    }
                },
                {data: 'status', "width": "15%", name: 'status', render: function (data,type,row){
                        $statusBtn = '';
                        if (data === "active") {
                            $statusBtn += '<div class="btn-group-horizontal" id="assign_remove_"'+row.id+'">'+
                                '<button class="btn btn-success unassign ladda-button" data-style="slide-left" id="remove" url="{{route('category.unassign')}}" ruid="'+row.id+'"  type="button" style="height:28px; padding:0 12px"><span class="ladda-label">Active</span> </button>'+
                                '</div>';
                            $statusBtn += '<div class="btn-group-horizontal" id="assign_add_"'+row.id+'"  style="display: none">'+
                                '<button class="btn btn-danger assign ladda-button" data-style="slide-left" id="assign" uid="'+row.id+'" url="{{route('category.assign')}}" type="button"  style="height:28px; padding:0 12px"><span class="ladda-label">In Active</span></button>'+
                                '</div>';
                        } else {
                            $statusBtn += '<div class="btn-group-horizontal" id="assign_add_"'+row.id+'">'+
                                '<button class="btn btn-danger assign ladda-button" id="assign" data-style="slide-left" uid="'+row.id+'" url="{{route('category.assign')}}"  type="button" style="height:28px; padding:0 12px"><span class="ladda-label">In Active</span></button>'+
                                '</div>';
                            $statusBtn += '<div class="btn-group-horizontal" id="assign_remove_"'+row.id+'" style="display: none">'+
                                '<button class="btn btn-success unassign ladda-button" id="remove" ruid="'+row.id+'" data-style="slide-left" url="{{route('category.unassign')}}" type="button" style="height:28px; padding:0 12px"><span class="ladda-label">Active</span></button>'+
                                '</div>';
                        }
                        return $statusBtn;
                    }
                },
                {data: 'action', "width": "15%", name: 'action', orderable: false, searchable: false, render: function(data,type,row){
                        $btn = '<div class="btn-group">'+
                                    '<button type="button" class="btn btn-primary btn-sm">Action</button>'+
                                '<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">'+
                                    '<span class="sr-only">Toggle Dropdown</span>'+
                                '</button>'+
                                '<div class="dropdown-menu" role="menu">'+
                                    '<a class="dropdown-item" href="' + "{{ url('admin/category/') }}" + '/' + row.id + '/edit"><i class="fa fa-edit text-info pr-2"></i>Edit Category</a>'+
                                    '<a class="dropdown-item deleteCategory" data-id="'+row.id+'" href="#"><i class="fa fa-trash text-danger pr-2"></i>Delete Category</a>'+
                                    /*'<a class="dropdown-item" href="' + "{{url('admin/category/')}}"+ '/' + row.id +'"><i class="fa fa-sitemap text-primary pr-2"></i>View Sub Category</a>'+*/
                                '</div>'+
                            '</div>';
                        return $btn;
                    }
                },
            ]
        });

        $('#categoryTable tbody').on('click', '.deleteCategory', function (event) {
            event.preventDefault();
            var roleId = $(this).attr("data-id");
            swal({
                    title: "Are you sure?",
                    text: "You want to delete this category?",
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
                        url: "{{url('admin/category')}}/"+roleId,
                        type: "DELETE",
                        data: {_token: '{{csrf_token()}}' },
                        success: function(data){
                            table.row('.selected').remove().draw(false);
                            swal("Deleted", "Your data successfully deleted!", "success");
                        }
                    });
                } else {
                    swal("Cancelled", "Your data safe!", "error");
                }
            });
        });

        $('#categoryTable tbody').on('click', '.assign', function (event) {
            event.preventDefault();
            var category_id = $(this).attr('uid');
            var url = $(this).attr('url');
            var l = Ladda.create(this);
            l.start();
            $.ajax({
                url: url,
                type: "post",
                data: {'id': category_id},
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                success: function(data){
                    l.stop();
                    $('#assign_remove_'+category_id).show();
                    $('#assign_add_'+category_id).hide();
                    table.draw(false);
                }
            });
        });

        $('#categoryTable tbody').on('click', '.unassign', function (event) {
            event.preventDefault();
            var category_id = $(this).attr('ruid');
            var url = $(this).attr('url');
            var l = Ladda.create(this);
            l.start();
            $.ajax({
                url: url,
                type: "post",
                data: {'id': category_id,'_token' : $('meta[name=_token]').attr('content') },
                success: function(data){
                    l.stop();
                    $('#assign_remove_'+category_id).hide();
                    $('#assign_add_'+category_id).show();
                    table.draw(false);
                }
            });
        });
    });
  </script>
@endsection
