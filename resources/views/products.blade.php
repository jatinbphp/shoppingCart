@extends('layouts.app')

@section('content')
<section class="bg-cover bckPos-topCenter" data-overlay="1" style="background: url('{{url("assets/website/images/banner-1.jpg")}}'); background-repeat:no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-left py-md-5 mt-md-3 mb-md-3">
                    <h1 class="ft-medium mb-3">Home</h1>
                    <ul class="shop_categories_list m-0 p-0">
                        <li><a href="#" class="">Home</a></li>
                        <li><a href="#" class="">Shop</a></li>                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'Shop']])

<section class="middle">
    <div class="container">

        @include ('common.error')
        
        <div class="row">

            @include ('products-filter')

            <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="border mb-3 mfliud">
                            <div class="row align-items-center py-2 m-0">
                                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12 d-none d-md-flex">
                                    <h6 class="mb-0"><span id="items-found">{{count($products)}}</span> Items Found</h6>
                                </div>
                                <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                                    <div class="filter_wraps d-flex align-items-center justify-content-end m-start">
                                        <div class="single_fitres mr-2 br-right">
                                            <select class="custom-select simple">
                                                <option value="1" selected="">Default Sorting</option>
                                                <option value="2">Sort by price: Low price</option>
                                                <option value="3">Sort by price: Hight price</option>
                                                <option value="4">Sort by rating</option>
                                                <option value="5">Sort by trending</option>
                                            </select>
                                        </div>
                                        <div class="single_fitres">
                                            <a href="JavaScript:;" class="simple-button grid mr-1 view-btn active" data-id="grid-view"><i class="ti-layout-grid2"></i></a>
                                            <a href="JavaScript:;" class="simple-button list view-btn" data-id="list-view"><i class="ti-view-list"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!empty($products) && isset($products) && count($products)>0)
                    <div class="row align-items-center rows-products grid">
                        @foreach($products as $key => $value)
                            <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                                <div class="product_grid card b-0">

                                    @if(!empty($value->type))
                                        {!! customBadge($value->type) !!}
                                    @endif

                                    @guest
                                        <a href="{{route('login')}}" class="btn btn_love position-absolute ab-right">
                                            <i class="far fa-heart"></i>
                                        </a>
                                    @else
                                        <button class="btn btn_love position-absolute ab-right snackbar-wishlist @if(in_array($value->id, getWishlistProductIds())) active @endif" data-id="{{$value->id}}" data-url="{{route('products.add.wishlist')}}" data-toggle="button">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    @endif

                                    <div class="card-body p-0">
                                        <div class="shop_thumb position-relative">
                                            <a target="_blank" class="card-img-top d-block overflow-hidden" href="{{route('products.details', [$value->id])}}">
                                                @if(!empty($value->product_image->image) && file_exists($value->product_image->image))
                                                    <img class="card-img-top" src="{{url($value->product_image->image)}}" alt="...">
                                                @else 
                                                    <img class="card-img-top" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                                                @endif
                                            </a>
                                            <div class="edlio">
                                                <a href="javascript:void(0)" id="quickview" class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center text-white fs-sm ft-medium" data-id="{{$value->id}}" data-url="{{route('products.quickview', [$value->id])}}">
                                                    <i class="fas fa-eye mr-1"></i>Quick View
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer b-0 p-0 pt-2 bg-white">
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="text-left">
                                                <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star"></i>
                                                    <span class="small">(5 Reviews)</span>
                                                </div>
                                            </div>
                                            <!-- <div class="text-right">
                                                <button class="btn auto btn_love snackbar-wishlist"><i class="far fa-heart"></i></button> 
                                            </div> -->
                                        </div>
                                        <div class="text-left">
                                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1">
                                                <a href="product-detail.html">{{$value->product_name}}</a>
                                            </h5>
                                            <div class="elis_rty">
                                                <span class="ft-bold text-dark fs-sm">{{ env('CURRENCY') }}{{ number_format($value->price, 2) }}</span>
                                            </div>
                                            <div class="d-none">
                                                <div class="mt-3 mb-4">
                                                    {!! substr(strip_tags($value->description), 0, 300) !!}{{ strlen(strip_tags($value->description)) > 200 ? '...' : '' }}
                                                </div>

                                                <a href="javascript:void(0)" id="quickview" class="btn stretched-link borders" data-id="{{$value->id}}" data-url="{{route('products.quickview', [$value->id])}}">Add To Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($total_products>env('PRODUCT_PAGINATION_LENGHT'))
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 text-center pt-4 pb-4">
                                <button onclick="handleLoadMore({{env('PRODUCT_PAGINATION_LENGHT')}})" id="load-more-btn" class="btn stretched-link borders m-auto"><i class="lni lni-reload mr-2"></i>Load More</button>
                            </div>
                        </div>
                    @endif
                @else 
                    <div class="row align-items-center rows-products grid">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                            <p>No records found..</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
@section('jquery')
<script type="text/javascript">
    var items = {{env('PRODUCT_PAGINATION_LENGHT')}};
    function handleLoadMore(newItems){
        event.preventDefault()
        items = items + newItems;
        $.ajax({
            url: "{{ route('products') }}?items=" + items,
            type: "GET",
            data: {
                _token: '{{csrf_token()}}',
                category_id: {{ request()->route('category_id') ?? 'null' }},
                keyword: '{{ request('keyword') ?? null }}',
                layout: $('.view-btn.active').attr('data-id'),
            },
            success: function(response){
                if(response.status !== 200) return false;          
                var products = JSON.parse(JSON.stringify(response.products.data));
                if (!products || products.length === 0) return false;
                if (response.is_last) $("#load-more-btn").addClass('btn-secondary').removeClass('stretched-link').attr('disabled', true);
                $("#items-found").html(products.length);
                $('.rows-products').empty().html(response.view);
                $('#list-button').addClass('active');
                $('#grid-button').removeClass('active');
            }
        });
    }
</script>
@endsection