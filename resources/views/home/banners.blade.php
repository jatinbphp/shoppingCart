@if(!empty(getActiveBanners()))
    <div class="home-slider margin-bottom-0">
        @foreach(getActiveBanners() as $keyBanner => $valueBanner)
            @if(!empty($valueBanner->image) && file_exists($valueBanner->image))
                <div class="item" data-overlay="3" style="background-image: url({{$valueBanner->image}});">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="home-slider-container">
                                    <div class="home-slider-desc text-center">
                                        <div class="home-slider-title mb-4">
                                            <h5 class="fs-lg ft-ft-medium mb-0">{{$valueBanner->title}}</h5>
                                            <h1 class="mb-1 ft-bold lg-heading">{{$valueBanner->subtitle}}</h1>
                                            <span class="trending text-light">{{$valueBanner->description}}</span>
                                        </div>
                                        <a href="{{ route('products') }}" class="btn stretched-link light-borders ft-bold">Shop Now<i class="lni lni-arrow-right ml-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif