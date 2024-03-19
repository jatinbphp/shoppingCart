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
            @include ('products.products-filter')
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
                                            <select class="custom-select simple" id="sort-select" name="sort">
                                                <option value="">Default Sorting</option>
                                                <option value="low_to_high">Sort by price: Low to High</option>
                                                <option value="high_to_low">Sort by price: High to Low</option>
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
                                        {!! Form::button('<i class="far fa-heart"></i>', [
                                            'class' => 'btn btn_love position-absolute ab-right snackbar-wishlist' . (in_array($value->id, getWishlistProductIds()) ? ' active' : ''),
                                            'data-id' => $value->id,
                                            'data-url' => route('products.add.wishlist'),
                                            'data-toggle' => 'button'
                                        ]) !!}
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
                                                @php
                                                    $average_rating = ($value->total_reviews > 0) ? $value->total_review_rating / $value->total_reviews : 0;
                                                    $filled_stars = round($average_rating);
                                                @endphp

                                                <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $filled_stars)
                                                            <i class="fas fa-star filled"></i>
                                                        @else
                                                            <i class="fas fa-star"></i>
                                                        @endif
                                                    @endfor
                                                    <a href="{{ route('reviews-list', ['productId' => $value->id]) }}"><span class="small">({{$value->total_reviews}} Reviews)</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-left">
                                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1">
                                                <a target="_blank" href="{{route('products.details', [$value->id])}}">
                                                    {{$value->product_name}}
                                                </a>
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
                                {!! Form::button('<i class="lni lni-reload mr-2"></i>Load More', [
                                    'onclick' => 'handleLoadMore('.env('PRODUCT_PAGINATION_LENGHT').')',
                                    'id' => 'load-more-btn',
                                    'class' => 'btn stretched-link borders m-auto'
                                ]) !!}
                            </div>
                        </div>
                    @endif
                @else 
                    <div class="row align-items-center rows-products grid">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                            <p>No records found.</p>
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
var itemsPerPage = {{ env('PRODUCT_PAGINATION_LENGHT') }};
var currentPage = 1; 
var currentSortOption = '';

function handleLoadMore() {
    event.preventDefault();
    currentPage++;
    $.ajax({
        url: "{{ route('products') }}",
        type: "GET",
        data: {
            _token: '{{ csrf_token() }}',
            sort: currentSortOption,
            items: itemsPerPage,
            page: currentPage,
            category_id: {{ request()->route()->hasParameter('category_id') ? request()->route('category_id') : 'null' }},
            keyword: '{{ request('keyword') ?? null }}',
            layout: $('.view-btn.active').attr('data-id'),
        },
        success: function(response) {
            if (response.status !== 200) return false;
            var products = JSON.parse(JSON.stringify(response.products.data));
            if (!products || products.length === 0) return false;
            var totalCount = (currentPage - 1) * itemsPerPage + products.length; 
            $('#items-found').text(totalCount); 
            if (response.is_last) {
                $("#load-more-btn").addClass('btn-secondary').attr('disabled', true);
            }
            $('.rows-products').append(response.view);
        }
    });
}

$(document).ready(function() {
    $('#sort-select').change(function() {
        var sortOption = $(this).val(); 
        currentPage = 1; 
        currentSortOption = sortOption;
        $.ajax({
            url: "{{ route('products') }}",
            type: "GET",
            data: {
                _token: '{{ csrf_token() }}',
                sort: sortOption,
                items: itemsPerPage,
                page: currentPage,
                category_id: {{ request()->route()->hasParameter('category_id') ? request()->route('category_id') : 'null' }},
                keyword: '{{ request('keyword') ?? null }}',
                layout: $('.view-btn.active').attr('data-id'),
            },
            success: function(response) {
                if (response.status !== 200) return false;
                var products = JSON.parse(JSON.stringify(response.products.data));
                if (!products || products.length === 0) return false;
                var totalCount = (currentPage - 1) * itemsPerPage + products.length; 
                $('#items-found').text(totalCount); 
                if (response.is_last) {
                    $("#load-more-btn").addClass('btn-secondary').attr('disabled', true);
                } else {
                    $("#load-more-btn").removeClass('btn-secondary').attr('disabled', false);
                }
                $('.rows-products').html(response.view);
            }
        });
    });
});

/*function for filtering products by size and price*/
function handleProductFilter(minPrice=null, maxPrice=null){
    var formData = $('#product-filter-form').serializeArray();
    var category_id = {{ request()->route('category_id') ?? 'null' }};
    var keyword = '{{ request('keyword') ?? null }}';
    var layout = $('.view-btn.active').attr('data-id');

    formData.push({name: 'category_id', value: category_id});
    formData.push({name: 'items', value: itemsPerPage});
    formData.push({name: 'keyword', value: keyword});
    formData.push({name: 'layout', value: layout});
    /*price range*/
    formData.push({name: 'minPrice', value: minPrice});
    formData.push({name: 'maxPrice', value: maxPrice});

    $.ajax({
        url: $('#product-filter-form').attr('action'),
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: $.param(formData),
        success: function(response) {
            if (response.status !== 200) return false;
            var products = JSON.parse(JSON.stringify(response.products.data));
            //if (!products || products.length === 0) return false;
            var totalCount = (currentPage - 1) * itemsPerPage + products.length; 
            $('#items-found').text(totalCount); 
            if (response.is_last) {
                $("#load-more-btn").addClass('btn-secondary').attr('disabled', true);
            } else {
                $("#load-more-btn").removeClass('btn-secondary').attr('disabled', false);
            }
            $('.rows-products').html(response.view);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
        }
    });
}

$(".js-range-slider").on("change", function() {
    var slider = $(this).data("ionRangeSlider");    
    var minValue = slider.result.from;
    var maxValue = slider.result.to;
    handleProductFilter(minValue, maxValue)
});
</script>
@endsection