@extends('layouts.app')

@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'Wishlist']])

<section class="middle">
    <div class="container">
    @include ('common.error')
    <div class="success-message" style="display: none;"></div>
        <div class="row justify-content-center justify-content-between">

            @include ('my-account.dashboard-menu', ['menu' => 'wishlists'])
        
            @if(!empty($wishlists))
                <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                    <div class="row align-items-center">
                        @foreach($wishlists as $key => $value)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                <div class="product_grid card b-0">

                                    @if(!empty($value->product->type))
                                        {!! customBadge($value->product->type) !!}
                                    @endif
                                    <button class="btn btn_love position-absolute ab-right theme-cl text-danger remove-item" data-id="{{$value->id}}"><i class="fas fa-times"></i></button>

                                    <div class="card-body p-0">
                                        <div class="shop_thumb position-relative">
                                            <a class="card-img-top d-block overflow-hidden" href="{{route('products.details', [$value->product->id])}}">
                                                @if(!empty($value->product->product_image->image) && file_exists($value->product->product_image->image))
                                                    <img class="card-img-top" src="{{url($value->product->product_image->image)}}" alt="...">
                                                @else 
                                                    <img class="card-img-top" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                                                @endif
                                            </a>

                                            <div class="edlio">
                                                <a href="javascript:void(0)" id="quickview" class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center text-white fs-sm ft-medium" data-id="{{$value->product->id}}" data-url="{{route('products.quickview', [$value->product->id])}}">
                                                    <i class="fas fa-eye mr-1"></i>Quick View
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                        <div class="text-left">
                                            <div class="text-center">
                                                <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1">
                                                    <a href="product-detail.html">{{$value->product->product_name}}</a>
                                                </h5>

                                                <div class="elis_rty"><span class="ft-bold fs-md text-dark">{{ env('CURRENCY') }}{{ number_format($value->product->price, 2) }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 text-center pt-4 pb-4 text-center">
                            <a href="#" id="load-more-btn" class="btn stretched-link borders "><i class="lni lni-reload mr-2"></i>Load More</a>
                            <!-- <button id="load-more-btn">Load More</button> -->

                        </div>
                    </div>
                </div>
            @else 
                <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                    <div class="row align-items-center">
                        <p>Your wishlist is empty.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>


@endsection

@section('jquery')
<script src="https://cdn.jsdelivr.net/npm/sweetalert@2"></script>

<script>
    $(document).ready(function() {
        // Function to display wishlist items for the current page
        function displayWishlistItems(page) {
            var startIndex = (page - 1) * itemsPerPage;
            var endIndex = page * itemsPerPage;

            $('.product_grid').slice(0, endIndex).show();

            if ($('.product_grid').length > endIndex) {
                $('#load-more-btn').show();
            } else {
                $('#load-more-btn').hide();
            }
        }

        var currentPage = {{ $currentPage ?? 1 }};
        var itemsPerPage = {{env('PRODUCT_PAGINATION_LENGHT')}};;

        // Initial display of wishlist items
        displayWishlistItems(currentPage);

        $('#load-more-btn').click(function(event) {
            event.preventDefault();
            currentPage++;
            displayWishlistItems(currentPage);
        });

        $('.remove-item').click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var itemId = $this.data('id');
            swal({
                title: "Are you sure?",
                text: "You want to remove from wishlist?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '{{ route("wishlist.remove", "") }}/' + itemId,
                        type: 'GET',
                        success: function(response) {
                            if (response.success) {
                                swal("Success!", "Item removed from wishlist successfully.", "success")
                                    .then(() => {
                                        // Reload the page without resetting the current page
                                        location.reload();
                                    });
                            } else {
                                swal("Error", "Failed to remove item from wishlist.", "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    swal("Cancelled", "Your data safe!", "error");
                }
            });
        });
    });
</script>
@endsection






