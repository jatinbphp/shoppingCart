@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        @include('admin.common.header', ['menu' => $menu, 'breadcrumb' => [['route' => route('banners.index'), 'title' => $menu]], 'active' => 'Edit'])

        <section class="content">
            @include ('admin.common.error')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Edit Banner</h3>
                        </div>

                        {!! Form::model($banner,['url' => route('banners.update',['banner'=>$banner->id]),'method'=>'patch','id' => 'bannerForm','class' => 'form-horizontal','files'=>true]) !!}
                            
                            <div class="card-body">
                                @include ('admin.banner.form')
                            </div>

                            <div class="card-footer">
                                @include('admin.common.footer-buttons', ['route' => 'banners.index', 'type' => 'update'])
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection