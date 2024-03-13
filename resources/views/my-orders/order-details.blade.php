@extends('layouts.app')

@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'My Account', 'My Order Details']])

<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
            
            @include ('my-account.dashboard-menu', ['menu' => 'orders'])
            
            <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                <div class="table-responsive mb-4">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Date Ordered</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>INV-{{ date('Y', strtotime($order->created_at)) }}-{{ $order->id }}</td>
                                <td>{{ $order->user->name }} ({{ $order->user->email }})</td>
                                <td>{{ $order->created_at }}</td>
                                @php
                                $status = [
                                    'pending' => '<span class="ft-medium small text-primary bg-light-primary rounded px-3 py-1">Pending</span>',
                                    'reject'  => '<span class="ft-medium small text-warning bg-light-warning rounded px-3 py-1">Reject</span>',
                                    'complete'=> '<span class="ft-medium small text-success bg-light-success rounded px-3 py-1">Complete</span>',
                                    'cancel'  => '<span class="ft-medium small text-danger bg-light-danger rounded px-3 py-1">Cancel</span>',
                                ];
                                @endphp
                                <td>
                                    {!! $status[$order->status] !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Quantity</th>
                                <th class="text-right">Unit Price</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($order->orderItems))
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <h4 class="product_title fs-sm ft-medium mb-1 lh-1">
                                                {{ $item->product->product_name }}
                                            </h4>
                                            <p class="m-0">
                                                @if(!empty($item->orderOptions))
                                                    @foreach ($item->orderOptions as $option)
                                                        @if($option->name=='COLOR')
                                                            <span class="text-dark medium">{{$option->name}} : <i class="fas fa-square" style="color: {{$option->value}}"></i></span></br>
                                                        @else
                                                            <span class="text-dark medium">{{$option->name}} : {{$option->value}}</span></br>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </p>
                                        </td>
                                        <td>{{ $item->product->sku }}</td>
                                        <td>{{ $item->product_qty }}</td>
                                        <td class="text-right">{{ env('CURRENCY') }}{{ number_format($item->product_price, 2) }}</td>
                                        <td class="text-right">{{ env('CURRENCY') }}{{ number_format($item->sub_total, 2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">No records found.</td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Sub-Total</strong></td>
                                <td>{{ env('CURRENCY') }}{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Total</strong></td>
                                <td>{{ env('CURRENCY') }}{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table m-0">
                        <tbody>
                            <tr>
                                <th>Address</th>
                            </tr>
                            <tr>
                                <td>
                                    {{ $order->address->first_name }} {{ $order->address->last_name }}
                                    @if ($order->address->company)
                                        <br>{{ $order->address->company }}
                                    @endif
                                    @if ($order->address->address_line1)
                                        <br>{{ $order->address->address_line1 }},
                                    @endif
                                    @if ($order->address->address_line2)
                                        <br>{{ $order->address->address_line2 }},
                                    @endif
                                    @if ($order->address->city || $order->address->state || $order->address->country || $order->address->pincode)
                                        <br>
                                        @if ($order->address->pincode){{ $order->address->pincode }} {{' - '}} @endif
                                        @if ($order->address->city){{ $order->address->city }}, @endif
                                        @if ($order->address->state){{ $order->address->state }}, @endif
                                        @if ($order->address->country){{ $order->address->country }} @endif
                                    @endif

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table m-0">
                        <tbody>
                            <tr>
                                <th>Comment</th>
                            </tr>
                            <tr>
                                <td>
                                    {{$order->notes}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table m-0">
                        <tbody>
                            <tr>
                                <th>Delivery Method</th>
                            </tr>
                            <tr>
                                <td>
                                    {{$order->delivey_method}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection