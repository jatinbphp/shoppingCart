@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        @include('admin.common.header', ['menu' => $menu, 'breadcrumb' => [['route' => route('content.index'), 'title' => $menu]], 'active' => 'Edit'])
        
        <section class="content">
            @include ('admin.common.error')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Edit Content</h3>
                        </div>

                        {!! Form::model($content,['url' => route('content.update',['content'=>$content->id]),'method'=>'patch','id' => 'contentForm','class' => 'form-horizontal','files'=>true]) !!}
                        
                            <div class="card-body">
                                @include ('admin.content.form')
                            </div>
                            
                            <div class="card-footer">
                                @include('admin.common.footer-buttons', ['route' => 'content.index', 'type' => 'update'])
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection