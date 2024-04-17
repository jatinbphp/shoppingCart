@extends('layouts.app')
@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'Pages', "About Us"]])

{!! get_content_management_settings(3)['description'] !!}

@endsection