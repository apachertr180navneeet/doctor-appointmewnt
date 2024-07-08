<div class="header-area">

    <div class="header-top-bar-info bg-gray d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-bar-wrap">
                        <div class="top-bar-left">
                            <div class="top-bar-text"><a href="#" class="font-medium display-inline">Now Hiring:</a> Are you a driven and motivated 1st Line IT Support Engineer?</div>
                        </div>
                        <div class="top-bar-right">
                            <ul class="top-bar-info">
                                <li class="info-item">
                                    <a href="tel:01228899900" class="info-link">
                                        <i class="info-icon fa fa-phone"></i>
                                        <span class="info-text"><strong>0122 8899900</strong></span>
                                    </a>
                                </li>
                                <li class="info-item">
                                    <i class="info-icon fa fa-map-marker-alt"></i>
                                    <span class="info-text">58 Howard Street #2 San Francisco</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-bottom-wrap header-sticky bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header position-relative">
                        <!-- brand logo -->
                        <div class="header__logo">
                            <a href="{{route('home')}}">
                                <img src="{{asset('assets/web/assets/images/logo/logo-dark.webp')}}" aria-label="Mitech Logo" width="160" height="48" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="header-right">

                            <!-- navigation menu -->
                            <div class="header__navigation menu-style-three d-none d-xl-block">
                                <nav class="navigation-menu">

                                    <ul>
                                        <li class="">
                                            <a href="{{route('home')}}"><span>Home</span></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>

                            <div class="header-search-form-two">
                                <form action="#" class="search-form-top-active">
                                    <div class="search-icon" id="search-overlay-trigger">
                                        <a href="javascript:void(0)">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </div>
                                </form>
                            </div>

                            <!-- mobile menu -->
                            <div class="mobile-navigation-icon d-block d-xl-none" id="mobile-menu-trigger">
                                <i></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<!--====================  mobile menu overlay ====================-->
<div class="mobile-menu-overlay" id="mobile-menu-overlay">
    <div class="mobile-menu-overlay__inner">
        <div class="mobile-menu-overlay__header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-4">
                        <!-- mobile menu content -->
                        <div class="mobile-menu-content">
                            <span class="mobile-navigation-close-icon" id="mobile-menu-close-trigger"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-menu-overlay__body">
            <nav class="offcanvas-navigation">
                <ul>
                    <li class="">
                        <a href="{{route('home')}}">Home</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<!--====================  End of mobile menu overlay  ====================-->
