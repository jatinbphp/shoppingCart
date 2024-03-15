<div class="reviews_info">
    @if(!empty(get_latest_product_reviews($product['id'])))
        @foreach(get_latest_product_reviews($product['id']) as $keyR => $valueR)
            <div class="single_rev d-flex align-items-start {{!$loop->last ? 'br-bottom' : ''}} py-3">
                <div class="single_rev_thumb">
                    
                    @if(!empty($valueR->user->image) && file_exists($valueR->user->image))
                        <img src="{{url($valueR->user->image)}}" class="img-fluid circle" width="90" alt="" />
                    @else 
                        <img src="{{url('assets/website/images/user-default.png')}}" class="img-fluid circle" width="90" alt="">
                    @endif
                </div>

                <div class="single_rev_caption d-flex align-items-start pl-3">
                    <div class="single_capt_left">
                        <h5 class="fs-md ft-medium lh-1 mb-2">{{$valueR->full_name}}</h5>

                        <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $valueR->rating)
                                    <i class="fas fa-star filled"></i>
                                @else
                                    <i class="fas fa-star"></i>
                                @endif
                            @endfor
                        </div>

                        <span class="small">
                            {{ \Carbon\Carbon::parse($valueR->created_at)->format('d M Y') }}
                        </span>

                        <p>
                            {!! substr($valueR['description'], 0, 300) !!}{{ strlen($valueR['description']) > 200 ? '...' : '' }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="reviews_rate">
    {!! Form::open(['url' => route('add-product-review'), 'id' => 'reviewForm', 'class' => 'form-horizontal row','files'=>true, 'method' => 'post']) !!}

        {!! Form::hidden('product_id', $product['id']) !!}

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <h4>Submit Rating</h4>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="revie_stars d-flex align-items-center justify-content-between px-2 py-2 gray rounded mb-2 mt-1">
                <div class="srt_013">
                    <div class="submit-rating">
                        @for ($i = 5; $i >= 1; $i--)
                            <input id="star-{{ $i }}" type="radio" name="rating" value="{{ $i }}" {{ $i == 3 ? 'checked' : '' }}>
                            <label for="star-{{ $i }}" title="{{ $i }} stars">
                                <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                        @endfor
                    </div>                                        
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
                @include('common.label', ['field' => 'full_name', 'labelText' => 'Full Name', 'isRequired' => true])

                {!! Form::text('full_name', Auth::check() ? Auth::user()->name : null, ['class' => 'form-control', 'placeholder' => 'Enter Full Name', 'id' => 'full_name', 'required' => 'true']) !!}
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
                @include('common.label', ['field' => 'email_address', 'labelText' => 'Email Address', 'isRequired' => true])

                {!! Form::email('email_address', Auth::check() ? Auth::user()->email : null, ['class' => 'form-control', 'placeholder' => 'Enter Email Address', 'id' => 'email_address','required' => 'true']) !!}
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                @include('common.label', ['field' => 'description', 'labelText' => 'Description', 'isRequired' => true])

                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'description','required' => 'true']) !!}
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="form-group m-0">
                {!! Form::button('Submit Review <i class="lni lni-arrow-right"></i>', ['type' => 'submit', 'class' => 'btn btn-white stretched-link hover-black', 'name' => 'submit']) !!}

                <div id="success_message" class="mt-1"></div>
            </div>
        </div>
    {!! Form::close() !!}
</div>