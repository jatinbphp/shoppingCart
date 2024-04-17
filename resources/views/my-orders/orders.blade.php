@extends('layouts.app')
@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'My Orders']])
<section class="middle">
    <div class="container ">

        @include ('common.error')
        
        <div class="row align-items-start justify-content-between">
            
            @include ('common.dashboard-menu', ['menu' => 'orders'])

            <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center ord_list_wraps">
                <div class="ord_list_wrap mb-4 mfliud">
                    <div class="ord_list_head gray d-flex align-items-center justify-content-between px-3 py-3">
                        <div class="olh_flex">
                            <p class="m-0 p-0"><span class="text-muted">My Orders</span></p>
                        </div>
                    </div>
                    <div class="ord_list_body text-left">
                        <input type="hidden" id="route_name" value="{{ route('orders-list') }}">
                        <table id="ordersTable" class="table table-bordered table-striped datatable-dynamic">
                            <tbody class="ord_list_body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection