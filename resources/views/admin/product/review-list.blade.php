@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    @include('admin.common.header', ['menu' => $menu, 'breadcrumb' => [['route' => route('products.index'), 'title' => $menu]], 'active' => 'List'])
    
    <!-- Main content -->
    <section class="content">
        @include ('admin.common.error')
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><b>{{$product_info->product_name}}</b> - Reviews</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <input type="hidden" id="route_name" value="{{ route('product.reviews.list', ['id' => $product_info->id]) }}">
                        <table id="reviewTable" class="table table-bordered table-striped datatable-dynamic">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Review Information</th>
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