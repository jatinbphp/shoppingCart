<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('orders.addproduct')}}" method="post" id="addProductForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form inside modal -->
                    {!! Form::hidden('order_id', $flag_order_id, ['id' => 'flag_order_id']) !!}
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
                            <label class="control-label" for="product_id">Select Product :<span class="text-red">*</span></label>
                            {!! Form::select("product_id", $products, null, ["class" => "form-control select2", "id" => "product_id", 'placeholder' => 'Please Select', 'style' => 'width:100%']) !!}
                            <span class="text-danger product_id"></span>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}" required>
                            <label class="control-label" for="quantity">Quantity :<span class="text-red">*</span></label>
                            {!! Form::number('quantity', 1, ['class' => 'form-control', 'placeholder' => 'Enter Quantity', 'id' => 'quantity']) !!}
                            <span class="text-danger quantity"></span>
                        </div>
                    </div>

                    <div id="ajaxOption"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-info" id="add_product"><i class="fa fa-plus  pr-1"></i> Add</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times pr-1"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myOptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('orders.editoption')}}" method="post" id="editProductOptionForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Option</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('product_id', null, ['class' => 'form-control', 'id' => 'edit_product_id']) !!}
                    {!! Form::hidden('option_id', null, ['class' => 'form-control', 'id' => 'edit_option_id']) !!}
                    {!! Form::hidden('cart_id', null, ['class' => 'form-control', 'id' => 'edit_cart_id']) !!}

                    <div id="ajaxEditOption"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-info" id="edit_product"><i class="fa fa-edit pr-1"></i> Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times pr-1"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>