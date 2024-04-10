<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('assets/website/css/styles.css') }}" rel="stylesheet" />
    <title></title>
</head>
<body>
    <div class="container">
        <p>Dear Admin,</p>

        <p>I hope this message finds you well. I wanted to inform you that <b>{{ $user->name }}</b> have recently placed an order on your website. Below are the details of my order:</p>

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
                        <th>Product Information</th>
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
                                    <div class="single_rev_caption d-flex align-items-start">
                                        <div class="single_capt_left pr-2">
                                            @if(!empty($item->product->product_image->image) && file_exists($item->product->product_image->image))
                                                <img src="{{url($item->product->product_image->image)}}" alt="..." width="50px">
                                            @else 
                                                <img src="{{url('assets/website/images/default-image.png')}}" alt="..." width="50px">
                                            @endif
                                        </div>
                                        <div class="single_capt_right">
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
                                        </div>
                                    </div>
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
                        <td class="text-right">{{ env('CURRENCY') }}{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total</strong></td>
                        <td class="text-right">{{ env('CURRENCY') }}{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <p>Thank you.</p>
        <p>Best.</p>
    </div>
</body>
</html>
