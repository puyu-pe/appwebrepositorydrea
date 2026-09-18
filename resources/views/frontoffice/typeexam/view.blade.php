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
                                    style="font-size: 40px"> {{$tTypeExam->nameTypeExam ?? 'Tipo no válido' }}</h4>
                            @else
                                 <h4 class="it-breadcrumb-title"
                                    style="font-size: 40px">Todos los tipos</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="it-course-area it-course-style-2 it-course-style-5 p-relative pt-50 pb-100">
        <div class="container">
            <div class="row">
                <input type="hidden" id="hdAcronymExam" value="{{$acronymTypeExam}}">
                <div id="divSearch" class="col-md-11">
                    <div class="it-sv-details-sidebar-search mb-55">
                        <input id="txtSearch" type="text" placeholder="Información para búsqueda (Enter)"
                               value="{{ $filtersData->searchParameter }}">
                        <button type="submit">
                            <i class="fal fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-1">
                    <button id="btnSearchType" class="it-btn btn btn-block btn-success">
                        <span>Buscar</span>
                    </button>
                </div>
            </div>
            <div class="row">
                @if ($acronymTypeExam != 'all')
                    <div class="col-md-3" style="display: none;">
                        <div class="postbox__select">
                            <select id="slcTypes">
                                <option value="{{$filtersData->type}}" selected>{{ strtoupper($tTypeExam->acronymTypeExam ?? 'tipo no válido')}}</option>
                            </select>
                        </div>
                    </div>
                @else
                    <div class="col-3">
                        <div class="postbox__select">
                            <select id="slcTypes">
                                <option value="all" {{ $filtersData->type == 'all' ? 'selected' : '' }}>Todos los tipos</option>
                                @foreach ($selectFilters['types'] as $type)
                                <option value="{{ $type->acronymTypeExam }}"
                                        {{ in_array($filtersData->type, [$type->acronymTypeExam, $type->idTypeExam]) ? 'selected' : '' }}>
                                    {{ strtoupper($type->acronymTypeExam)}}</option>
                                @endforeach
                                @if ($filtersData->type != 'all' && $tTypeExam == null)
                                <option value="{{ $filtersData->type }}" selected>Tipo no válido</option>
                                @endif
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col-{{$acronymTypeExam == 'all' ? '3' : '4'}}">
                    <div class="postbox__select">
                        <select id="slcGrades">
                            <option value="all">Todos los grados</option>
                            @foreach ($selectFilters['grades'] as $grade)
                            <option value="{{ $grade->codeGrade ?? $grade->idGrade }}"
                                    {{ $filtersData->grade == ($grade->codeGrade ?? $grade->idGrade) ? 'selected' : '' }}>
                                    {{ $grade->descriptionGrade }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-{{$acronymTypeExam == 'all' ? '3' : '4'}}">
                    <div class="postbox__select">
                        <select id="slcSubjects">
                            <option value="all">Todos los cursos</option>
                            @foreach ($selectFilters['subjects'] as $grade)
                            <option value="{{ $grade->codeSubject ?? $grade->idSubject }}"
                                    {{ $filtersData->subject == ($grade->codeSubject ?? $grade->idSubject) ? 'selected' : '' }}>
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
            <br>
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
                        <th>Tipo de evaluación</th>
                        <th>Curso</th>
                        <th>Grado</th>
                        <th>Año</th>
                        <th>Páginas</th>
                        <th></th>
                    </tr>

                    @if ($listTExam->isEmpty())
                        <tr>
                            <td colspan="8">
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
                            <td>{{ $value->tTypeExam->nameTypeExam ?? '-' }}</td>
                            <td>{{ $value->tSubject->nameSubject ?? '-' }}</td>
                            <td>{{ $value->tGrade->descriptionGrade ?? '-' }}</td>
                            <td>{{ $value->yearExam }}</td>
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
                    <input type="hidden" id="downloadUrl" value="{{ url('download/selected') }}">
                    <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
                    <button id="downloadBtn" style="display:none;" class="btn btn-primary btn-success">
                        <i class="fa fa-download"></i>
                        Descargar archivos
                    </button>
                </div>
                <div class="col-8">
                    {!! ViewHelper::renderPaginationFrontExams(
                        'tipoexamen/'.$acronymTypeExam,
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
