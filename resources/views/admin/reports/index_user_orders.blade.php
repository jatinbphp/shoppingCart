@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    @include('admin.common.header', ['menu' => $menu, 'breadcrumb' => [['route' => route('admin.dashboard'), 'title' => 'Dashboard']], 'active' => $menu])

    <!-- Main content -->
    <section class="content">        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['url' => null, 'id' => 'report-filter-Form', 'class' => 'form-horizontal','files'=>true]) !!}
                            @include ('admin.reports.order_filters', ['type' => 'user-orders'])
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
                        <input type="hidden" id="route_name" value="{{ route('reports.user_orders')}}">
                        <table id="userOrdersReportTable" class="table table-bordered table-striped datatable-dynamic">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Email</th>
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