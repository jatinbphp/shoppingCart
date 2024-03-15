@if(!empty($orders))
                            @foreach($orders as $key => $value)
                                <div class="row align-items-center justify-content-start m-0 py-4 br-bottom">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                        <div class="cart_single d-flex align-items-start">
                                            <div class="cart_single_caption pl-3">
                                                <p class="mb-0">
                                                    <span class="text-muted small">
                                                        {{env('ORDER_PREFIX').'-'.date("Y", strtotime($value->created_at)).'-'.$value->id}}
                                                    </span>
                                                </p>
                                                <h4 class="product_title fs-sm ft-medium mb-1 lh-1">
                                                    {{$value->user->name}} ({{$value->user->email}})
                                                </h4>
                                                <p class="mb-2">
                                                    <span class="text-dark medium">
                                                    No. of Products: {{count($value->orderItems)}}
                                                    </span>
                                                </p>
                                                <h4 class="fs-sm ft-bold mb-0 lh-1">
                                                    {{env('CURRENCY').number_format($value->total_amount, 2);}}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-3 col-6">
                                        <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
                                        <div class="delv_status">
                                            @php
                                            $status = [
                                                'pending' => '<span class="ft-medium small text-primary bg-light-primary rounded px-3 py-1">Pending</span>',
                                                'reject'  => '<span class="ft-medium small text-warning bg-light-warning rounded px-3 py-1">Reject</span>',
                                                'complete'=> '<span class="ft-medium small text-success bg-light-success rounded px-3 py-1">Complete</span>',
                                                'cancel'  => '<span class="ft-medium small text-danger bg-light-danger rounded px-3 py-1">Cancel</span>',
                                            ];
                                            @endphp
                                            {!! $status[$value->status] !!}
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                                        <p class="mb-1 p-0"><span class="text-muted">Order date by:</span></p>
                                        <h6 class="mb-0 ft-medium fs-sm">
                                            {{date("d, F Y", strtotime($value->created_at))}}
                                        </h6>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-3 col-6">
                                        <a href="{{route('order-details', $value->id)}}" class="btn btn-sm btn-primary rounded" title="Order Details"><i class="lni lni-eye"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="ord_list_footer d-flex align-items-center justify-content-between br-top px-3">
                                <div class="col-xl-12 col-lg-12 col-md-12 pl-0 py-2 olf_flex d-flex align-items-center justify-content-between">
                                    <div class="olf_flex_inner hide_mob">
                                        <p class="m-0 p-0">
                                            <span class="text-muted medium">You Order list is empty.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif