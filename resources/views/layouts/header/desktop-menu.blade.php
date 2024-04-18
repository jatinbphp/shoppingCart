<ul class="nav-menu">
    <li><a href="{{route('home')}}">Home</a></li>
    <li><a href="{{route('products')}}">Shop</a></li>
    
    @include ('layouts.header.categories-menu')

    <!-- <li><a href="{{route('about-us')}}">About Us</a></li> -->
    <li><a href="{{route('contact-us.index')}}">Contact Us</a></li>
</ul>
<ul class="nav-menu nav-menu-social align-to-right">
    <li>
        <a href="javaScript:void(0);" id="search-open" title="Search Products">
            <i class="lni lni-search-alt"></i>
        </a>
    </li>
    <li class="dropdown js-dropdown">
        <a href="javascript:void(0)" class="popup-title" data-toggle="dropdown" title="My Account" aria-label="user dropdown">
            <i class="lni lni-user"></i>
        </a>
        <ul class="dropdown-menu popup-content link">
            @guest
                <li class="current">
                    <a href="{{route('login')}}" class="dropdown-item medium text-medium">Login</a>
                </li>
            @else
                <li class="current">
                    <a href="{{route('profile-info')}}" class="dropdown-item medium text-medium">My Account</a>
                </li>
                <li class="current">
                    <a href="{{route('shopping-cart')}}" class="dropdown-item medium text-medium">Shopping Cart</a>
                </li>
                <li>
                    <a href="{{route('checkout')}}" class="dropdown-item medium text-medium">Checkout</a>
                </li>
                <li>
                    <a href="{{route('wishlist')}}" class="dropdown-item medium text-medium">Wishlist</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Log out') }}
                    </a>
                </li>
                <li>
                    {!! Form::open(['route' => 'logout', 'method' => 'POST', 'id' => 'logout-form', 'class' => 'd-none']) !!}
                    {!! Form::close() !!}
                </li>
            @endguest
        </ul>
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