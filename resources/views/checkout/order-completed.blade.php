@extends('layouts.app')
@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'Order Completed']])
<section class="middle">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">
                <div class="p-4 d-inline-flex align-items-center justify-content-center circle bg-light-success text-success mx-auto mb-4"><i class="lni lni-heart-filled fs-lg"></i></div>
                <h2 class="mb-2 ft-bold">Your Order is Completed!</h2>
                <p class="ft-regular fs-md mb-5">Your order <span class="text-body text-dark">#{{$order_id}}</span> has been completed. Your order details are shown for your personal accont.</p>
                <a class="btn btn-dark" href="{{route('orders-list')}}">Track Your Orders</a>
            </div>
        </div>
    </div>
</section>
@endsection