@extends('layouts.app')
@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'Addresses']])
<section class="middle addresses-page">
    <div class="container">

        @include ('common.error')

        <div class="row justify-content-center justify-content-between">

            @include ('common.dashboard-menu', ['menu' => 'addresses'])

            <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                <div class="row align-items-start">

                    @if (isset($addresses) && !empty($addresses))
                        @foreach ($addresses as $key => $value)

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" id="address-box-{{ $value->id ?? null }}">
                                <div class="card-wrap border rounded mb-4">
                                    <div class="card-wrap-header px-3 py-2 br-bottom d-flex align-items-center justify-content-between">
                                        <div class="card-header-flex">
                                            <h4 class="fs-md ft-bold mb-1">Delivery Address</h4>
                                        </div>
                                        <div class="card-head-last-flex">
                                            <a class="border p-3 circle text-dark d-inline-flex align-items-center justify-content-center" href="{{ route('addresses.edit', ['address' => $value->id]) }}">
                                                <i class="fas fa-pen-nib position-absolute"></i>
                                            </a>

                                            <a href="javascript:void(0)" class="border bg-white text-danger p-3 circle text-dark d-inline-flex align-items-center justify-content-center deleteRecord" data-id="{{$value->id}}">
                                                <i class="fas fa-times position-absolute"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-wrap-body px-3 py-3">
                                        <h5 class="ft-medium mb-1">
                                            {{ $value->first_name ?? "-" }} {{ $value->last_name ?? "-" }}
                                        </h5>

                                        <p>
                                            @if (!empty($value->title))
                                                <br><b>{{ $value->title }}</b>
                                            @endif

                                            @if (!empty($value->company))
                                                <br>{{ $value->company }}
                                            @endif

                                            @if (!empty($value->address_line1))
                                                <br>{{ $value->address_line1 }},
                                            @endif

                                            @if (!empty($value->address_line2))
                                                <br>{{ $value->address_line2 }},
                                            @endif

                                            @if (!empty($value->city) || !empty($value->state) || !empty($value->country) || !empty($value->pincode))
                                                <br>
                                                @if (!empty($value->pincode)) {{ $value->pincode }} - @endif
                                                @if (!empty($value->city)) {{ $value->city }}, @endif
                                                @if (!empty($value->state)) {{ $value->state }}, @endif
                                                @if (!empty($value->country)) {{ $value->country }} @endif
                                            @endif
                                        </p>

                                        @if(!empty($value->mobile_phone))
                                            <p>
                                                <span class="text-dark ft-medium">Call:</span> 
                                                <a href="tel:{{$value->mobile_phone}}">{{$value->mobile_phone}}</a><br>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                        @endforeach
                    @endif
                </div>
                <div class="row align-items-start">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <a href="{{ route('addresses.create') }}" class="btn stretched-link borders full-width">
                                <i class="fas fa-plus mr-2"></i>Add New Address
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('jquery')
<script type="text/javascript">
//Delete Record
$('.addresses-page').on('click', '.deleteRecord', function (event) {
    event.preventDefault();
    var id = $(this).attr("data-id");

    swal({
        title: "Are you sure?",
        text: "You want to delete this record?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: "No, cancel",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: "{{ url('addresses') }}/" + id,
                type: "DELETE",
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                success: function(data) {
                    swal("Deleted", "Your data successfully deleted!", "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
            });

        } else {
            swal("Cancelled", "Your data safe!", "error");
        }
    });
});
</script>
@endsection