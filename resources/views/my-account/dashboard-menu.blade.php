<div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
    <div class="d-block border rounded mfliud-bot">
        <div class="dashboard_author">
            <h4 class="px-3 py-2 mb-0 lh-2 gray fs-sm ft-medium text-muted text-uppercase text-left">My Account</h4>
            <ul class="dahs_navbar">
                <li>
                    <a href="{{route('my-account.orders')}}" @if(isset($menu) && $menu=='orders') class="active" @endif>
                        <i class="lni lni-shopping-basket mr-2"></i>My Order
                    </a>
                </li>

                <li>
                    <a href="{{route('my-account.wishlist')}}" @if(isset($menu) && $menu=='wishlists') class="active" @endif>
                        <i class="lni lni-heart mr-2"></i>Wishlist
                    </a>
                </li>

                <li>
                    <a href="{{route('my-account.profile-info')}}" @if(isset($menu) && $menu=='profile-info') class="active" @endif>
                        <i class="lni lni-user mr-2"></i>Profile Info
                    </a>
                </li>

                <li>
                    <a href="{{route('my-account.addresses')}}" @if(isset($menu) && $menu=='addresses') class="active" @endif>
                        <i class="lni lni-map-marker mr-2"></i>Addresses
                    </a>
                </li>

                <li>
                    <a href="payment-methode.html">
                        <i class="lni lni-mastercard mr-2"></i>Payment Methode
                    </a>
                </li>

                <li>
                    <a href="login.html">
                        <i class="lni lni-power-switch mr-2"></i>Log Out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>