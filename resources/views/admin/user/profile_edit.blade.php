@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        @include('admin.common.header', ['menu' => $menu, 'breadcrumb' => [['route' => route('admin.dashboard'), 'title' => 'Dashboard']], 'active' => $menu])
        
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