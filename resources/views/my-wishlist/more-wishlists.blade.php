@foreach($wishlists as $key => $value)
<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
    <div class="product_grid card b-0">

        @if(!empty($value->product->type))
            {!! customBadge($value->product->type) !!}
        @endif

        {!! Form::button('<i class="fas fa-times"></i>', [
            'class' => 'btn btn_love position-absolute ab-right theme-cl text-danger remove-item',
            'data-id' => $value->id,
        ]) !!}
        
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

        <div class="card-footers b-0 py-3 px-2 dark_bg d-flex align-items-start justify-content-center">
            <div class="text-left">
                <div class="text-center">
                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1">
                        <a href="{{route('products.details', [$value->product->id])}}">{{$value->product->product_name}}</a>
                    </h5>
                    <div class="elis_rty">
                        <span class="ft-bold fs-md text-dark">{{ env('CURRENCY') }}{{ number_format($value->product->price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endforeach
