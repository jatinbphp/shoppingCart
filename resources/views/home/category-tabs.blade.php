@if(!empty(getCategoryProducts()))
    <section>
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="myTab" role="tablist">
                        @foreach(getCategoryProducts() as $index => $category)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if($index === 0) active @endif" href="#category{{$index}}" data-toggle="tab" role="tab" aria-controls="category{{$index}}" aria-selected="@if($index === 0) true @else false @endif">{{$category->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        
                        @foreach(getCategoryProducts() as $index => $category)
                            <div class="tab-pane fade @if($index === 0) show active @endif" id="category{{$index}}" role="tabpanel" aria-labelledby="category{{$index}}-tab">
                                <div class="tab_product">
                                    <div class="row rows-products">
                                        @foreach($category->products as $product)
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                                                <div class="product_grid card b-0">
                                                    
                                                    @if(!empty($product->type))
                                                        {!! customBadge($product->type) !!}
                                                    @endif

                                                    @guest
                                                        <a href="{{route('login')}}" class="btn btn_love position-absolute ab-right">
                                                            <i class="far fa-heart"></i>
                                                        </a>
                                                    @else
                                                        {!! Form::button('<i class="far fa-heart"></i>', [
                                                            'class' => 'btn btn_love position-absolute ab-right snackbar-wishlist ' . (in_array($product->id, getWishlistProductIds()) ? 'active' : ''),
                                                            'data-id' => $product->id,
                                                            'data-url' => route('products.add.wishlist'),
                                                            'data-toggle' => 'button',
                                                            'aria-label' => 'Add to Wishlist'
                                                        ]) !!}
                                                    @endif

                                                    <div class="card-body p-0">
                                                        <div class="shop_thumb position-relative">
                                                            <a class="card-img-top d-block overflow-hidden" href="{{route('products.details', [$product->id])}}">
                                                                @if(!empty($product->product_image->image) && file_exists($product->product_image->image))
                                                                    <img class="card-img-top" src="{{url($product->product_image->image)}}" alt="...">
                                                                @else 
                                                                    <img class="card-img-top" src="{{url('assets/website/images/default-image.png')}}" alt="...">
                                                                @endif
                                                            </a>
                                                            
                                                            <div class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center">
                                                                <div class="edlio">
                                                                    <a href="javascript:void(0)" id="quickview" class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center text-white fs-sm ft-medium" data-id="{{$product->id}}" data-url="{{route('products.quickview', [$product->id])}}">
                                                                        <i class="fas fa-eye mr-1"></i>Quick View
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footers b-0 py-3 px-2 dark_bg d-flex align-items-start justify-content-center">
                                                        <div class="text-left">
                                                            <div class="text-center">
                                                                <h5 class="fw-bolder fs-md text-light mb-0 lh-1 mb-1"><a href="shop-single.html" class="text-light">{{$product->product_name}}</a></h5>
                                                                <div class="elis_rty"><span class="ft-bold fs-md text-light">{{ env('CURRENCY') }}{{ number_format($product->price, 2) }}</span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif