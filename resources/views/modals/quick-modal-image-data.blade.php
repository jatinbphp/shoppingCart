<div class="quick_view_slide">
    @if(!empty($info['product_images']))
        @foreach($info['product_images'] as $keyImages => $valueImages)
            @if(!empty($valueImages['image']) && file_exists($valueImages['image']))
                <div class="single_view_slide">
                    <img src="{{url($valueImages['image'])}}" class="img-fluid" alt="" />
                </div>
            @endif
        @endforeach
    @else 
        <div class="single_view_slide">
            <img class="img-fluid" src="{{url('assets/website/images/default-image.png')}}" alt="...">
        </div>
    @endif
</div>