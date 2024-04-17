<div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
    <div class="d-block border rounded mfliud-bot">
        <div class="dashboard_author">
            <h4 class="px-3 py-2 mb-0 lh-2 gray fs-sm ft-medium text-muted text-uppercase text-left">My Account</h4>
            <ul class="dahs_navbar">
                <li>
                    <a href="{{route('orders-list')}}" @if(isset($menu) && $menu=='orders') class="active" @endif>
                        <i class="lni lni-shopping-basket mr-2"></i>My Orders
                    </a>
                </li>
                <li>
                    <a href="{{route('wishlist')}}" @if(isset($menu) && $menu=='wishlists') class="active" @endif>
                        <i class="lni lni-heart mr-2"></i>Wishlist
                    </a>
                </li>
                <li>
                    <a href="{{route('addresses.index')}}" @if(isset($menu) && $menu=='addresses') class="active" @endif>
                        <i class="lni lni-map-marker mr-2"></i>Addresses
                    </a>
                </li>
                <li>
                    <a href="{{route('profile-info')}}" @if(isset($menu) && $menu=='profile-info') class="active" @endif>
                        <i class="lni lni-user mr-2"></i>Profile Info
                    </a>
                </li>
                <li>
                    <a href="{{route('change.password')}}" @if(isset($menu) && $menu=='change-password') class="active" @endif>
                    <i class="fas fa-lock mr-2"></i>Change Password
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="lni lni-power-switch mr-2"></i>Log Out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>