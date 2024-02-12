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
                <div class="panel-heading">Order Details</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Invoice :</label>
                                <p class="form-control-static">{{ $order->order_id }}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Customer Name :</label>
                                <p class="form-control-static">{{ $order->user->name }}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Order Date :</label>
                                <p class="form-control-static">{{ $order->created_at->format('Y-m-d') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>Order Items:</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->product_name }}</td>
                                        <td>{{ $item->product_qty }}</td>
                                        <td>{{ $item->product_price }}</td>
                                        <td>{{ $item->sub_total }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Address:</label>
                                <p class="form-control-static">
                                    {{ $order->address->first_name }} {{ $order->address->last_name }}<br>
                                    {{ $order->address->company }}<br>
                                    {{ $order->address->address_line1 }}<br>
                                    {{ $order->address->city }}, {{ $order->address->state }}<br>
                                    {{ $order->address->country }}<br>
                                    {{ $order->address->pincode }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Comment :</label>
                                <p class="form-control-static">{{ $order->notes }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Total Amount :</label>
                                <p class="form-control-static">{{ $order->total_amount }}</p>
                            </div>
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
