<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('assets/website/css/styles.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/website/css/plugins/bootstrap.min.css') }}" rel="stylesheet" />
    <title>Order Details</title>
    <style type="text/css">
        table.table.m-0{border:1px solid #eaeff5}
        .table-responsive table{white-space:nowrap}
        .table{width:100%;max-width:100%;margin-bottom:1rem;background-color:transparent}
        .m-0{margin:0!important}
        .container{max-width:1200px}
        p{margin-top:0;margin-bottom:1rem}
        .mb-4{margin-bottom:1.5rem!important}
        .table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{border-top:1px solid #f0f4f7}
        .table tr th,.table tr td{border-color:#eaeff5;padding:12px 15px;vertical-align:middle}
        .nav-brand{padding:13px 15px;font-size:24px;margin-right:1rem;padding-left:0;text-decoration:none!important}
        table.table tr th{font-weight:600}
        .table thead th{vertical-align:bottom;border-bottom:2px solid #e9ecef}
        .table tr th,.table tr td{border-color:#eaeff5;padding:12px 15px;vertical-align:middle}
        .table thead th{vertical-align:bottom;border-bottom:2px solid transparent;border-top:0!important;text-align: left;}
        .fa, .fas {font-family: 'Font Awesome 5 Free';font-weight: 900;}
    </style>
</head>
<body>
    <div class="container">
        <p>Dear Admin,</p>

        <p>I hope this message finds you well. I wanted to inform you that <b>{{ $order->user->name }}</b> have recently placed an order on your website. Below are the details of my order:</p>

        <div class="table-responsive mb-4">
            <table class="table m-0">
                <tr>
                    <td style="background: #031424; text-align: center;">
                        <a class="nav-brand" href="{{route('home')}}">
                            <img src="{{url('assets/website/images/logo.png') }}?{{ time() }}" class="logo" alt="" />
                        </a>
                    </td>
                </tr>
            </table>
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
                        <th style="text-align: right;">Unit Price</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @if(!empty($order->orderItems))
                        @foreach ($order->orderItems as $item)
                            <tr> 
                                <td>
                                    <div class="single_rev_caption d-flex align-items-start">
                                        <div class="single_capt_left pr-2" style=" float: left;  margin-right: 10px;">
                                            @if(!empty($item->product->product_image->image) && file_exists($item->product->product_image->image))
                                                <img src="{{url($item->product->product_image->image)}}" alt="..." width="50px">
                                            @else 
                                                <img src="{{url('assets/website/images/default-image.png')}}" alt="..." width="50px">
                                            @endif
                                        </div>
                                        <div class="single_capt_right">
                                            <h4 class="product_title fs-sm ft-medium mb-1 lh-1" style="margin: 0px;">
                                                {{ $item->product->product_name }}
                                            </h4>
                                            <p class="m-0">
                                                @if(!empty($item->orderOptions))
                                                    @foreach ($item->orderOptions as $option)
                                                        @if($option->name=='COLOR')
                                                            <div style="display: inline-block;" class="text-dark medium">
                                                                <div style="float: left;">{{$option->name}} :</div>
                                                                <div style="background-color: {{$option->value}};width: 20px;height: 20px;float: left;border: 1px solid #000;"></div>
                                                            </div>
                                                        @else
                                                            <div class="text-dark medium">{{$option->name}} : {{$option->value}}</div></br>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->product->sku }}</td>
                                <td>{{ $item->product_qty }}</td>
                                <td style="text-align: right;">£{{ number_format($item->product_price, 2) }}</td>
                                <td style="text-align: right;">£{{ number_format($item->sub_total, 2) }}</td>
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
                        <td colspan="4"  style="text-align: right;"><strong>Sub-Total</strong></td>
                        <td style="text-align: right;">£{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4"  style="text-align: right;"><strong>Total</strong></td>
                        <td style="text-align: right;">£{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <p>Thank you.</p>
        <p>Best.</p>
    </div>
</body>
</html>
