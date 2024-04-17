@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        @include('admin.common.header', ['menu' => $menu, 'breadcrumb' => [['route' => route('products.index'), 'title' => $menu]], 'active' => 'Import'])

        <section class="content">
            @include ('admin.common.error')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title w-100">
                                Import Products

                                <a class="btn btn-info btn-sm float-right" href="{{ url('assets/admin/dist/productImport.csv') }}" download><i class="fa fa-download"></i> Download Sample File</a>
                            </h3>
                        </div>

                        {!! Form::open(['url' => route('products.import.product.store'), 'id' => 'productsImportForm', 'class' => 'form-horizontal','files'=>true]) !!}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                            @include('admin.common.label', ['field' => 'file', 'labelText' => 'Upload CSV File', 'isRequired' => true])

                                            <div class="col-md-12">
                                                <div class="fileError">
                                                    {!! Form::file('file', ['class' => '', 'id'=> 'file', 'accept' => 'text/csv']) !!}
                                                </div>

                                                @include('admin.common.errors', ['field' => 'file'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('products.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left pr-1"></i> Back</a>
                                
                                {!! Form::button('<i class="fa fa-upload" aria-hidden="true"></i> Import', ['class' => 'btn btn-sm btn-info float-right', 'type' => 'submit']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
