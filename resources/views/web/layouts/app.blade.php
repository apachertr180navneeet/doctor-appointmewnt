<!DOCTYPE html>
<html class="no-js" lang="zxx" dir="ltr">
    <head>
        <title>Doctor App</title>
        <!-- Favicon -->
        <link rel="icon" href="{{asset('assets/web/assets/images/favicon.webp')}}" />

        <!-- CSS
        ============================================ -->

        <!-- Font Family CSS -->
        <link rel="preconnect" href="https://fonts.googleapis.com/" />
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('assets/web/assets/css/vendor/vendor.min.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/web/assets/css/vendor/vendor.min.css')}}" />

        <!-- Main Style CSS -->
        <link rel="stylesheet" href="{{asset('assets/web/assets/css/style.css')}}" />
    </head>

    <body>
        <div class="preloader-activate preloader-active open_tm_preloader">
            <div class="preloader-area-wrap">
                <div class="spinner d-flex justify-content-center align-items-center h-100">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>
        </div>

        @include('web.layouts.elements.header')

        <div id="main-wrapper">
            @yield('content')
            @include('web.layouts.elements.footer')
        </div>

        <!--====================  scroll top ====================-->
        <a href="#" class="scroll-top" id="scroll-top">
            <i class="arrow-top fas fa-chevron-up"></i>
            <i class="arrow-bottom fas fa-chevron-up"></i>
        </a>
        <!--====================  End of scroll top  ====================-->
        <!-- Start Toolbar -->
        <div class="demo-option-container">
            <!-- Start Toolbar -->
            <div class="aeroland__toolbar">
                <div class="inner">
                    <a class="quick-option hint--bounce hint--left hint--black primary-color-hover-important" href="#" aria-label="Quick Options">
                        <i class="fas fa-project-diagram"></i>
                    </a>
                    <a class="hint--bounce hint--left hint--black primary-color-hover-important" target="_blank" href="https://hasthemes.com/contact-us/" aria-label="Support Center">
                        <i class="far fa-life-ring"></i>
                    </a>
                    <a class="hint--bounce hint--left hint--black primary-color-hover-important" target="_blank" href="https://1.envato.market/c/417168/275988/4415?subId1=hastheme&amp;subId2=mitech-preview&amp;subId3=https%3A%2F%2Fthemeforest.net%2Fcart%2Fconfigure_before_adding%2F24906742%3Flicense%3Dregular%26size%3Dsource&amp;u=https%3A%2F%2Fthemeforest.net%2Fcart%2Fconfigure_before_adding%2F24906742%3Flicense%3Dregular%26size%3Dsource" aria-label="Purchase Mitech">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
            </div>
            <!-- End Toolbar -->
            <!-- Start Quick Link -->
            <div class="demo-option-wrapper">
                <div class="demo-panel-header">
                    <div class="title">
                        <h6 class="heading mt-30">IT Solutions Mitech - Technology, IT Solutions & Services Html5 Template</h6>
                    </div>

                    <div class="panel-btn mt-20">
                        <a class="ht-btn ht-btn-md" href="https://1.envato.market/c/417168/275988/4415?subId1=hastheme&amp;subId2=mitech-preview&amp;subId3=https%3A%2F%2Fthemeforest.net%2Fcart%2Fconfigure_before_adding%2F24906742%3Flicense%3Dregular%26size%3Dsource&amp;u=https%3A%2F%2Fthemeforest.net%2Fcart%2Fconfigure_before_adding%2F24906742%3Flicense%3Dregular%26size%3Dsource"><i class="fa fa-shopping-cart me-2"></i> Buy Now </a>
                    </div>
                </div>
                <div class="demo-quick-option-list">
                    <a class="link hint--bounce hint--black hint--top hint--dark" href="index-appointment.html" aria-label="Appointment">
                        <img class="img-fluid" src="{{asset('assets/web/assets/images/demo-images/home-01.webp')}}" alt="Images">
                    </a>
                    <a class="link hint--bounce hint--black hint--top hint--dark" href="index-infotechno.html" aria-label="Infotechno">
                        <img class="img-fluid" src="{{asset('assets/web/assets/images/demo-images/home-02.webp')}}" alt="Images">
                    </a>
                    <a class="link hint--bounce hint--black hint--top hint--dark" href="index-processing.html" aria-label="Processing">
                        <img class="img-fluid" src="{{asset('assets/web/assets/images/demo-images/home-03.webp')}}" alt="Images">
                    </a>
                    <a class="link hint--bounce hint--black hint--top hint--dark" href="index-services.html" aria-label="Services">
                        <img class="img-fluid" src="{{asset('assets/web/assets/images/demo-images/home-04.webp')}}" alt="Images">
                    </a>
                    <a class="link hint--bounce hint--black hint--top hint--dark" href="index-resolutions.html" aria-label="Resolutions">
                        <img class="img-fluid" src="{{asset('assets/web/assets/images/demo-images/home-05.webp')}}" alt="Images">
                    </a>
                    <a class="link hint--bounce hint--black hint--top hint--dark" href="index-cybersecurity.html" aria-label="Cybersecurity">
                        <img class="img-fluid" src="{{asset('assets/web/assets/images/demo-images/home-06.webp')}}" alt="Images">
                    </a>
                    <a class="link hint--bounce hint--black hint--top hint--dark" href="index-modern-it-company.html" aria-label="Modern IT Company">
                        <img class="img-fluid" src="{{asset('assets/web/assets/images/demo-images/modern-it-company.webp')}}" alt="Images">
                    </a>
                    <a class="link hint--bounce hint--black hint--top hint--dark" href="index-machine-learning.html" aria-label="Machine Learning">
                        <img class="img-fluid" src="{{asset('assets/web/assets/images/demo-images/machine-learning.webp')}}" alt="Images">
                    </a>
                    <a class="link hint--bounce hint--black hint--top hint--dark" href="index-software-innovation.html" aria-label="Software Innovation">
                        <img class="img-fluid" src="{{asset('assets/web/assets/images/demo-images/software-innovation.webp')}}" alt="Images">
                    </a>
                </div>
            </div>
            <!-- End Quick Link -->
        </div>
        <!-- End Toolbar -->
        <!--====================  search overlay ====================-->
        <div class="search-overlay" id="search-overlay">

            <div class="search-overlay__header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-6 ms-auto col-4">
                            <!-- search content -->
                            <div class="search-content text-end">
                                <span class="mobile-navigation-close-icon" id="search-close-trigger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-overlay__inner">
                <div class="search-overlay__body">
                    <div class="search-overlay__form">
                        <form action="#">
                            <input type="text" placeholder="Search">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modernizer JS -->
        <script src="{{asset('assets/web/assets/js/vendor/modernizr-2.8.3.min.js')}}"></script>

        <!-- jQuery JS -->
        <script src="{{asset('assets/web/assets/js/vendor/jquery-3.5.1.min.js')}}"></script>
        <script src="{{asset('assets/web/assets/js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>

        <!-- Bootstrap JS -->
        <script src="{{asset('assets/web/assets/js/vendor/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/web/assets/js/plugins/plugins.min.js')}}"></script>

        <!-- Main JS -->
        <script src="{{asset('assets/web/assets/js/main.js')}}"></script>
    </body>
</html>
