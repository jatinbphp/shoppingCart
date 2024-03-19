@foreach($products as $key => $value)
    <div class="{{(isset($layout) && $layout == 'list-view') ? 'col-12' : 'col-xl-4 col-lg-4 col-md-6 col-6'}}">
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
                            <span class="small">({{$value->total_reviews}} Reviews)</span>
                        </div>
                    </div>
                    <!-- <div class="text-right">
                        <button class="btn auto btn_love snackbar-wishlist"><i class="far fa-heart"></i></button> 
                    </div> -->
                </div>
                <div class="text-left">
                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1">
                        <a href="{{route('products.details', [$value->id])}}">{{ $value->product_name ?? "-"}}</a>
                    </h5>
                    <div class="elis_rty">
                        <span class="ft-bold text-dark fs-sm">{{ env('CURRENCY') }}{{ number_format($value->price ?? 0, 2) }}</span>
                    </div>
                    <div class="{{ (isset($layout) && $layout == 'list-view') ? 'd-block' : 'd-none' }}">
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