<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => 'orders.addproduct', 'method' => 'post', 'id' => 'addProductForm']) !!}
                <div class="modal-header">
                    {!! Html::tag('h5', 'Add Product', ['class' => 'modal-title']) !!}

                    {!! Form::button('<span aria-hidden="true">&times;</span>', ['type' => 'button', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-label' => 'Close']) !!}
                </div>
                <div class="modal-body">
                    {!! Form::hidden('order_id', $flag_order_id, ['id' => 'flag_order_id']) !!}
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
                            @include('admin.common.label', ['field' => 'product_id', 'labelText' => 'Select Product', 'isRequired' => true])

                            {!! Form::select("product_id", $products, null, ["class" => "form-control select2", "id" => "product_id", 'placeholder' => 'Please Select', 'style' => 'width:100%']) !!}
                            <span class="text-danger product_id"></span>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                            @include('admin.common.label', ['field' => 'quantity', 'labelText' => 'Quantity', 'isRequired' => true])

                            {!! Form::number('quantity', 1, ['class' => 'form-control', 'placeholder' => 'Enter Quantity', 'id' => 'quantity']) !!}
                            <span class="text-danger quantity"></span>
                        </div>
                    </div>
                    <div id="ajaxOption"></div>
                </div>
                <div class="modal-footer">
                    {!! Form::button('<i class="fa fa-plus pr-1"></i> Add', ['type' => 'submit', 'class' => 'btn btn-sm btn-info', 'id' => 'add_product']) !!}

                    {!! Form::button('<i class="fa fa-times pr-1"></i> Close', ['type' => 'button', 'class' => 'btn btn-sm btn-secondary', 'data-dismiss' => 'modal']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="myOptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => 'orders.editoption', 'method' => 'post', 'id' => 'editProductOptionForm']) !!}
                <div class="modal-header">
                    {!! Html::tag('h5', 'Edit Option', ['class' => 'modal-title']) !!}

                    {!! Form::button('<span aria-hidden="true">&times;</span>', ['type' => 'button', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-label' => 'Close']) !!}
                </div>
                <div class="modal-body">
                    {!! Form::hidden('product_id', null, ['class' => 'form-control', 'id' => 'edit_product_id']) !!}

                    {!! Form::hidden('option_id', null, ['class' => 'form-control', 'id' => 'edit_option_id']) !!}
                    
                    {!! Form::hidden('cart_id', null, ['class' => 'form-control', 'id' => 'edit_cart_id']) !!}
                    <div id="ajaxEditOption"></div>
                </div>
                <div class="modal-footer">                    
                    {!! Form::button('<i class="fa fa-edit pr-1"></i> Update', ['type' => 'submit', 'class' => 'btn btn-sm btn-info', 'id' => 'edit_product']) !!}

                    {!! Form::button('<i class="fa fa-times pr-1"></i> Close', ['type' => 'button', 'class' => 'btn btn-sm btn-secondary', 'data-dismiss' => 'modal']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>