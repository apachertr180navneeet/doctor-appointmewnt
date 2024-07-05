@extends('web.layouts.app')
@section('content')

<div class="site-wrapper-reveal">
    <!--============ Infotechno Hero Start ============-->
    <div class="processing-hero processing-hero-bg" style="background-image: url('{{ asset('assets/web/assets/images/hero/slider-processing-slide-01-bg.webp') }}');">
        <div class="container">
            <div class="row align-items-center"><!--baseline-->
                <div class="col-lg-8 col-md-7">
                    <div class="processing-hero-text wow move-up">
                        <h6>IT Software and design </h6>
                        <h1 class="font-weight--reguler mb-15">Virtual technology in a <span class="text-color-secondary">Refined IT System</span></h1>
                        <p>Set the trends for desktop & server virtualization technology</p>
                        <div class="hero-button mt-30">
                            <a href="#" class="btn btn--secondary">Free Sample</a>
                            <div class="hero-popup-video video-popup">
                                <a href="https://www.youtube.com/watch?v=vqZuSUtczbU" class="video-link">
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
                            <img class="img-fluid" src="{{asset('assets/web/assets/images/hero/slider-processing-slide-01-image-01.webp')}}" alt="">
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
