@extends('frontoffice.layout')
@section('generalBody')
<!-- hero-area-start -->
<div class="it-hero-3-area it-hero-style-4 it-hero-space theme-bg-3 fix z-index">
    <div class="it-hero-3-shape-1">
        <img src="{{asset('assets/frontoffice/img/hero/hero-4-shape1.png')}}" alt="">
    </div>
    <div class="it-hero-3-shape-2">
        <img src="{{asset('assets/frontoffice/img/hero/hero-3-shape2.png')}}" alt="">
    </div>
    <div class="it-hero-3-shape-3 d-none d-xl-block">
        <img src="{{asset('assets/frontoffice/img/hero/hero-3-shape3.png')}}" alt="">
    </div>
    <div class="it-hero-3-shape-4 d-none d-xl-block">
        <img src="{{asset('assets/frontoffice/img/hero/hero-3-shape4.png')}}" alt="">
    </div>
    <div class="it-hero-3-shape-5 d-none d-xl-block">
        <img src="{{asset('assets/frontoffice/img/hero/hero-3-shape5.png')}}" alt="">
    </div>
    <div class="container">
        <div class="row align-items-center">
        <div class="col-xl-6 col-lg-7">
            <div class="it-hero-3-title-wrap it-hero-3-ptb">
                <div class="it-hero-3-title-box">
                    <h1 class="it-hero-3-title">Bienvenido al repositorio web de <span>Evaluaciones</span></h1>
                    <p>Un sitio que se encargar de gestionar <br>
                    las evaluaciones que las DRE a nivel nacional realizan.</p>
                </div>
                <div class="it-hero-3-btn-box d-flex align-items-center">
                    <a class="it-btn-white" href="course-details.html">
                    <span>
                        Find The Course
                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-5">
            <div class="it-hero-3-thumb text-end">
                <img src="{{asset('assets/frontoffice/img/hero/hero-4-img.png')}}" alt="">
            </div>
        </div>
        </div>
    </div>
</div>
<!-- hero-area-end -->

<!-- category-area-start -->
<div class="it-category-4-area pt-120 pb-90 grey-bg">
    <div class="container">
        <div class="it-category-4-title-wrap mb-60">
        <div class="row align-items-end">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="it-category-4-title-box">
                    <span class="it-section-subtitle-4 d-flex align-items-center">
                    <img src="{{asset('assets/frontoffice/img/category/title.svg')}}" alt="">
                    category
                    </span>
                    <h4 class="it-section-title-3">Favorite topics to learn</h4>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="it-category-4-btn-box text-start text-md-end pt-25">
                    <a class="it-btn-blue" href="course-details.html">
                    Browse Histudy Courses
                    <span>
                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    </a>
                </div>
            </div>
        </div>
        </div>
        <div class="row row-cols-xl-5 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1">
        <div class="col mb-30">
            <div class="it-category-4-item text-center">
                <div class="it-category-4-icon">
                    <span>
                    <img src="{{asset('assets/frontoffice/img/category/category-4-1.png')}}" alt="">
                    </span>
                </div>
                <div class="it-category-4-content">
                    <h4 class="it-category-4-title"><a href="course-details.html">web Design</a></h4>
                    <span>08 Courses</span>
                </div>
            </div>
        </div>
        <div class="col mb-30">
            <div class="it-category-4-item text-center">
                <div class="it-category-4-icon">
                    <span>
                    <img src="{{asset('assets/frontoffice/img/category/category-4-2.png')}}" alt="">
                    </span>
                </div>
                <div class="it-category-4-content">
                    <h4 class="it-category-4-title"><a href="course-details.html">Graphics design</a></h4>
                    <span>15 Courses</span>
                </div>
            </div>
        </div>
        <div class="col mb-30">
            <div class="it-category-4-item text-center">
                <div class="it-category-4-icon">
                    <span>
                    <img src="{{asset('assets/frontoffice/img/category/category-4-3.png')}}" alt="">
                    </span>
                </div>
                <div class="it-category-4-content">
                    <h4 class="it-category-4-title"><a href="course-details.html">Video Editor</a></h4>
                    <span>10 Courses</span>
                </div>
            </div>
        </div>
        <div class="col mb-30">
            <div class="it-category-4-item text-center">
                <div class="it-category-4-icon">
                    <span>
                    <img src="{{asset('assets/frontoffice/img/category/category-4-4.png')}}" alt="">
                    </span>
                </div>
                <div class="it-category-4-content">
                    <h4 class="it-category-4-title"><a href="course-details.html">Content Writing</a></h4>
                    <span>07 Courses</span>
                </div>
            </div>
        </div>
        <div class="col mb-30">
            <div class="it-category-4-item text-center">
                <div class="it-category-4-icon">
                    <span>
                    <img src="{{asset('assets/frontoffice/img/category/category-4-5.png')}}" alt="">
                    </span>
                </div>
                <div class="it-category-4-content">
                    <h4 class="it-category-4-title"><a href="course-details.html">Marketing</a></h4>
                    <span>15 Courses</span>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="container">
        <div class="nav-tabs-custom">
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            @foreach($tTypeExam as $value)
                                <div class="examContainerCard">
                                    <div class="examContainerCardCoverImage">
                                        <img src="{{asset('img/logo/typeexam/'.$value->idTypeExam.'.'.$value->extensionImageType.'?x='.$value->updated_at)}}" height="70" width="70">
                                    </div>
                                    <div class="examContainerCardTitle">
                                        <a href="{{url('tipoexamen/'.$value->acronymTypeExam.'/1')}}">
                                            {{$value->nameTypeExam}}
                                        </a>
                                    </div>
                                    <div class="examContainerCardDescription">
                                        <div style="font-size: 15px;">{{$value->descriptionTypeExam}}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- category-area-end -->

<!-- about-area-start -->
<div class="it-about-4-area it-about-4-style pt-120 pb-120">
    <div class="container">
        <div class="row align-items-center">
        <div class="col-xl-6 col-lg-6">
            <div class="it-about-4-thumb-wrap d-flex align-items-center justify-content-center justify-content-lg-end">
                <div class="it-about-4-thumb-double d-flex flex-column">
                    <img class="mb-20" src="{{asset('assets/frontoffice/img/about/thumb-4-1.jpg')}}" alt="">
                    <img src="{{asset('assets/frontoffice/img/about/thumb-4-2.jpg')}}" alt="">
                </div>
                <div class="it-about-4-thumb-single">
                    <img src="{{asset('assets/frontoffice/img/about/thumb-4-3.jpg')}}" alt="">
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="it-about-3-title-box">
                <span class="it-section-subtitle-4">
                    <img src="{{asset('assets/frontoffice/img/category/title.svg')}}" alt="">
                    about us
                </span>
                <h2 class="it-section-title-3 pb-30">we are always ensure best
                    course for your <span>learning</span>
                </h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                    nostrud exercitation ullamco laboris nisi.</p>
            </div>
            <div class="it-about-3-mv-box">
                <div class="row">
                    <div class="col-xl-12">
                    <div class="it-about-4-list-wrap d-flex align-items-start">
                        <div class="it-about-4-list-icon">
                            <span><i class="flaticon-video-1"></i></span>
                        </div>
                        <div class="it-about-3-mv-item">
                            <span class="it-about-3-mv-title">Sharing a Screen</span>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                    </div>
                    <div class="col-xl-12">
                    <div class="it-about-4-list-wrap d-flex align-items-start">
                        <div class="it-about-4-list-icon">
                            <span><i class="flaticon-puzzle"></i></span>
                        </div>
                        <div class="it-about-3-mv-item">
                            <span class="it-about-3-mv-title">presenter Control</span>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="it-about-3-btn-box p-relative">
                <a class="it-btn-blue" href="contact.html">
                    <span>
                    admission open
                    <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor" stroke-width="1.5"
                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    </span>
                </a>
                <div class="it-about-3-left-shape-3 d-none d-xl-block">
                    <img src="{{asset('assets/frontoffice/img/about/about-3-shap-3.png')}}" alt="">
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- about-area-end -->

<!-- funfact-area-start -->
<div class="it-funfact-4-area theme-bg-3 pt-75 pb-45">
    <div class="container">
        <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-6 mb-30 d-flex justify-content-center">
            <div class="it-funfact-4-wrap d-flex align-items-center justify-content-center">
                <div class="it-funfact-4-item">
                    <h4><span data-purecounter-duration="1" data-purecounter-end="6879" class="purecounter">6,879</span>+</h4>
                    <p>Learners & counting</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-30 d-flex justify-content-center">
            <div class="it-funfact-4-wrap d-flex align-items-center justify-content-center">
                <div class="it-funfact-4-item">
                    <h4><span data-purecounter-duration="1" data-purecounter-end="1327" class="purecounter">1327</span>+</h4>
                    <p>Courses & Video</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-30 d-flex justify-content-center">
            <div class="it-funfact-4-wrap d-flex align-items-center justify-content-center">
                <div class="it-funfact-4-item">
                    <h4><span data-purecounter-duration="1" data-purecounter-end="1359" class="purecounter">1359</span>+</h4>
                    <p>Certified Students</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-30 d-flex justify-content-center">
            <div class="it-funfact-4-wrap d-flex align-items-center justify-content-center">
                <div class="it-funfact-4-item">
                    <h4><span data-purecounter-duration="1" data-purecounter-end="1557" class="purecounter">1557</span>+</h4>
                    <p>Registered Enrolls</p>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- funfact-area-end -->

<!-- course-area-start -->
<div class="it-course-area it-course-style-3 it-course-style-4 it-course-bg p-relative pt-120 pb-90">
    <div class="container">
        <div class="it-course-title-wrap mb-60">
        <div class="row align-items-end">
            <div class="col-xl-7 col-lg-7 col-md-8">
                <div class="it-course-title-box">
                    <span class="it-section-subtitle-4">
                    <img src="{{asset('assets/frontoffice/img/category/title.svg')}}" alt="">
                    Top Popular Course
                    </span>
                    <h4 class="it-section-title-3">Check out educate features <br> win any exam</h4>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-4">
                <div class="it-course-button text-start text-md-end pt-25">
                    <a class="it-btn-blue" href="course-2.html">
                    <span>
                        Load More Course
                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    </a>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
            <div class="it-course-item">
                <div class="it-course-thumb mb-20 p-relative">
                    <a href="course-details.html"><img src="{{asset('assets/frontoffice/img/course/course-1-1.jpg')}}" alt=""></a>
                    <div class="it-course-thumb-text">
                    <span>Development</span>
                    </div>
                </div>
                <div class="it-course-content">
                    <div class="it-course-rating mb-10">
                    <i class="fa-sharp fa-solid fa-star"></i>
                    <i class="fa-sharp fa-solid fa-star"></i>
                    <i class="fa-sharp fa-solid fa-star"></i>
                    <i class="fa-sharp fa-solid fa-star"></i>
                    <i class="fa-sharp fa-regular fa-star"></i>
                    <span>(4.7)</span>
                    </div>
                    <h4 class="it-course-title pb-5"><a href="course-details.html">It statistics data science and Business
                        analysis</a></h4>
                    <div class="it-course-info pb-15 mb-25 d-flex justify-content-between">
                    <span><i class="fa-light fa-file-invoice"></i>Lesson 10</span>
                    <span><i class="fa-sharp fa-regular fa-clock"></i>19h 30m</span>
                    <span><i class="fa-light fa-user"></i>Students 20+</span>
                    </div>
                    <div class="it-course-author pb-15">
                    <img src="{{asset('assets/frontoffice/img/course/avata-1.png')}}" alt="">
                    <span>By <i>Angela</i> in <i>Development</i></span>
                    </div>
                    <div class="it-course-price-box d-flex justify-content-between">
                    <span><i>$60</i> $120</span>
                    <a href="cart.html"><i class="fa-light fa-cart-shopping"></i>Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
            <div class="it-course-item">
                <div class="it-course-thumb mb-20 p-relative">
                    <a href="course-details.html"><img src="{{asset('assets/frontoffice/img/course/course-1-2.jpg')}}" alt=""></a>
                    <div class="it-course-thumb-text">
                    <span>Development</span>
                    </div>
                </div>
                <div class="it-course-content">
                    <div class="it-course-rating mb-10">
                    <i class="fa-sharp fa-solid fa-star"></i>
                    <i class="fa-sharp fa-solid fa-star"></i>
                    <i class="fa-sharp fa-solid fa-star"></i>
                    <i class="fa-sharp fa-solid fa-star"></i>
                    <i class="fa-sharp fa-regular fa-star"></i>
                    <span>(4.7)</span>
                    </div>
                    <h4 class="it-course-title pb-5"><a href="course-details.html">It statistics data science and Business
                        analysis</a></h4>
                    <div class="it-course-info pb-15 mb-25 d-flex justify-content-between">
                    <span><i class="fa-light fa-file-invoice"></i>Lesson 10</span>
                    <span><i class="fa-sharp fa-regular fa-clock"></i>19h 30m</span>
                    <span><i class="fa-light fa-user"></i>Students 20+</span>
                    </div>
                    <div class="it-course-author pb-15">
                    <img src="{{asset('assets/frontoffice/img/course/avata-1.png')}}" alt="">
                    <span>By <i>Angela</i> in <i>Development</i></span>
                    </div>
                    <div class="it-course-price-box d-flex justify-content-between">
                    <span><i>$60</i> $120</span>
                    <a href="cart.html"><i class="fa-light fa-cart-shopping"></i>Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
            <div class="it-course-item">
                <div class="it-course-thumb mb-20 p-relative">
                    <a href="course-details.html"><img src="{{asset('assets/frontoffice/img/course/course-1-3.jpg')}}" alt=""></a>
                    <div class="it-course-thumb-text">
                    <span>Development</span>
                    </div>
                </div>
                <div class="it-course-content">
                    <div class="it-course-rating mb-10">
                    <i class="fa-sharp fa-solid fa-star"></i>
                    <i class="fa-sharp fa-solid fa-star"></i>
                    <i class="fa-sharp fa-solid fa-star"></i>
                    <i class="fa-sharp fa-solid fa-star"></i>
                    <i class="fa-sharp fa-regular fa-star"></i>
                    <span>(4.7)</span>
                    </div>
                    <h4 class="it-course-title pb-5"><a href="course-details.html">Bilginer Adobe Illustrator for
                        Graphic Design</a></h4>
                    <div class="it-course-info pb-15 mb-25 d-flex justify-content-between">
                    <span><i class="fa-light fa-file-invoice"></i>Lesson 10</span>
                    <span><i class="fa-sharp fa-regular fa-clock"></i>19h 30m</span>
                    <span><i class="fa-light fa-user"></i>Students 20+</span>
                    </div>
                    <div class="it-course-author pb-15">
                    <img src="{{asset('assets/frontoffice/img/course/avata-1.png')}}" alt="">
                    <span>By <i>Angela</i> in <i>Development</i></span>
                    </div>
                    <div class="it-course-price-box d-flex justify-content-between">
                    <span><i>$60</i> $120</span>
                    <a href="cart.html"><i class="fa-light fa-cart-shopping"></i>Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- course-area-end -->

<!-- video-area-start -->
<div class="it-video-area it-video-style-4 it-video-bg p-relative fix pt-100 pb-95"
    data-background="{{asset('assets/frontoffice/img/video/bg-4-1.jpg')}}">
    <div class="it-video-shape-1 d-none d-lg-block">
        <img src="{{asset('assets/frontoffice/img/video/shape-4-1.png')}}" alt="">
    </div>
    <div class="it-video-shape-2 d-none d-lg-block">
        <img src="{{asset('assets/frontoffice/img/video/shape-1-2.png')}}" alt="">
    </div>
    <div class="it-video-shape-3 d-none d-xl-block">
        <img src="{{asset('assets/frontoffice/img/video/shape-1-4.png')}}" alt="">
    </div>
    <div class="it-video-shape-5 d-none d-lg-block">
        <img src="{{asset('assets/frontoffice/img/video/shape-1-5.png')}}" alt="">
    </div>
    <div class="container">
        <div class="row align-items-center">
        <div class="col-xl-7 col-lg-7 col-md-9 col-sm-9">
            <div class="it-video-content">
                <span>are you ready for this offer</span>
                <h3 class="it-video-title">40% offer for very first 100</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                    nostrud exercitation ullamco laboris nisi.</p>
                <div class="it-video-button">
                    <a class="it-btn-blue" href="contact.html">
                    <span>
                        Join With us
                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-5 col-md-3 col-sm-3">
            <div
                class="it-video-play-wrap d-flex justify-content-start justify-content-md-end align-items-center">
                <div class="it-video-play text-center">
                    <a class="popup-video play" href="https://www.youtube.com/watch?v=PO_fBTkoznc"><i
                        class="fas fa-play"></i></a>
                    <a class="text" href="#">watch now</a>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- video-area-end -->

<!-- work-area-start -->
<div class="it-wrok-area it-wrok-bg pt-120 pb-90" data-background="{{asset('assets/frontoffice/img/work/work-bg.jpg')}}">
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-xl-6">
            <div class="it-course-title-box mb-60 text-center">
                <span class="it-section-subtitle-4">
                    <img src="{{asset('assets/frontoffice/img/category/title.svg')}}" alt="">
                    working strategy
                </span>
                <h4 class="it-section-title-3">our work process</h4>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
            <div class="it-work-item text-center">
                <div class="it-work-icon">
                    <span>
                    <img src="{{asset('assets/frontoffice/img/work/work-1.svg')}}" alt="">
                    </span>
                </div>
                <div class="it-work-content">
                    <h4 class="it-work-title-sm"><a href="service-details.html">start course</a></h4>
                    <p>Duis aute irure dolor reprehenderit
                    in voluptate velit esse cillum dolore
                    fugiat nulla pariatur. Excepteur</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
            <div class="it-work-item active text-center">
                <div class="it-work-icon">
                    <span>
                    <img src="{{asset('assets/frontoffice/img/work/work-1.svg')}}" alt="">
                    </span>
                </div>
                <div class="it-work-content">
                    <h4 class="it-work-title-sm"><a href="service-details.html">Make Decision</a></h4>
                    <p>Duis aute irure dolor reprehenderit
                    in voluptate velit esse cillum dolore
                    fugiat nulla pariatur. Excepteur</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
            <div class="it-work-item text-center">
                <div class="it-work-icon">
                    <span>
                    <img src="{{asset('assets/frontoffice/img/work/work-1.svg')}}" alt="">
                    </span>
                </div>
                <div class="it-work-content">
                    <h4 class="it-work-title-sm"><a href="service-details.html">Get a Certificate</a></h4>
                    <p>Duis aute irure dolor reprehenderit
                    in voluptate velit esse cillum dolore
                    fugiat nulla pariatur. Excepteur</p>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- work-area-end -->
<!-- testimonial-area-start -->
<div class="it-testimonial-3-area it-testimonial-4-style theme-bg-3">
    <div class="container">
        <div class="row align-items-center">
        <div class="col-xl-5 col-lg-4 d-none d-lg-block">
            <div class="it-testimonial-3-thumb">
                <img src="{{asset('assets/frontoffice/img/testimonial/thumb-2.png')}}" alt="">
            </div>
        </div>
        <div class="col-xl-7 col-lg-8">
            <div class="it-testimonial-3-box z-index p-relative">
                <div class="it-testimonial-3-shape-1">
                    <img src="{{asset('assets/frontoffice/img/testimonial/shape-3-1.png')}}" alt="">
                </div>
                <div class="it-testimonial-3-wrapper white-bg p-relative">
                    <div class="it-testimonial-3-quote">
                    <img src="{{asset('assets/frontoffice/img/testimonial/quot.png')}}" alt="">
                    </div>
                    <div class="swiper-container it-testimonial-3-active">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="it-testimonial-3-item">
                                <div class="it-testimonial-3-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                    veniam, quis nostrud exercitation ullamco laboris nisi ut aliquipLorem
                                    ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <div class="it-testimonial-3-author-box d-flex align-items-center">
                                    <div class="it-testimonial-3-avata">
                                        <img src="{{asset('assets/frontoffice/img/avatar/avatar-3-1.png')}}" alt="">
                                    </div>
                                    <div class="it-testimonial-3-author-info">
                                        <h5>Jorge Carter</h5>
                                        <span>Software Developer</span>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="it-testimonial-3-item">
                                <div class="it-testimonial-3-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                    veniam, quis nostrud exercitation ullamco laboris nisi ut aliquipLorem
                                    ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <div class="it-testimonial-3-author-box d-flex align-items-center">
                                    <div class="it-testimonial-3-avata">
                                        <img src="{{asset('assets/frontoffice/img/avatar/avatar-2.png')}}" alt="">
                                    </div>
                                    <div class="it-testimonial-3-author-info">
                                        <h5>Jorge Carter</h5>
                                        <span>Gloria Burnett</span>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="it-testimonial-3-item">
                                <div class="it-testimonial-3-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                    veniam, quis nostrud exercitation ullamco laboris nisi ut aliquipLorem
                                    ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <div class="it-testimonial-3-author-box d-flex align-items-center">
                                    <div class="it-testimonial-3-avata">
                                        <img src="{{asset('assets/frontoffice/img/avatar/avatar-1.png')}}" alt="">
                                    </div>
                                    <div class="it-testimonial-3-author-info">
                                        <h5>Laurie Duncanr</h5>
                                        <span>Software Developer</span>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="test-slider-dots"></div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- testimonial-area-end -->

<!-- contact-area-start -->
<div class="it-contact-area it-contact-style-4 p-relative pt-120 pb-100">
    <div class="it-contact-shape-1 d-none d-lg-block">
        <img src="{{asset('assets/frontoffice/img/contact/shape-1-1.png')}}" alt="">
    </div>
    <div class="it-contact-shape-2 d-none d-lg-block">
        <img src="{{asset('assets/frontoffice/img/contact/shape-1-2.png')}}" alt="">
    </div>
    <div class="it-contact-shape-3 d-none d-xxl-block">
        <img src="{{asset('assets/frontoffice/img/contact/shape-1-3.png')}}" alt="">
    </div>
    <div class="it-contact-shape-4 d-none d-lg-block">
        <img src="{{asset('assets/frontoffice/img/contact/shape-1-4.png')}}" alt="">
    </div>
    <div class="container">
        <div class="row align-items-center">
        <div class="col-xl-7 col-lg-7">
            <div class="it-contact-left">
                <div class="it-contact-title-box pb-20">
                    <span class="it-section-subtitle-4">
                    <img src="{{asset('assets/frontoffice/img/category/title.svg')}}" alt="">
                    Contact With US
                    </span>
                    <h2 class="it-section-title-3">Register Now Get Premium
                    Online Admison</h2>
                </div>
                <div class="it-contact-text pb-15">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                </div>
                <div class="it-contact-timer-box" data-countdown data-date="June 10 2024 20:20:2">
                    <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-20">
                        <div class="it-contact-timer text-center">
                            <h6 data-days>00</h6>
                            <i>DAYS</i>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-20">
                        <div class="it-contact-timer text-center">
                            <h6 data-hours>00</h6>
                            <i>HOURS</i>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-20">
                        <div class="it-contact-timer text-center">
                            <h6 data-minutes>00</h6>
                            <i>MINUTES</i>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-20">
                        <div class="it-contact-timer text-center">
                            <h6 data-seconds>00</h6>
                            <i>SECONDS</i>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-5">
            <div class="it-contact-wrap" data-background="{{asset('assets/frontoffice/img/contact/bg-5.jpg')}}">
                <h4 class="it-contact-title pb-15">Sign Up for Free
                    Resources</h4>
                <form action="#">
                    <div class="row">
                    <div class="col-12 mb-15">
                        <div class="it-contact-input-box">
                            <input type="text" placeholder="Your Name">
                        </div>
                    </div>
                    <div class="col-12 mb-15">
                        <div class="it-contact-input-box">
                            <input type="email" placeholder="Your Email">
                        </div>
                    </div>
                    <div class="col-12 mb-15">
                        <div class="it-contact-input-box">
                            <input type="text" placeholder="Phone">
                        </div>
                    </div>
                    <div class="col-12 mb-30">
                        <div class="it-contact-textarea-box">
                            <textarea placeholder="Message"></textarea>
                        </div>
                    </div>
                    </div>
                </form>
                <button type="submit" class="it-btn-blue">
                    <span>
                    submit now
                    <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    </span>
                </button>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- contact-area-end -->
@endsection
