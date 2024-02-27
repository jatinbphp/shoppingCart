<!-- Modal content -->
<div class="modal-header">
    <h5 class="modal-title" id="photoModalLabel">Order Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Date Ordered</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>INV-{{ date('Y', strtotime($order->created_at)) }}-{{ $order->id }}</td>
                                        <td>{{ $order->user->name }} ({{ $order->user->email }})</td>
                                        <td>{{ $order->created_at }}</td>
                                        @php
                                        $status = [
                                            'pending' => '<span class="badge badge-primary">Pending</span>',
                                            'reject'  => '<span class="badge badge-warning">Reject</span>',
                                            'complete'=> '<span class="badge badge-success">Complete</span>',
                                            'cancel'  => '<span class="badge badge-danger">Cancel</span>',
                                        ];
                                        @endphp
                                        <td>{!! $status[$order->status] !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
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
                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->product_name }}</td>
                                            <td>{{ $item->product->sku }}</td>
                                            <td>{{ $item->product_qty }}</td>
                                            <td class="text-right">{{ env('CURRENCY') }}{{ number_format($item->product_price, 2) }}</td>
                                            <td class="text-right">{{ env('CURRENCY') }}{{ number_format($item->sub_total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" colspan="4">Sub-Total</th>
                                        <td class="text-right" id="grand_total">{{ env('CURRENCY') }}{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" colspan="4">Total</th>
                                        <td class="text-right" id="grand_total">{{ env('CURRENCY') }}{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        
                            <table class="table table-bordered">
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

                            <table class="table table-bordered">
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

                            <table class="table table-bordered">
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
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>