@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6 mt-3">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$users}}</h3>
                                <p>Total Users</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="{{route('users.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-3">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$category}}</h3>
                                <p>Total Categories</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-sitemap"></i>
                            </div>
                            <a href="{{route('category.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-3">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$products}}</h3>
                                <p>Total Products</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-tag"></i>
                            </div>
                            <a href="{{route('products.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-3">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$orders}}</h3>
                                <p>Total Orders</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-cart-plus"></i>
                            </div>
                            <a href="{{route('orders.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Latest Orders</h3>
                            </div>
                            <div class="card-body">
                                <input type="hidden" id="route_name" value="{{ route('orders.index_dashboard')}}">
                                <table id="ordersDasboardTable" class="table table-bordered table-striped datatable-dynamic">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>User</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Created Date</th>
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
            </div>
        </section>
    </div>
@endsection