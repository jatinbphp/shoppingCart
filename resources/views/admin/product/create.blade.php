@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        @include('admin.common.header', ['menu' => $menu, 'breadcrumb' => [['route' => route('products.index'), 'title' => $menu]], 'active' => 'Add'])

        <section class="content">
            @include ('admin.common.error')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Add Product</h3>
                        </div>

                        {!! Form::open(['url' => route('products.store'), 'id' => 'productsForm', 'class' => 'form-horizontal','files'=>true]) !!}

                            <div class="card-body">
                                @include ('admin.product.form')
                            </div>

                            <div class="card-footer">
                                @include('admin.common.footer-buttons', ['route' => 'products.index', 'type' => 'create'])
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection