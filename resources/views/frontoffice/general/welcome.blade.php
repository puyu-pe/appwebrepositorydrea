@extends('frontoffice.layout')
@section('generalBody')
    <!-- hero-area-start -->
    <div class="it-hero-3-area it-hero-style-4 it-hero-space theme-bg-3 fix z-index">
        <div class="it-hero-3-shape-1">
            <img src="{{ asset('assets/frontoffice/img/hero/hero-4-shape1.png') }}" alt="">
        </div>
        <div class="it-hero-3-shape-2">
            <img src="{{ asset('assets/frontoffice/img/hero/hero-3-shape2.png') }}" alt="">
        </div>
        <div class="it-hero-3-shape-3 d-none d-xl-block">
            <img src="{{ asset('assets/frontoffice/img/hero/hero-3-shape3.png') }}" alt="">
        </div>
        <div class="it-hero-3-shape-4 d-none d-xl-block">
            <img src="{{ asset('assets/frontoffice/img/hero/hero-3-shape4.png') }}" alt="">
        </div>
        <div class="it-hero-3-shape-5 d-none d-xl-block">
            <img src="{{ asset('assets/frontoffice/img/hero/hero-3-shape5.png') }}" alt="">
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-7">
                    <div class="it-hero-3-title-wrap it-hero-3-ptb">
                        <div class="it-hero-3-title-box">
                            <h1 class="it-hero-3-title">Bienvenido al repositorio web de <span>Evaluaciones</span></h1>
                            <p>Un sitio que se encargar de gestionar <br>
                                las evaluaciones que las DRE realiza a nivel nacional.</p>
                        </div>
                        <div class="it-hero-3-btn-box d-flex align-items-center">
                            <a class="it-btn-white" href="course-details.html">
                                <span>
                                    Buscar Evaluación
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
                <div class="col-xl-6 col-lg-5">
                    <div class="it-hero-3-thumb text-end">
                        <img src="{{ asset('assets/frontoffice/img/hero/hero-estudiantes.png') }}" alt="">
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
                                <img src="{{ asset('assets/frontoffice/img/category/title.svg') }}" alt="">
                                Tipos
                            </span>
                            <h4 class="it-section-title-3">Tipos de evaluaciones</h4>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="it-category-4-btn-box text-start text-md-end pt-25">
                            <a class="it-btn-blue" href="course-details.html">
                                Buscar evaluación
                                <span>
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
            </div>

            <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1">
                @foreach ($tTypeExam as $value)
                    <div class="col mb-30">
                        <a href="{{ url('tipoexamen/' . $value->acronymTypeExam . '/1') }}">
                            <div class="it-category-4-item text-center">
                                <div class="it-category-4-icon">
                                    <span>
                                        <img src="{{ asset("assets/frontoffice/img/category/{$value->acronymTypeExam}-img.{$value->extensionImageType}?x={$value->updated_at}") }}"
                                            alt="">
                                    </span>
                                </div>
                                <div class="it-category-4-content">
                                    <h4 class="it-category-4-title">
                                        <a href="{{ url('tipoexamen/' . $value->acronymTypeExam . '/1') }}">
                                            {{ $value->nameTypeExam }}</a>
                                    </h4>
                                    <span>{{ $value->acronymTypeExam }}</span>
                                    <p>{{ substr($value->descriptionTypeExam, 0, 90) }} ...</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- category-area-end -->

        <!-- about-area-start -->
        <div class="it-about-4-area it-about-4-style white-bg pt-120 pb-120">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6">
                        <div
                            class="it-about-4-thumb-wrap d-flex align-items-center justify-content-center justify-content-lg-end">
                            <div class="it-about-4-thumb-double d-flex flex-column">
                                <img class="mb-20" src="{{ asset('assets/frontoffice/img/about/thumb-4-1.jpg') }}"
                                    alt="">
                                <img src="{{ asset('assets/frontoffice/img/about/thumb-4-2.jpg') }}" alt="">
                            </div>
                            <div class="it-about-4-thumb-single">
                                <img src="{{ asset('assets/frontoffice/img/about/thumb-4-3.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="it-about-3-title-box">
                            <span class="it-section-subtitle-4">
                                <img src="{{ asset('assets/frontoffice/img/category/title.svg') }}" alt="">
                                Sobre nosotros
                            </span>
                            <h2 class="it-section-title-3 pb-30">Bienvenido al repositorio de evaluaciones
                                <span>DREA</span>
                            </h2>
                            <p>
                                En la DREA, nos comprometemos a proporcionar las evaluaciones y recursos educativos útiles
                                y accesibles para estudiantes y docentes para que los estudiantes puedan practicar y
                                prepararse de manera efectiva para futuras evaluaciones.
                            </p>
                            <div class="it-about-3-mv-box">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="it-about-4-list-wrap d-flex align-items-start">
                                            <div class="it-about-4-list-icon">
                                                <span><i class="flaticon-share"></i></span>
                                            </div>
                                            <div class="it-about-3-mv-item">
                                                <span class="it-about-3-mv-title">Accesibilidad</span>
                                                <p> Nos esforzamos por garantizar que nuestros recursos sean accesibles
                                                    para
                                                    todos, sin importar su ubicación geográfica o momento</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="it-about-4-list-wrap d-flex align-items-start">
                                            <div class="it-about-4-list-icon">
                                                <span><i class="flaticon-study"></i></span>
                                            </div>
                                            <div class="it-about-3-mv-item">
                                                <span class="it-about-3-mv-title">Apoyo</span>
                                                <p>Estamos para apoyar a los estudiantes y docentes en su viaje
                                                    educativo,
                                                    brindando recursos y orientación en linea</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="it-about-3-btn-box p-relative">
                                <a class="it-btn-blue" href="contact.html">
                                    <span>
                                        Conocer mas
                                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor"
                                                stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </a>
                                <div class="it-about-3-left-shape-3 d-none d-xl-block">
                                    <img src="{{ asset('assets/frontoffice/img/about/about-3-shap-3.png') }}"
                                        alt="">
                                </div>
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
                                <h4><span data-purecounter-duration="1" data-purecounter-end="6879"
                                        class="purecounter">6,879</span>+</h4>
                                <p>Recursos ECE</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 mb-30 d-flex justify-content-center">
                        <div class="it-funfact-4-wrap d-flex align-items-center justify-content-center">
                            <div class="it-funfact-4-item">
                                <h4><span data-purecounter-duration="1" data-purecounter-end="1327"
                                        class="purecounter">1327</span>+</h4>
                                <p>Recursos ERA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 mb-30 d-flex justify-content-center">
                        <div class="it-funfact-4-wrap d-flex align-items-center justify-content-center">
                            <div class="it-funfact-4-item">
                                <h4><span data-purecounter-duration="1" data-purecounter-end="1359"
                                        class="purecounter">1359</span>+</h4>
                                <p>Recursos LLECE</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 mb-30 d-flex justify-content-center">
                        <div class="it-funfact-4-wrap d-flex align-items-center justify-content-center">
                            <div class="it-funfact-4-item">
                                <h4><span data-purecounter-duration="1" data-purecounter-end="1557"
                                        class="purecounter">1557</span>+</h4>
                                <p>Recursos EM</p>
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
                                    <img src="{{ asset('assets/frontoffice/img/category/title.svg') }}" alt="">
                                    Evaluaciones mas vistas
                                </span>
                                <h4 class="it-section-title-3">Las evaluaciones que han sido <br> mas revisadas</h4>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-4">
                            <div class="it-course-button text-start text-md-end pt-25">
                                <a class="it-btn-blue" href="course-2.html">
                                    <span>
                                        Ver mas evaluaciones
                                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor"
                                                stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($topExams as $topExam)
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                            <div class="it-course-item">
                                <div class="it-course-thumb mb-20 p-relative">
                                    <a href="course-details.html"><img
                                            src="{{ asset('assets/frontoffice/img/course/course-1-1.jpg') }}"
                                            alt=""></a>
                                    <div class="it-course-thumb-text">
                                        <span>{{ $topExam->tTypeExam->acronymTypeExam }}</span>
                                    </div>
                                </div>
                                <div class="it-course-content">
                                    {{-- TODO  llenar datos ESTRELLAS, PAGINAS, RESPUESTAS, (DIRECCION == NULL ??)  --}}
                                    <div class="it-course-rating mb-10">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                        <i class="fa-sharp fa-regular fa-star"></i>
                                        <span>(4.7)</span>
                                    </div>
                                    <h4 class="it-course-title pb-5">
                                        <a href="course-details.html">{{ $topExam->nameExam }}</a>
                                    </h4>
                                    <div class="it-course-info pb-15 mb-25 d-flex justify-content-between">
                                        <span><i class="fa-light fa-file-invoice"></i>Paginas 10</span>
                                        <span><i
                                                class="fa-sharp fa-regular fa-calendar"></i>{{ $topExam->created_at->format('d-m-Y') }}</span>
                                        <span><i class="fa-light fa-user"></i>Respuestas 5</span>
                                    </div>
                                    <div class="it-course-author pb-15">
                                        <img src="{{ asset('assets/frontoffice/img/course/avata-1.png') }}"
                                            alt="">
                                        <span>Subido por
                                            <i>{{ $topExam->tUser !== null ? $topExam->tUser->firstName : 'NO USER' }}</i> -
                                            <i>{{ $topExam->tDirection !== null ? $topExam->tDirection->nameRegion : 'N.R' }}</i></span>
                                    </div>
                                    <div class="it-course-price-box d-flex justify-content-between">
                                        <span><i>{{ $topExam->view_counter }}</i></span>
                                        <a href="cart.html"><i class="fa-light fa-eye"></i>Cantidad de vistas</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- course-area-end -->

        <!-- video-area-start -->
        <div class="it-video-area it-video-style-4 it-video-bg p-relative fix pt-100 pb-95"
            data-background="{{ asset('assets/frontoffice/img/video/bg-4-1.jpg') }}">
            <div class="it-video-shape-1 d-none d-lg-block">
                <img src="{{ asset('assets/frontoffice/img/video/shape-4-1.png') }}" alt="">
            </div>
            <div class="it-video-shape-2 d-none d-lg-block">
                <img src="{{ asset('assets/frontoffice/img/video/shape-1-2.png') }}" alt="">
            </div>
            <div class="it-video-shape-3 d-none d-xl-block">
                <img src="{{ asset('assets/frontoffice/img/video/shape-1-4.png') }}" alt="">
            </div>
            <div class="it-video-shape-5 d-none d-lg-block">
                <img src="{{ asset('assets/frontoffice/img/video/shape-1-5.png') }}" alt="">
            </div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-7 col-md-9 col-sm-9">
                        <div class="it-video-content">
                            <span>Mantente al dia con el repositorio</span>
                            <h3 class="it-video-title">Suscríbete para Recibir Notificaciones</h3>
                            <p>¡Mantente al tanto de las últimas evaluaciones subidas y respondidas en nuestro repositorio!
                            </p>
                            <p>Suscríbete a nuestras notificaciones y recibe actualizaciones directamente en tu bandeja de
                                entrada</p>
                            <div class="it-video-button">
                                <a class="it-btn-blue" href="contact.html">
                                    <span>
                                        Suscríbirse
                                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor"
                                                stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                stroke-linejoin="round" />
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
                                <a class="text" href="#">Tutorial</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- video-area-end -->

        <!-- work-area-start -->
        <div class="it-wrok-area it-wrok-bg pt-120 pb-90"
            data-background="{{ asset('assets/frontoffice/img/work/work-bg.jpg') }}">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="it-course-title-box mb-60 text-center">
                            <span class="it-section-subtitle-4">
                                <img src="{{ asset('assets/frontoffice/img/category/title.svg') }}" alt="">
                                beneficios
                            </span>
                            <h4 class="it-section-title-3">Podrás encontrar</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="it-work-item text-center">
                            <div class="it-work-icon">
                                <span>
                                    <img src="{{ asset('assets/frontoffice/img/work/work-1.svg') }}" alt="">
                                </span>
                            </div>
                            <div class="it-work-content">
                                <h4 class="it-work-title-sm"><a href="service-details.html">Contenido organizado</a></h4>
                                <p>Acceder de manera organizada, a la amplia gama de evaluaciones, con la posibilidad de
                                    filtrar y buscar según sus necesidades</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="it-work-item active text-center">
                            <div class="it-work-icon">
                                <span>
                                    <img src="{{ asset('assets/frontoffice/img/work/work-1.svg') }}" alt="">
                                </span>
                            </div>
                            <div class="it-work-content">
                                <h4 class="it-work-title-sm"><a href="service-details.html">Respuestas de Evaluaciones</a>
                                </h4>
                                <p>Los usuarios pueden registrar sus respuestas a las evaluaciones y hacer públicas las
                                    respuestas para compartir y mejorar</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="it-work-item text-center">
                            <div class="it-work-icon">
                                <span>
                                    <img src="{{ asset('assets/frontoffice/img/work/work-1.svg') }}" alt="">
                                </span>
                            </div>
                            <div class="it-work-content">
                                <h4 class="it-work-title-sm"><a href="service-details.html">Interacción y Colaboración</a>
                                </h4>
                                <p>Comentar las respuestas y compartir estrategias de resolución permitiendo
                                    retroalimentación constructiva</p>
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
                            <img src="{{ asset('assets/frontoffice/img/testimonial/thumb-2.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-8">
                        <div class="it-testimonial-3-box z-index p-relative">
                            <div class="it-testimonial-3-shape-1">
                                <img src="{{ asset('assets/frontoffice/img/testimonial/shape-3-1.png') }}"
                                    alt="">
                            </div>
                            <div class="it-testimonial-3-wrapper white-bg p-relative">
                                <div class="it-testimonial-3-quote">
                                    <img src="{{ asset('assets/frontoffice/img/testimonial/quot.png') }}" alt="">
                                </div>
                                <div class="swiper-container it-testimonial-3-active">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="it-testimonial-3-item">
                                                <div class="it-testimonial-3-content">
                                                    <p>¡Estoy realmente impresionada con el servicio que ofrece este sitio
                                                        web!
                                                        Como estudiante de secundaria, siempre he luchado con la preparación
                                                        para las evaluaciones,
                                                        pero este repositorio de evaluaciones ha hecho que sea mucho más
                                                        fácil para mí practicar y mejorar.
                                                        La función de registro de respuestas me ha ayudado a identificar mis
                                                        fortalezas y debilidades.</p>
                                                    <div class="it-testimonial-3-author-box d-flex align-items-center">
                                                        <div class="it-testimonial-3-avata">
                                                            <img src="{{ asset('assets/frontoffice/img/avatar/avatar-3-1.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="it-testimonial-3-author-info">
                                                            <h5>Ana García</h5>
                                                            <span>Estudiante. Lima, Perú</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="it-testimonial-3-item">
                                                <div class="it-testimonial-3-content">
                                                    <p>Como docente de matemáticas, siempre estoy buscando maneras de apoyar
                                                        a mis estudiantes en su preparación
                                                        para las evaluaciones. Este repositorio de evaluaciones ha sido una
                                                        herramienta invaluable en mi clase.
                                                        La variedad de evaluaciones disponibles y la capacidad de
                                                        personalizar las preferencias de los estudiantes
                                                        han hecho que sea mucho más fácil para ellos practicar y mejorar sus
                                                        habilidades.</p>
                                                    <div class="it-testimonial-3-author-box d-flex align-items-center">
                                                        <div class="it-testimonial-3-avata">
                                                            <img src="{{ asset('assets/frontoffice/img/avatar/avatar-2.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="it-testimonial-3-author-info">
                                                            <h5>José Martínez</h5>
                                                            <span>Docente. Arequipa, Perú</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="it-testimonial-3-item">
                                                <div class="it-testimonial-3-content">
                                                    <p>Siempre estoy buscando formas de mejorar mi rendimiento académico.
                                                        Este repositorio de evaluaciones ha sido una verdadera bendición
                                                        para mí. La interfaz fácil de usar
                                                        y la amplia selección de evaluaciones disponibles han hecho que sea
                                                        mucho más fácil para mí practicar
                                                        y prepararme para mis exámenes. Además, la posibilidad de
                                                        interactuar con otros estudiantes y ver sus
                                                        respuestas me ha ayudado a aprender de diferentes enfoques y
                                                        estrategias de resolución</p>
                                                    <div class="it-testimonial-3-author-box d-flex align-items-center">
                                                        <div class="it-testimonial-3-avata">
                                                            <img src="{{ asset('assets/frontoffice/img/avatar/avatar-1.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="it-testimonial-3-author-info">
                                                            <h5>Diego Flores</h5>
                                                            <span>Estudiante. Trujillo, Perú</span>
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
                <img src="{{ asset('assets/frontoffice/img/contact/shape-1-1.png') }}" alt="">
            </div>
            <div class="it-contact-shape-2 d-none d-lg-block">
                <img src="{{ asset('assets/frontoffice/img/contact/shape-1-2.png') }}" alt="">
            </div>
            <div class="it-contact-shape-3 d-none d-xxl-block">
                <img src="{{ asset('assets/frontoffice/img/contact/shape-1-3.png') }}" alt="">
            </div>
            <div class="it-contact-shape-4 d-none d-lg-block">
                <img src="{{ asset('assets/frontoffice/img/contact/shape-1-4.png') }}" alt="">
            </div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-7">
                        <div class="it-contact-left">
                            <div class="it-contact-title-box pb-20">
                                <span class="it-section-subtitle-4">
                                    <img src="{{ asset('assets/frontoffice/img/category/title.svg') }}" alt="">
                                    Contact With US
                                </span>
                                <h2 class="it-section-title-3">Registra tus datos para generar tu solicitud de inscripción
                                </h2>
                            </div>
                            <div class="it-contact-text pb-15">
                                <p>La inscripción en la web es sencillo, completa el formulario con tus datos personales y
                                    de contacto,
                                    indicando si es docente o estudiante, Una vez aprobado serás notificado por correo.
                                    Los usuarios obtienen acceso para registrar respuestas y participar en la comunidad
                                    educativa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="it-contact-wrap"
                            data-background="{{ asset('assets/frontoffice/img/contact/bg-5.jpg') }}">
                            <h4 class="it-contact-title pb-15">Registrate enviando tus datos</h4>
                            <form action="#">
                                <div class="row">
                                    <div class="col-12 mb-15">
                                        <div class="it-contact-input-box">
                                            <input type="text" placeholder="Nombre">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-15">
                                        <div class="it-contact-input-box">
                                            <input type="email" placeholder="Correo">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-15">
                                        <div class="it-contact-input-box">
                                            <input type="text" placeholder="Teléfono">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-30">
                                        <div class="it-contact-textarea-box">
                                            <textarea placeholder="Mensaje"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <button type="submit" class="it-btn-blue">
                                <span>
                                    Enviar datos
                                    <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor"
                                            stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
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
