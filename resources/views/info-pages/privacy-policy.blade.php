@extends('layouts.app')
@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'Pages', "Privacy Policy"]])
<section class="middle">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-11 col-lg-12 col-md-6 col-sm-12">
                <div class="abt_caption">
                    {!! get_content_management_settings(2)['description'] !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection