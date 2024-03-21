@extends('frontoffice.layout')
@section('generalBody')
    <div class="it-breadcrumb-area it-breadcrumb-bg"
        data-background="{{ asset('assets/frontoffice/img/breadcrumb/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="it-breadcrumb-content z-index-3 text-center">
                        <div class="it-breadcrumb-title-box">
                            <h3 class="it-breadcrumb-title">
                                {{ 'Lista de evaluaciones ' . strtoupper($tTypeExam->acronymTypeExam) }}
                            </h3>
                        </div>
                        <div class="it-breadcrumb-list-wrap">
                            <div class="it-breadcrumb-list">
                                <span><a href="index.html">home</a></span>
                                <span class="dvdr">//</span>
                                <span>COURSE 02</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="it-course-area it-course-style-2 it-course-style-5 p-relative pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div id="divSearch" class="col-4">
                    <div class="it-sv-details-sidebar">
                        <div class="it-sv-details-sidebar-search mb-55">
                            <input id="txtSearch" type="text" placeholder="Información para búsqueda (Enter)"
                                onkeyup="searchTypeExam(this.value, '{{ url('tipoexamen/' . $tTypeExam->acronymTypeExam . '/1') }}', event);"
                                value="{{ $searchParameter }}">
                            <button type="submit">
                                <i class="fal fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                </div>
            </div>
            <div class="row">
                @foreach ($listTExam as $value)
                    <div class="col-xl-6 col-lg-6 mb-30">
                        <div class="it-course-2-wrap d-flex align-items-center">
                            <div class="it-course-thumb  p-relative">
                                <a href="{{ url('examen/verarchivo/' . $value->idExam) }}?x={{ $value->updated_at }}"
                                    target="_blank"><img src="{{ asset('assets/frontoffice/img/course/course-1-4.jpg') }}"
                                        alt=""></a>
                                <div class="it-course-thumb-text">
                                    <span>Marketing</span>
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
                                <h4 class="it-course-title pb-15"><a href="{{ url('examen/ver/' . $value->codeExam) }}">{{ $value->nameExam }}</a>
                                </h4>
                                <div class="it-course-info pb-20 mb-25 d-flex justify-content-between">
                                    <span><i
                                            class="fa-light fa-file-invoice"></i>{{ $value->totalPageExam == 1 ? $value->totalPageExam . ' páginas' : $value->totalPageExam . ' páginas' }}</span>
                                    <span><i class="fa-sharp fa-regular fa-calendar"></i>{{ $value->yearExam }}</span>
                                    <span><i class="fa-light fa-user"></i>Students 20+</span>
                                </div>
                                <div class="it-course-author pb-25">
                                    <span>By <i>Angela</i> in <i>Development</i></span>
                                </div>
                                <div class="it-course-price-box d-flex justify-content-between">
                                    {{-- <span><i>$60</i> $120</span>
                                <a href="cart.html"><i class="fa-light fa-cart-shopping"></i>Add to cart</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-12">
                    {!! ViewHelper::renderPagination(
                        'tipoexamen/' . $tTypeExam->acronymTypeExam,
                        $quantityPage,
                        $currentPage,
                        $searchParameter,
                    ) !!}
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/frontoffice/viewResources/typeexam/view.js?x=' . env('CACHE_LAST_UPDATE')) }}"></script>
@endsection
