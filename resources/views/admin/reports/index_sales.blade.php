@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        @include ('admin.common.error')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['url' => null, 'id' => 'reports-filter-Form', 'class' => 'form-horizontal','files'=>true]) !!}
                            @include ('admin.reports.filter_sales')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Manage {{$menu}}</h3>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="route_name" value="{{ route('reports.sales')}}">
                        <table id="salesReportTable" class="table table-bordered table-striped datatable-dynamic">
                            <thead>
                                <tr>
                                    <th>Order Date</th>
                                    <th>No. Orders</th>
                                    <th>No. Products</th>
                                    <th>Total</th>
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