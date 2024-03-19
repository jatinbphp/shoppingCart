<!-- Modal content -->
<div class="modal-header">
    <h5 class="modal-title" id="photoModalLabel">Order Details</h5>
    {!! Form::button('<span aria-hidden="true">&times;</span>', [
        'type' => 'button',
        'class' => 'close',
        'data-dismiss' => 'modal',
        'aria-label' => 'Close'
    ]) !!}
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
                                    @if(!empty($order->orderItems))
                                        @foreach ($order->orderItems as $item)
                                            <tr>
                                                <td>
                                                    {{ $item->product->product_name }}
                                                    @if(!empty($item->orderOptions))
                                                        @foreach ($item->orderOptions as $option)
                                                            @if($option->name=='COLOR')
                                                                </br><small><b>{{$option->name}} :</b> <i class="fas fa-square" style="color: {{$option->value}}"></i></small>
                                                            @else
                                                                </br><small><b>{{$option->name}} :</b> {{$option->value}}</small>
                                                            @endif
                                                        @endforeach
                                                    @endif
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
                                            @php
                                            $addressArray = [];
                                            if(!empty($order->address_info)){
                                                $addressArray = json_decode($order->address_info);
                                            }
                                            @endphp

                                            <h5 class="ft-medium mb-1">
                                                @if(!empty($addressArray->first_name))
                                                    {{ $addressArray->first_name }}
                                                @endif

                                                @if(!empty($addressArray->last_name))
                                                    {{ $addressArray->last_name }}
                                                @endif
                                            </h5>

                                            <p>
                                                @if (!empty($addressArray->title))
                                                    <br><b>{{ $addressArray->title }}</b>
                                                @endif

                                                @if (!empty($addressArray->company))
                                                    <br>{{ $addressArray->company }}
                                                @endif

                                                @if (!empty($addressArray->address_line1))
                                                    <br>{{ $addressArray->address_line1 }},
                                                @endif

                                                @if (!empty($addressArray->address_line2))
                                                    <br>{{ $addressArray->address_line2 }},
                                                @endif

                                                @if (!empty($addressArray->city) || !empty($addressArray->state) || !empty($addressArray->country) || !empty($addressArray->pincode))
                                                    <br>
                                                    @if (!empty($addressArray->pincode)) {{ $addressArray->pincode }} - @endif
                                                    @if (!empty($addressArray->city)) {{ $addressArray->city }}, @endif
                                                    @if (!empty($addressArray->state)) {{ $addressArray->state }}, @endif
                                                    @if (!empty($addressArray->country)) {{ $addressArray->country }} @endif
                                                @endif
                                            </p>
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
    {!! Form::button('<i class="fa fa-times pr-1"></i> Close', ['type' => 'button', 'class' => 'btn btn-sm btn-secondary', 'data-dismiss' => 'modal']) !!}
</div>