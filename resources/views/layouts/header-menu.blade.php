<div class="header header-light">
    <div class="container">
        <nav id="navigation" class="navigation navigation-landscape">
            <div class="nav-header">
                <a class="nav-brand" href="{{route('home')}}">
                    <img src="{{url('assets/website/images/logo.png') }}" class="logo" alt="" />
                </a>
                <div class="nav-toggle"></div>
                <div class="mobile_nav">
                    <ul>
                        <li>
                            <a href="javaScript:;" onclick="openSearch()"><i class="lni lni-search-alt"></i></a>
                        </li>
                        <li>
                            <a href="javaScript:;"><i class="lni lni-user"></i></a>
                        </li>
                        <li>
                            <a href="javaScript:;" onclick="openWishlist()"><i class="lni lni-heart"></i><span class="dn-counter">2</span></a>
                        </li>
                        <li>
                            <a href="javaScript:;" onclick="openCart()"><i class="lni lni-shopping-basket"></i><span class="dn-counter">0</span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="nav-menus-wrapper" style="transition-property: none;">
                <ul class="nav-menu">
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li><a href="{{route('products')}}">Shop</a></li>
                    <li>
                        <a href="javascript:void(0);">Clothing</a>
                        <ul class="nav-dropdown nav-submenu">
                            <li><a href="#">Female</a></li>
                            <li><a href="#">Male</a></li>
                            <li><a href="#">Kids</a></li>
                        </ul>
                    </li>
                    <li><a href="">Accessories</a></li>
                    <li><a href="">About Us</a></li>
                    <li><a href="">Contact Us</a></li>
                </ul>
                <ul class="nav-menu nav-menu-social align-to-right">
                    <li>
                        <a href="javaScript:;" onclick="openSearch()">
                        <i class="lni lni-search-alt"></i>
                        </a>
                    </li>
                    <li class="dropdown js-dropdown">
                        <a href="javascript:void(0)" class="popup-title" data-toggle="dropdown" title="User" aria-label="user dropdown">
                            <i class="lni lni-user"></i>
                        </a>
                        <ul class="dropdown-menu popup-content link">
                            @guest
                                <li class="current">
                                    <a href="{{route('login')}}" class="dropdown-item medium text-medium">Login</a>
                                </li>
                            @else
                                <li class="current">
                                    <a href="javascript:void(0);" class="dropdown-item medium text-medium">Cart</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item medium text-medium">Checout</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item medium text-medium">Wishlist</a>
                                </li>
                                 <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Log out') }}
                                    </a>
                                </li>
                                <li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </li>
                    <li>
                        <a href="javaScript:void(0);" data-url="{{route('products.wishlistview')}}" id="open-wishlist-sidebar">
                            <i class="lni lni-heart"></i><span class="dn-counter wishlist-counter">{{count(getWishlistProductIds())}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="javaScript:;" onclick="openCart()">
                        <i class="lni lni-shopping-basket"></i><span class="dn-counter">3</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>