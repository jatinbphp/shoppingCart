@extends('layouts.app')

@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'Add/Edit Address']])

<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
            
            @include ('my-account.dashboard-menu', ['menu' => 'addresses'])

            <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                <form>
                    <div class="row">
                        <div class="col-12 col-lg-12 col-xl-12 col-md-12 mb-3">
                            <h4 class="ft-medium fs-lg">Add New Address</h4>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">First Name *</label>
                                <input type="text" class="form-control" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Last Name *</label>
                                <input type="text" class="form-control" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Email *</label>
                                <input type="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Company</label>
                                <input type="text" class="form-control" placeholder="Company Name (optional)">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Address 1 *</label>
                                <input type="text" class="form-control" placeholder="Address 1">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Address 2</label>
                                <input type="text" class="form-control" placeholder="Address 2">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Country *</label>
                                <select class="custom-select">
                                    <option value="1" selected="">India</option>
                                    <option value="2">United State</option>
                                    <option value="3">United Kingdom</option>
                                    <option value="4">China</option>
                                    <option value="5">Pakistan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">City / Town *</label>
                                <input type="text" class="form-control" placeholder="City / Town">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">ZIP / Postcode *</label>
                                <input type="text" class="form-control" placeholder="Zip / Postcode">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="text-dark">Mobile Number *</label>
                                <input type="text" class="form-control" placeholder="Mobile Number">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <input id="delivery" class="checkbox-custom" name="delivery" type="checkbox">
                                <label for="delivery" class="checkbox-custom-label">Set Default delivery address</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group text-center">
                                <a href="#" class="btn btn-dark full-width">Add & Save card</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection