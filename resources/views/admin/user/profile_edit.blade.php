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
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Profile</li>
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
                            <h3 class="card-title">Edit Profile</h3>
                        </div>

                        {!! Form::model($user,['url' => url('admin/profile_update/'.$user->id),'method'=>'patch','id'=>'profileForm','class' => 'form-horizontal','files'=>true]) !!}
                  
                            <div class="card-body">
                                @include ('admin.user.profile_form')
                            </div>

                            <div class="card-footer">
                                @include('admin.common.footer-buttons', ['route' => 'admin.dashboard', 'type' => 'update'])
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection