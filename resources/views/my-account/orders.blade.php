@extends('layouts.app')

@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'My Order']])

<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
            
            @include ('my-account.dashboard-menu', ['menu' => 'orders'])

            <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                <div class="ord_list_wrap border mb-4 mfliud">
                    <div class="ord_list_head gray d-flex align-items-center justify-content-between px-3 py-3">
                        <div class="olh_flex">
                            <p class="m-0 p-0"><span class="text-muted">Order Number</span></p>
                            <h6 class="mb-0 ft-medium">#1250004123</h6>
                        </div>
                        <div class="olh_flex">
                            <a href="javascript:void(0);" class="btn btn-sm btn-dark">Track Order</a>
                        </div>
                    </div>
                    <div class="ord_list_body text-left">
                        <div class="row align-items-center justify-content-start m-0 py-4 br-bottom">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                <div class="cart_single d-flex align-items-start">
                                    <div class="cart_selected_single_thumb position-relative">
                                        <button class="btn btn_love position-absolute ab-left theme-cl text-danger"><i class="fas fa-times"></i></button>
                                        <a href="#"><img src="images/4.jpg" width="75" class="img-fluid rounded" alt=""></a>
                                    </div>
                                    <div class="cart_single_caption pl-3">
                                        <p class="mb-0"><span class="text-muted small">Dresses</span></p>
                                        <h4 class="product_title fs-sm ft-medium mb-1 lh-1">Women Striped Shirt Dress</h4>
                                        <p class="mb-2"><span class="text-dark medium">Size: 36</span>, <span class="text-dark medium">Color: Red</span></p>
                                        <h4 class="fs-sm ft-bold mb-0 lh-1">$129</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
                                <div class="delv_status"><span class="ft-medium small text-warning bg-light-warning rounded px-3 py-1">In Progress</span></div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                                <p class="mb-1 p-0"><span class="text-muted">Expected date by:</span></p>
                                <h6 class="mb-0 ft-medium fs-sm">22 September 2021</h6>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                <button type="button" class="btn btn-sm btn-primary rounded"><i class="lni lni-cart"></i></button>
                                <button type="button" class="btn btn-sm btn-danger rounded"><i class="lni lni-reply"></i></button>
                            </div>
                        </div>
                        
                        <div class="row align-items-center justify-content-start m-0 py-4 br-bottom">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                <div class="cart_single d-flex align-items-start">
                                    <div class="cart_selected_single_thumb position-relative">
                                        <a href="#"><img src="images/8.jpg" width="75" class="img-fluid rounded" alt=""></a>
                                    </div>
                                    <div class="cart_single_caption pl-3">
                                        <p class="mb-0"><span class="text-muted small">Boys</span></p>
                                        <h4 class="product_title fs-sm ft-medium mb-1 lh-1">Boys Solid Sweatshirt</h4>
                                        <p class="mb-2"><span class="text-dark medium">Size: 36</span>, <span class="text-dark medium">Color: Red</span></p>
                                        <h4 class="fs-sm ft-bold mb-0 lh-1">$129</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
                                <div class="delv_status"><span class="ft-medium small text-success bg-light-success rounded px-3 py-1">Completed</span></div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                                <p class="mb-1 p-0"><span class="text-muted">Expected date by:</span></p>
                                <h6 class="mb-0 ft-medium fs-sm">10 August 2021</h6>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                <button type="button" class="btn btn-sm btn-primary rounded"><i class="lni lni-cart"></i></button>
                                <button type="button" class="btn btn-sm btn-danger rounded"><i class="lni lni-reply"></i></button>
                            </div>
                        </div>
                        
                        <div class="row align-items-center justify-content-start m-0 py-4">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                <div class="cart_single d-flex align-items-start">
                                    <div class="cart_selected_single_thumb position-relative">
                                        <button class="btn btn_love position-absolute ab-left theme-cl text-danger"><i class="fas fa-times"></i></button>
                                        <a href="#"><img src="images/7.jpg" width="75" class="img-fluid rounded" alt=""></a>
                                    </div>
                                    <div class="cart_single_caption pl-3">
                                        <p class="mb-0"><span class="text-muted small">Men's</span></p>
                                        <h4 class="product_title fs-sm ft-medium mb-1 lh-1">Printed Straight Kurta</h4>
                                        <p class="mb-2"><span class="text-dark medium">Size: 36</span>, <span class="text-dark medium">Color: Red</span></p>
                                        <h4 class="fs-sm ft-bold mb-0 lh-1">$129</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
                                <div class="delv_status"><span class="ft-medium small text-danger bg-light-danger rounded px-3 py-1">On Hold</span></div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                                <p class="mb-1 p-0"><span class="text-muted">Expected date by:</span></p>
                                <h6 class="mb-0 ft-medium fs-sm">12 November 2021</h6>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                <button type="button" class="btn btn-sm btn-primary rounded"><i class="lni lni-cart"></i></button>
                                <button type="button" class="btn btn-sm btn-danger rounded"><i class="lni lni-reply"></i></button>
                            </div>
                        </div>

                        <div class="row align-items-center justify-content-start m-0 py-4 br-bottom">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                <div class="cart_single d-flex align-items-start">
                                    <div class="cart_selected_single_thumb position-relative">
                                        <a href="#"><img src="images/2.jpg" width="75" class="img-fluid rounded" alt=""></a>
                                    </div>
                                    <div class="cart_single_caption pl-3">
                                        <p class="mb-0"><span class="text-muted small">Dresses</span></p>
                                        <h4 class="product_title fs-sm ft-medium mb-1 lh-1">Women Striped Shirt Dress</h4>
                                        <p class="mb-2"><span class="text-dark medium">Size: 36</span>, <span class="text-dark medium">Color: Red</span></p>
                                        <h4 class="fs-sm ft-bold mb-0 lh-1">$129</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
                                <div class="delv_status"><span class="ft-medium small text-warning bg-light-warning rounded px-3 py-1">Completed</span></div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                                <p class="mb-1 p-0"><span class="text-muted">Expected date by:</span></p>
                                <h6 class="mb-0 ft-medium fs-sm">22 February 2021</h6>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                <button type="button" class="btn btn-sm btn-primary rounded"><i class="lni lni-cart"></i></button>
                                <button type="button" class="btn btn-sm btn-danger rounded"><i class="lni lni-reply"></i></button>
                            </div>
                        </div>
                        
                        <div class="row align-items-center justify-content-start m-0 py-4 br-bottom">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                <div class="cart_single d-flex align-items-start">
                                    <div class="cart_selected_single_thumb position-relative">
                                        <a href="#"><img src="images/8.jpg" width="75" class="img-fluid rounded" alt=""></a>
                                    </div>
                                    <div class="cart_single_caption pl-3">
                                        <p class="mb-0"><span class="text-muted small">Boys</span></p>
                                        <h4 class="product_title fs-sm ft-medium mb-1 lh-1">Boys Solid Sweatshirt</h4>
                                        <p class="mb-2"><span class="text-dark medium">Size: 36</span>, <span class="text-dark medium">Color: Red</span></p>
                                        <h4 class="fs-sm ft-bold mb-0 lh-1">$129</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
                                <div class="delv_status"><span class="ft-medium small text-success bg-light-success rounded px-3 py-1">Completed</span></div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                                <p class="mb-1 p-0"><span class="text-muted">Expected date by:</span></p>
                                <h6 class="mb-0 ft-medium fs-sm">10 January 2021</h6>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                <button type="button" class="btn btn-sm btn-primary rounded"><i class="lni lni-cart"></i></button>
                                <button type="button" class="btn btn-sm btn-danger rounded"><i class="lni lni-reply"></i></button>
                            </div>
                        </div>
                        
                        <div class="row align-items-center justify-content-start m-0 py-4">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                <div class="cart_single d-flex align-items-start">
                                    <div class="cart_selected_single_thumb position-relative">
                                        <a href="#"><img src="images/1.jpg" width="75" class="img-fluid rounded" alt=""></a>
                                    </div>
                                    <div class="cart_single_caption pl-3">
                                        <p class="mb-0"><span class="text-muted small">Men's</span></p>
                                        <h4 class="product_title fs-sm ft-medium mb-1 lh-1">Printed Straight Kurta</h4>
                                        <p class="mb-2"><span class="text-dark medium">Size: 36</span>, <span class="text-dark medium">Color: Red</span></p>
                                        <h4 class="fs-sm ft-bold mb-0 lh-1">$129</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
                                <div class="delv_status"><span class="ft-medium small text-danger bg-light-danger rounded px-3 py-1">Canceled</span></div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                                <p class="mb-1 p-0"><span class="text-muted">Expected date by:</span></p>
                                <h6 class="mb-0 ft-medium fs-sm">12 November 2021</h6>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                <button type="button" class="btn btn-sm btn-primary rounded"><i class="lni lni-cart"></i></button>
                                <button type="button" class="btn btn-sm btn-danger rounded"><i class="lni lni-reply"></i></button>
                            </div>
                        </div>

                    </div>
                    <div class="ord_list_footer d-flex align-items-center justify-content-between br-top px-3">
                        <div class="col-xl-12 col-lg-12 col-md-12 pl-0 py-2 olf_flex d-flex align-items-center justify-content-between">
                            <div class="olf_flex_inner hide_mob">
                                <p class="m-0 p-0"><span class="text-muted medium">Paid using debit card ending with 6472</span></p>
                            </div>
                            <div class="olf_inner_right">
                                <h5 class="mb-0 fs-sm ft-bold">Total: $4510</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection