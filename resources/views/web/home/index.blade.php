@extends('web.layouts.app')
@section('content')

<div class="site-wrapper-reveal">
    <!--============ Infotechno Hero Start ============-->
    <div class="processing-hero processing-hero-bg" style="background-image: url('{{ asset('assets/web/assets/images/hero/slider-processing-slide-01-bg.webp') }}');">
        <div class="container">
            <div class="row align-items-center"><!--baseline-->
                <div class="col-lg-8 col-md-7">
                    <div class="processing-hero-text wow move-up">
                        <h6>Doctor Apointment System </h6>
                        <h1 class="font-weight--reguler mb-15"> Easily Book Your Doctor Appointment Online –  <span class="text-color-secondary">Quick, Simple, and Secure!</span></h1>
                        <p>Our Doctor Appointment Online software streamlines the process of booking, managing, and tracking medical appointments. Designed for both patients and healthcare providers, our platform ensures a hassle-free experience, enhancing the efficiency and accessibility of healthcare services.</p>
                        <div class="hero-button mt-30">
                            <div class="hero-popup-video video-popup">
                                <a href="#" class="video-link">
                                    <div class="video-content">
                                        <div class="video-play">
                                            <span class="video-play-icon">
                                                <i class="fa fa-play"></i>
                                            </span>
                                        </div>
                                        <div class="video-text"> How we work</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="processing-hero-images-wrap wow move-up">
                        <div class="processing-hero-images">
                            <img class="img-fluid" src="{{asset('assets/web/assets/images/hero/doctor.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============ Infotechno Hero End ============-->
</div>

@endsection
@section('script')

@endsection
