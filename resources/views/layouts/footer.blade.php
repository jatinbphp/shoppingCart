<footer class="dark-footer skin-dark-footer style-2">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                
                @include ('layouts.footer.site-info')
                
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Supports</h4>
                        <ul class="footer-menu">
                            <li><a href="javaScript:;">Size Guide</a></li>
                            <li><a href="javaScript:;">Shipping & Returns</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Shop</h4>
                        <ul class="footer-menu">
                            @include ('layouts.footer.footer-shop-menu')
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Company</h4>
                        <ul class="footer-menu">
                            <li><a href="{{route('about-us')}}">About Us</a></li>
                            <li><a href="{{route('contact-us.index')}}">Contact Us</a></li>
                            <li><a href="{{route('faq')}}">FAQ's</a></li>
                            <li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
                            <li><a href="{{route('terms-conditions')}}">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>                

                <!-- @include ('layouts.footer.subscribe-form') -->
            </div>
        </div>
    </div>

    @include ('layouts.footer.copy-rights')
    
</footer>