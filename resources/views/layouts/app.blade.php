@php
$settings = \App\Models\Setting::where('id', '1')->first();
@endphp
<!DOCTYPE html>
<html lang="" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no"/>
        <link rel="shortcut icon" href="{{url('assets/website/images/favicon.ico') }}" type="image/x-icon" />
        <title>{{ config('app.name', 'Blu Leisure') }}</title>
        <link href="{{asset('assets/website/css/styles.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="main-wrapper">
            @include ('layouts.header-menu')

            @yield('content')

            @include ('layouts.footer-menu')

            @include ('modals.product-quick-view')

            @include ('modals.search-products')
            
            @include ('modals.wishlist-products')

            @include ('modals.cart-products')

            <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
        </div>

        @include ('layouts.footer')

    </body>
</html>