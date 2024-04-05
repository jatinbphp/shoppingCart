<div class="header header-dark">
    <div class="container">
        <nav id="navigation" class="navigation navigation-landscape">
            <div class="nav-header">
                <a class="nav-brand" href="{{route('home')}}">
                    <img src="{{url('assets/website/images/logo.png') }}?{{ time() }}" class="logo" alt="" />
                </a>
                <div class="nav-toggle"></div>

                @include ('layouts.header.mobile-menu')

            </div>
            <div class="nav-menus-wrapper" style="transition-property: none;">

                @include ('layouts.header.desktop-menu')

            </div>
        </nav>
    </div>
</div>