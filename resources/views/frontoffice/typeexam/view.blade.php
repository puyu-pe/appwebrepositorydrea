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
            <div class="row evaluation-search-row">
                <input type="hidden" id="hdAcronymExam" value="{{$acronymTypeExam}}">
                <div id="divSearch" class="col-12 col-md-10 evaluation-search-field">
                    <div class="it-sv-details-sidebar-search">
                        <input id="txtSearch" type="text" placeholder="Información para búsqueda (Enter)"
                               value="{{ $filtersData->searchParameter }}">
                        <button type="submit">
                            <i class="fal fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-2 evaluation-search-action">
                    <button id="btnSearchType" class="it-btn btn btn-block btn-success">
                        <span>Buscar</span>
                    </button>
                </div>
            </div>
            <div class="row evaluation-filter-row">
                @if ($acronymTypeExam != 'all')
                    <div class="col-12 col-md-3 evaluation-filter" style="display: none;">
                        <div class="postbox__select">
                            <select id="slcTypes">
                                <option value="{{$filtersData->type}}" selected>{{ strtoupper($tTypeExam->acronymTypeExam ?? 'tipo no válido')}}</option>
                            </select>
                        </div>
                    </div>
                @else
                    <div class="col-12 col-md-3 evaluation-filter">
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
                <div class="col-12 col-md-{{$acronymTypeExam == 'all' ? '3' : '4'}} evaluation-filter">
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
                <div class="col-12 col-md-{{$acronymTypeExam == 'all' ? '3' : '4'}} evaluation-filter">
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
                <div class="col-12 col-md-{{$acronymTypeExam == 'all' ? '3' : '4'}} evaluation-filter">
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
            <div id="divAjaxExamList">
                @include('frontoffice.typeexam._list')
            </div>
        </div>
    </div>
    <script
        src="{{ asset('assets/frontoffice/viewResources/typeexam/view.js?x=' . env('CACHE_LAST_UPDATE')) }}"></script>
@endsection
