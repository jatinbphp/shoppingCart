@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        @include('admin.common.header', ['menu' => $menu, 'breadcrumb' => [['route' => route('admin.dashboard'), 'title' => 'Dashboard']], 'active' => $menu])
        
        <!-- Main content -->
        <section class="content">
            @include ('admin.common.error')
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Manage {{$menu}}</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('products.create') }}" class="btn btn-sm btn-info float-right"><i class="fa fa-plus pr-1"></i> Add New</a>
                                    <a href="{{ route('products.import.product') }}" class="btn btn-sm btn-info float-right mr-1"><i class="fa fa-plus pr-1"></i> Import</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <input type="hidden" id="route_name" value="{{ route('products.index') }}">
                            <table id="productsTable" class="table table-bordered table-striped datatable-dynamic">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
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