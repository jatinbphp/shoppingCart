<!-- Search -->
<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Search">
    <div class="rightMenu-scroll">
        <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
            <h4 class="cart_heading fs-md ft-medium mb-0">Search Products</h4>
            <button onclick="closeSearch()" class="close_slide"><i class="ti-close"></i></button>
        </div>
        <div class="cart_action px-3 py-4">
            {!! Form::open(['route' => 'products', 'method' => 'GET', 'id' => 'searchProductForm', 'class' => 'form m-0 p-0']) !!}
                <div class="form-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Product Keyword.." />
                </div>
                <div class="form-group mb-0">
                    <button type="submit" class="btn d-block full-width btn-dark">Search Product</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>