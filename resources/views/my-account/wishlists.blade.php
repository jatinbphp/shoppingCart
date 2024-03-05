@extends('layouts.app')

@section('content')
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<section class="middle">
    <div class="container">
        <div class="row justify-content-center justify-content-between">

            @include ('my-account.dashboard-menu')
        
            <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                <div class="row align-items-center">
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="product_grid card b-0">
                            <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                            <button class="btn btn_love position-absolute ab-right theme-cl text-danger"><i class="fas fa-times"></i></button>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="product-detail.html"><img class="card-img-top" src="images/1.jpg" alt="..."></a>
                                    <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                </div>
                            </div>
                            <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                <div class="text-left">
                                    <div class="text-center">
                                        <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="product-detail.html">Half Running Set</a></h5>
                                        <div class="elis_rty"><span class="ft-bold fs-md text-dark">$119.00</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="product_grid card b-0">
                            <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">New</div>
                            <button class="btn btn_love position-absolute ab-right theme-cl text-danger"><i class="fas fa-times"></i></button>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="product-detail.html"><img class="card-img-top" src="images/2.jpg" alt="..."></a>
                                    <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                </div>
                            </div>
                            <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                <div class="text-left">
                                    <div class="text-center">
                                        <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="product-detail.html">Formal Men Lowers</a></h5>
                                        <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$129.00</span><span class="ft-bold theme-cl fs-md">$79.00</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="product_grid card b-0">
                            <button class="btn btn_love position-absolute ab-right theme-cl text-danger"><i class="fas fa-times"></i></button>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="product-detail.html"><img class="card-img-top" src="images/3.jpg" alt="..."></a>
                                    <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                </div>
                            </div>
                            <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                <div class="text-left">
                                    <div class="text-center">
                                        <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="product-detail.html">Half Running Suit</a></h5>
                                        <div class="elis_rty"><span class="ft-bold fs-md text-dark">$80.00</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="product_grid card b-0">
                            <div class="badge bg-warning text-white position-absolute ft-regular ab-left text-upper">Hot</div>
                            <button class="btn btn_love position-absolute ab-right theme-cl text-danger"><i class="fas fa-times"></i></button> 
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="product-detail.html"><img class="card-img-top" src="images/4.jpg" alt="..."></a>
                                    <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                </div>
                            </div>
                            <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                <div class="text-left">
                                    <div class="text-center">
                                        <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="product-detail.html">Half Fancy Lady Dress</a></h5>
                                        <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$149.00</span><span class="ft-bold theme-cl fs-md">$110.00</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="product_grid card b-0">
                            <button class="btn btn_love position-absolute ab-right theme-cl text-danger"><i class="fas fa-times"></i></button>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="product-detail.html"><img class="card-img-top" src="images/5.jpg" alt="..."></a>
                                    <div class="edlio"><a href="#" data-toggle="modal" data-target="#quickview" class="text-white product-hover-overlay bg-dark d-flex align-items-center justify-content-center fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                                </div>
                            </div>
                            <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                <div class="text-left">
                                    <div class="text-center">
                                        <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="product-detail.html">Flix Flox Jeans</a></h5>
                                        <div class="elis_rty"><span class="text-muted ft-medium line-through mr-2">$90.00</span><span class="ft-bold theme-cl fs-md">$49.00</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection