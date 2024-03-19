@extends('layouts.app')
@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'Shop', $product_info->product_name, 'Reviews List']])
<section class="middle">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>{{$product_info->product_name}} - Reviews</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-12 col-lg-12 col-md-12">
                <input type="hidden" id="route_name" value="{{ route('reviews-list', ['productId' => $productId]) }}">
                <table id="reviewsTable" class="table table-bordered table-striped datatable-dynamic">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Review Informations</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection