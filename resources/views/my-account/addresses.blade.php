@extends('layouts.app')

@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'Addresses']])

<section class="middle">
    <div class="container">
        @include ('common.error')
        <div class="row justify-content-center justify-content-between">
            @include ('my-account.dashboard-menu', ['menu' => 'addresses'])
            <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                <div class="row align-items-start">
                    @if (isset($user_addresses) && !empty($user_addresses))
                        @foreach ($user_addresses as $key => $value)
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" id="address-box-{{ $value->id ?? null }}">
                                <div class="card-wrap border rounded mb-4">
                                    <div class="card-wrap-header px-3 py-2 br-bottom d-flex align-items-center justify-content-between">
                                        <div class="card-header-flex">
                                            <h4 class="fs-md ft-bold mb-1">Shipping Address</h4>
                                            <p class="m-0 p-0"><span class="text-success bg-light-success small ft-medium px-2 py-1{{ $value->is_default == 1 ? ""  : " d-none"}}">Primary Account</span></p>
                                        </div>
                                        <div class="card-head-last-flex">
                                            <a class="border p-3 circle text-dark d-inline-flex align-items-center justify-content-center" href="{{ route('my-account.edit-address', ['id' => $value->id]) }}"><i class="fas fa-pen-nib position-absolute"></i></a>
                                            <a href="{{ route('my-account.delete-address', ['id' => $value->id ?? null]) }}" class="border bg-white text-danger p-3 circle text-dark d-inline-flex align-items-center justify-content-center"><i class="fas fa-times position-absolute"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-wrap-body px-3 py-3">
                                        <h5 class="ft-medium mb-1">{{ $value->first_name ?? "-" }} {{ $value->last_name ?? "-" }}</h5>
                                        <p>{{ $value->address_line1 ?? "-"}} {{ $value->address_line2 ?? "-" }}<br>{{ $value->city ?? "-" }}, {{ $value->state ?? "-" }} {{ $value->pincode ?? "-" }}<br>{{ $value->country ?? "-" }}</p>
                                        <p class="lh-1 d-none"><span class="text-dark ft-medium">Email:</span> {{ $value->email ?? "-" }}</p>
                                        <p><span class="text-dark ft-medium">Call:</span> {{ $value->mobile_phone ?? "-" }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="row align-items-start">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <a href="{{ route('my-account.add-address') }}" class="btn stretched-link borders full-width"><i class="fas fa-plus mr-2"></i>Add New Address</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection