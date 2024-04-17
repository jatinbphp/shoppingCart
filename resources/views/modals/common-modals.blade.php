<!-- Modal -->
<div class="modal fade lg-modal" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {!! Form::button('<span class="ti-close"></span>', [
                    'type' => 'button',
                    'class' => 'close',
                    'data-dismiss' => 'modal',
                    'aria-label' => 'Close'
                ]) !!}
                <h5 class="modal-title" id="commonModalLabel">Review Description</h5>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<!-- Cart -->
<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Cart">
    <div class="rightMenu-scroll">
        <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
            <h4 class="cart_heading fs-md ft-medium mb-0">Cart Products List</h4>
            {!! Html::tag('button', '<i class="ti-close"></i>', [
                'id' => 'close-cart-sidebar',
                'class' => 'close_slide'
            ]) !!}
        </div>
        <div class="right-ch-sideBar">
            <div class="cart_select_items py-2">
                <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                    <div class="cart_single d-flex align-items-center">
                        <p>Your Cart is empty.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product View Modal -->
<div class="modal fade lg-modal" id="quickviewModal" tabindex="-1" role="dialog" aria-labelledby="quickviewmodal" aria-hidden="true">
    <div class="modal-dialog modal-xl login-pop-form" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<!-- Wishlist -->
<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Wishlist">
    <div class="rightMenu-scroll">
        <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
            <h4 class="cart_heading fs-md ft-medium mb-0">Wishlist Products</h4>
            {!! Html::tag('button', '<i class="ti-close"></i>', [
                'id' => 'close-wishlist-sidebar',
                'class' => 'close_slide'
            ]) !!}
        </div>
        <div class="right-ch-sideBar">  
            <div class="cart_select_items py-2">
                <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
                    <div class="cart_single d-flex align-items-center">
                        <p>Your wishlist is empty.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search -->
<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Search">
    <div class="rightMenu-scroll">
        <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
            <h4 class="cart_heading fs-md ft-medium mb-0">Search Products</h4>
            {!! Html::tag('button', '<i class="ti-close"></i>', [
                'id' => 'search-close',
                'class' => 'close_slide'
            ]) !!}
        </div>
        <div class="cart_action px-3 py-4">
            {!! Form::open(['route' => 'products', 'method' => 'GET', 'id' => 'searchProductForm', 'class' => 'form m-0 p-0']) !!}
                <div class="form-group">
                    {!! Form::text('keyword', (isset($keyword) && !empty($keyword)) ? $keyword : null, ['class' => 'form-control', 'placeholder' => 'Product Keyword..']) !!}
                </div>
                <div class="form-group mb-0">
                    {!! Form::submit('Search Product', ['class' => 'btn d-block full-width btn-dark']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>