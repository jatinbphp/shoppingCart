@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper" style="min-height: 946px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$menu}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('settings.index')}}">{{$menu}}</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            @include ('admin.common.error')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Edit {{$menu}}</h3>
                        </div>
                        {!! Form::model($settings,['url' => route('settings.update',['setting' => $settings->id]),'method'=>'patch','id' => 'categorysForm','class' => 'form-horizontal','files'=>true]) !!}
                        <div class="card-body">
                            @include ('admin.setting.form')
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left pr-1"></i> Back</a>
                            <button class="btn btn-sm btn-info float-right" type="submit"><i class="fa fa-edit pr-1"></i> Update</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
