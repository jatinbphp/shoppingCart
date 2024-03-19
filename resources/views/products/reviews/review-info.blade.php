<div class="reviews_info">
    <div class="single_rev d-flex align-items-start br-bottom py-3">
        <div class="single_rev_thumb" style=" width: 100px;">
            @if(!empty($user['image']) && file_exists($user['image']))
                <img src="{{url($user['image'])}}" class="img-fluid circle" style="width: 90px;" alt="" />
            @else 
                <img src="{{url('assets/website/images/user-default.png')}}" class="img-fluid circle" style="width: 90px;" alt="">
            @endif
        </div>
        <div class="single_rev_caption d-flex align-items-start pl-3">
            <div class="single_capt_left">
                <h5 class="mb-0 fs-md ft-medium lh-1 mb-2">{{$full_name}}</h5>

                <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $rating)
                            <i class="fas fa-star filled"></i>
                        @else
                            <i class="fas fa-star"></i>
                        @endif
                    @endfor
                </div>

                <span class="small">
                    {{ \Carbon\Carbon::parse($created_at)->format('d M Y') }}
                </span>
                <p>
                    <div>
                        {!! substr($description, 0, 300) !!}
                        @if(strlen($description) > 200)
                            <a href="javascript:void(0)" id="show-more" data-id="{{$id}}" data-url="{{route('reviews-info', ['reviewId' => $id])}}">...Show more</a>
                        @endif
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>