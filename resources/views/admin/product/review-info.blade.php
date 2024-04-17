<div class="col-md-12">
    <div class="col-md-1" style="float: left;">
        @if(!empty($user['image']) && file_exists($user['image']))
            <img src="{{asset($user['image'])}}" class="img-fluid circle" style="max-width: 100%; height: auto;" alt="" />
        @else 
            <img src="{{url('assets/website/images/user-default.png')}}" class="img-fluid circle" style="max-width: 100%; height: auto;" alt="">
        @endif
    </div>
    <div class="col-md-11 pull-left"  style="float: left;">
        <h5>{{$full_name}}</h5>

        <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $rating)
                    <i class="fas fa-star filled"></i>
                @else
                    <i class="far fa-star"></i>
                @endif
            @endfor
        </div>

        <span class="small">
            {{ \Carbon\Carbon::parse($created_at)->format('d M Y') }}
        </span>
        <div>
            {!! substr(strip_tags($description), 0, 100) !!}
            @if(strlen($description) > 100)
                <a href="javascript:void(0)" id="show-more-data" data-id="{{$id}}" data-url="{{route('admin.product.review-info', ['reviewId' => $id])}}">...Show more</a>
            @endif
        </div>
    </div>
</div>