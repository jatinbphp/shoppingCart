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
        <title>@if(isset($title)) {{$title}} | @endif {{ config('app.name', 'Blu Leisure') }}</title>
        <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/select2/select2.min.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
        <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/summernote/summernote-bs4.min.css') }}">
        <link href="{{asset('assets/website/css/styles.css') }}" rel="stylesheet" />
    </head>
    <body>
        <div id="main-wrapper" class="bg-dark">
            @include ('layouts.header')

            @yield('content')

            @include ('layouts.footer')

            @include ('modals.common-modals')

            <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
        </div>

        @include ('layouts.scripts')

    </body>
</html>