<div class="row align-items-center justify-content-start m-0 py-2">
    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
        <div class="cart_single align-items-start">
            <div class="cart_single_caption">
                <p class="mb-0">
                    <span class="text-muted small">
                        {{env('ORDER_PREFIX').'-'.date("Y", strtotime($created_at)).'-'.$id}}
                    </span>
                </p>
                <h4 class="product_title fs-sm ft-medium mb-1 lh-1">
                    {{$user['name']}}
                </h4>
                <p class="mb-2">
                    <span class="text-dark medium">
                    No. of Products: {{count($order_items)}}
                    </span>
                </p>
                <h4 class="fs-sm ft-bold mb-0 lh-1">
                    <span class="text-muted">Total</span> : {{env('CURRENCY').number_format($total_amount, 2);}}
                </h4>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-2 col-md-3 col-6">
        <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
        <div class="delv_status">
            @php
            $status_array = [
                'pending' => '<span class="ft-medium small text-primary bg-light-primary rounded px-3 py-1">Pending</span>',
                'shipped'  => '<span class="ft-medium small text-warning bg-light-warning rounded px-3 py-1">Shipped</span>',
                'completed'=> '<span class="ft-medium small text-success bg-light-success rounded px-3 py-1">Completed</span>',
                'cancelled'  => '<span class="ft-medium small text-danger bg-light-danger rounded px-3 py-1">Cancelled</span>',
            ];
            @endphp
            {!! $status_array[$status] !!}
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-4 col-6">
        <p class="mb-1 p-0"><span class="text-muted">Order date by:</span></p>
        <h6 class="mb-0 ft-medium fs-sm">
            {{date("d, F Y", strtotime($created_at))}}
        </h6>
    </div>
    <div class="col-xl-1 col-lg-1 col-md-1 col-6">
        <a href="{{route('order-details', $id)}}" class="btn btn-sm btn-primary rounded" title="Order Details"><i class="lni lni-eye"></i></a>
    </div>
</div>