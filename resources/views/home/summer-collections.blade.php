<section class="bg-cover" data-overlay="5" style="@if(!empty(get_settings()['image']) && file_exists(get_settings()['image'])) background: url('{{url(get_settings()['image'])}}');  @endif background-repeat:no-repeat fixed;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="deals_wrap text-center">
                    <h4 class="ft-medium text-light">{{get_settings()['first_title']}}</h4>
                    <h2 class="ft-bold text-light">{{get_settings()['second_title']}}</h2>
                    <p class="text-light">{{get_settings()['content']}}</p>
                    <div class="mt-5">
                        <a href="{{ route('products') }}" class="btn btn-white stretched-link">Start Shopping <i class="lni lni-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>