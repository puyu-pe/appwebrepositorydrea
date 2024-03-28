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
                                {{ 'Lista de evaluaciones' }}
                            </h3>
                            @if ($acronymTypeExam != 'all')
                                <h4 class="it-breadcrumb-title"
                                    style="font-size: 40px"> {{$tTypeExam->nameTypeExam }}</h4>
                            @endif
                        </div>
                        {{-- <div class="it-breadcrumb-list-wrap">
                            <div class="it-breadcrumb-list">
                                <span><a href="index.html">home</a></span>
                                <span class="dvdr">//</span>
                                <span>COURSE 02</span>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="it-course-area it-course-style-2 it-course-style-5 p-relative pt-50 pb-100">
        <div class="container">
            <div class="row">
                <div id="divSearch" class="col-4">
                    <div class="it-sv-details-sidebar-search mb-55">
                        <input id="txtSearch" type="text" placeholder="Información para búsqueda (Enter)"
                               value="{{ $filtersData->searchParameter }}">
                        <button type="submit">
                            <i class="fal fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-8">
                    <input type="hidden" id="hdAcronymExam" value="{{$acronymTypeExam}}">
                    <div class="row">
                        @if ($acronymTypeExam != 'all')
                            <div class="col-3" style="display: none;">
                                <div class="postbox__select">
                                    <select id="slcTypes">
                                        <option value="{{$acronymTypeExam}}" selected>{{ strtoupper($acronymTypeExam)}}</option>
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-3">
                                <div class="postbox__select">
                                    <select id="slcTypes">
                                        <option value="all">Todos los tipos</option>
                                        @foreach ($selectFilters['types'] as $type)
                                        <option value="{{ $type->acronymTypeExam }}"
                                                {{ $filtersData->type == $type->acronymTypeExam ? 'selected' : '' }}>
                                            {{ strtoupper($type->acronymTypeExam)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="col-{{$acronymTypeExam == 'all' ? '3' : '4'}}">
                            <div class="postbox__select">
                                <select id="slcGrades">
                                    <option value="all">Todos los grados</option>
                                    @foreach ($selectFilters['grades'] as $grade)
                                        <option value="{{ $grade->idGrade }}"
                                            {{ $filtersData->grade == $grade->idGrade ? 'selected' : '' }}>
                                            {{ $grade->nameGrade . ' - ' . $grade->numberGrade }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-{{$acronymTypeExam == 'all' ? '3' : '4'}}">
                            <div class="postbox__select">
                                <select id="slcSubjects">
                                    <option value="all">Todos los cursos</option>
                                    @foreach ($selectFilters['subjects'] as $grade)
                                        <option value="{{ $grade->idSubject }}"
                                            {{ $filtersData->subject == $grade->idSubject ? 'selected' : '' }}>
                                            {{ $grade->nameSubject }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-{{$acronymTypeExam == 'all' ? '3' : '4'}}">
                            <div class="postbox__select">
                                <select id="slcYears">
                                    <option value="all">Todos los años</option>
                                    @foreach ($selectFilters['years'] as $year)
                                        <option value="{{ $year->yearExam }}"
                                            {{ $filtersData->year == $year->yearExam ? 'selected' : '' }}>
                                            {{ $year->yearExam }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <table class="table table-responsive">
                    <tr>
                        <th class="align-top">
                            <label class="d-flex align-items-start">
                                <input type="checkbox" id="selectAll" name="SelectAll" class="ml-10"
                                       style="width: 30px; height: 30px;">
                                <i class="fa fa-download ml-0 mt-0 text-success" style="font-size: 27px"
                                   title="SELECCIONAR TODO"></i>
                            </label>
                        </th>
                        <th>Titulo</th>
                        <th>Año</th>
                        <th>Calificación</th>
                        <th>Páginas</th>
                        <th></th>
                    </tr>

                    @if ($listTExam->isEmpty())
                        <tr>
                            <td colspan="6">
                                <center>
                                    <h5 class="mt-10">No se encontraron resultados.</h5>
                                </center>
                            </td>
                        </tr>
                    @endif
                    @foreach ($listTExam as $value)
                        <tr>
                            <td>
                                <input type="checkbox" id="result[]" name="result[]"
                                       value="{{$value->idExam}}" class="mt-10 ml-10"
                                       style="width: 30px; height: 30px;">
                            </td>
                            <td>
                                <h4 class="it-course-title mb-0">
                                    <a href="{{ url('examen/ver/' . $value->codeExam) }}">
                                        {{ $value->nameExam }}
                                    </a>
                                </h4>
                            </td>
                            <td>{{ $value->yearExam }}</td>
                            <td>
                                @include('frontoffice._partials.exam_rating', [
                                    'containerClass' => 'it-course-rating',
                                    'qualifiable' => false,
                                    'idExam' => $value->idExam,
                                    'ratingAvg' => $value->rating->avg,
                                ])
                            </td>
                            <td>
                                {{ $value->totalPageExam == 1 ? $value->totalPageExam . ' páginas' : $value->totalPageExam . ' páginas' }}
                            </td>
                            <td>
                                <a href="{{ url('examen/ver/' . $value->codeExam) }}" class="btn btn-primary">
                                    Ver detalles
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="row">
                <div class="col-4">
                    <input type="hidden" id="downloadUrl" value="{{ route('download.selected') }}">
                    <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
                    <button id="downloadBtn" style="display:none;" class="btn btn-primary btn-success">
                        <i class="fa fa-download"></i>
                        Descargar archivos
                    </button>
                </div>
                <div class="col-8">
                    {!! ViewHelper::renderPaginationFrontExams(
                        'examen/buscar',
                        $quantityPage,
                        $currentPage,
                        $filtersData,
                    ) !!}
                </div>
            </div>
        </div>
    </div>
    <script
        src="{{ asset('assets/frontoffice/viewResources/typeexam/view.js?x=' . env('CACHE_LAST_UPDATE')) }}"></script>
@endsection
