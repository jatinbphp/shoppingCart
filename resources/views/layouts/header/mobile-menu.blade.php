<div class="mobile_nav">
    <ul>
        <li>
            <a href="javaScript:void(0);" id="search-open"><i class="lni lni-search-alt"></i></a>
        </li>
        <li>
            <a href="javaScript:void(0);"><i class="lni lni-user"></i></a>
        </li>
        <li>
            <a href="javaScript:void(0);" data-url="{{route('wishlist.view')}}" id="open-wishlist-sidebar" title="Wishlist">
                <i class="lni lni-heart"></i><span class="dn-counter wishlist-counter">{{count(getWishlistProductIds())}}</span>
            </a>
        </li>
        <li>
            <a href="javaScript:void(0);" data-url="{{route('cart.view')}}" id="open-cart-sidebar" title="Shopping Cart">
                <i class="lni lni-shopping-basket"></i><span class="dn-counter cart-counter">{{count(getTotalCartProducts())}}</span>
            </a>
        </li>
    </ul>
</div>