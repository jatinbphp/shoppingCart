@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    @include('admin.common.header', ['menu' => $menu, 'breadcrumb' => [['route' => route('products.index'), 'title' => $menu]], 'active' => 'Review'])
    
    <!-- Main content -->
    <section class="content">
        @include ('admin.common.error')
        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>{{$product_info->product_name}} - Reviews</h2>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">{{$menu}} Review</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <input type="hidden" id="route_name" value="{{ route('products.review.list', ['id' => $id]) }}">
                        <table id="adminRatingTable" class="table table-bordered table-striped datatable-dynamic">
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
