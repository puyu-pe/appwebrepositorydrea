@extends('frontoffice.layout')
@section('generalBody')
    {{ csrf_field() }}

    <div class="it-breadcrumb-area it-breadcrumb-bg"
        data-background="{{ asset('assets/frontoffice/img/breadcrumb/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="it-breadcrumb-content z-index-3 text-center">
                        <div class="it-breadcrumb-title-box">
                            <h3 class="it-breadcrumb-title">{{ $tExam->ttypeexam->nameTypeExam }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="it-course-details-area pt-120 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="it-course-details-wrap">
                        <div class="it-evn-details-thumb mb-35">
                            <img src="{{ asset('assets/frontoffice/img/course/details.jpg') }}" alt="">
                        </div>
                        @include('frontoffice._partials.exam_rating', [
                            'idExam' => $tExam->idExam,
                            'ratingAvg' => $rating->avg,
                        ])
                        <h4 class="it-evn-details-title mb-0 pb-5">{{ $tExam->nameExam }}</h4>
                        <div class="postbox__meta">
                            <span><i class="fa-light fa-file-invoice"></i>{{ $tExam->totalPageExam }} páginas</span>
                            <span><i class="fa-light fa-calendar"></i>{{ $tExam->created_at->format('d-m-Y') }} - F.
                                publicación</span>
                            <span><i class="fa-light fa-star"></i><div class="spanRatingCount">{{ $rating->count }} calificaciónes</div></span>
                        </div>
                        <div class="it-course-details-nav pb-60">
                            <nav>
                                <div class="nav nav-tab" role="tablist">
                                    @foreach (explode('__7SEPARATOR7__', $tExam->keywordExam) as $index => $keywordExam)
                                        <button type="button">{{ $keywordExam }}</button>
                                    @endforeach
                                </div>
                            </nav>
                        </div>
                        <div class="it-course-details-content">
                            <div class="it-evn-details-text mb-40">
                                <h6 class="it-evn-details-title-sm pb-5">Descripción de la evaluación.</h6>
                                <p>{{ $tExam->descriptionExam }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="it-evn-sidebar-box it-course-sidebar-box">
                        <div class="it-evn-sidebar-list mb-20">
                            <ul>
                                <li><span>Nro visitas: </span> <span>{{ $tExam->view_counter }}</span></li>
                                <li><span>Nro descargas: </span> <span>12</span></li>
                                <li><span>Año de evaluación: </span> <span>{{ $tExam->yearExam }}</span></li>
                            </ul>
                        </div>
                        <a class="it-btn w-100 text-center"
                            href="{{ url('examen/verarchivo/' . $tExam->idExam) }}?x={{ $tExam->updated_at }}"
                            target="_blank">
                            <span>
                                Descargar
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
    </div>
@endsection
