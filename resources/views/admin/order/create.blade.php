@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        @include('admin.common.header', ['menu' => $menu, 'breadcrumb' => [['route' => route('orders.index'), 'title' => $menu]], 'active' => 'Add'])
        
        <section class="content">
            @include ('admin.common.error')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Add Order</h3>
                        </div>

                        {!! Form::open(['url' => route('orders.store'), 'id' => 'ordersForm', 'class' => 'form-horizontal','files'=>true]) !!}
                            
                            <div class="card-body">
                                @include ('admin.order.form')
                            </div>

                            <div class="card-footer">
                                @include('admin.common.footer-buttons', ['route' => 'orders.index', 'type' => 'create'])
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('admin.order.modals', ['flag_order_id' => 0])
@endsection