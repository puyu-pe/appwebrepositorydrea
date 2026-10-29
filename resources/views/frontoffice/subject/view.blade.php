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
                            @if ($codeSubject != 'all')
                                <h4 class="it-breadcrumb-title"
                                    style="font-size: 40px"> {{$tSubject->nameSubject }}</h4>
                            @else
                                <h4 class="it-breadcrumb-title"
                                    style="font-size: 40px">Todos los cursos</h4>
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
                <input type="hidden" id="hdCodeSubject" value="{{$codeSubject}}">
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
                    <button id="btnSearchSubject" class="it-btn btn btn-block btn-success">
                        <span>Buscar</span>
                    </button>
                </div>
            </div>
            <div class="row">
                @if ($codeSubject != 'all')
                    <div class="col-md-3" style="display: none;">
                        <div class="postbox__select">
                            <select id="slcSubjects">
                                <option value="{{$codeSubject}}" selected>{{$codeSubject}}</option>
                            </select>
                        </div>
                    </div>
                @else
                    <div class="col-3">
                        <div class="postbox__select">
                            <select id="slcSubjects">
                                <option value="all">Todos los cursos</option>
                                @foreach ($selectFilters['subjects'] as $subject)
                                    <option value="{{ $subject->codeSubject }}"
                                        {{ $filtersData->subject == $subject->codeSubject ? 'selected' : '' }}>
                                        {{ $subject->nameSubject }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col-{{$codeSubject == 'all' ? '3' : '4'}}">
                    <div class="postbox__select">
                        <select id="slcTypes">
                            <option value="all">Todos los tipos</option>
                            @foreach ($selectFilters['types'] as $type)
                                <option value="{{ $type->idTypeExam }}"
                                    {{ in_array($filtersData->type, [$type->idTypeExam, $type->acronymTypeExam]) ? 'selected' : '' }}>
                                    {{ strtoupper($type->acronymTypeExam)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-{{$codeSubject == 'all' ? '3' : '4'}}">
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
                <div class="col-{{$codeSubject == 'all' ? '3' : '4'}}">
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
                @include('frontoffice.subject._list')
            </div>
        </div>
    </div>
    <script
        src="{{ asset('assets/frontoffice/viewResources/subject/view.js?x=' . env('CACHE_LAST_UPDATE')) }}"></script>
@endsection
