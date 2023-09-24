@extends('dashboard.layout')
@section('title', 'Registrar un nuevo examen')
@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1">
            <form id="frmInsertExam" action="{{url('examen/insertar')}}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="txtDescriptionExam">Descripción del exámen*</label>
                        <input type="text" id="txtDescriptionExam" name="txtDescriptionExam" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtYearExam">Año*</label>
                        <input type="number" id="txtYearExam" name="txtYearExam" min="2000" max="{{date('Y')}}" value="{{date('Y')}}" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="selectTypeExam">Tipo de evaluación*</label>
                        <select name="selectTypeExam" id="selectTypeExam" style="width: 100%" class="form-control select2TypeExam" data-placeholder="Seleccione...">
                            <option value=""></option>
                            @foreach ($tTypeExam as $valueTypeExam)
                                <option value="{{$valueTypeExam->idTypeExam}}">{{strtoupper($valueTypeExam->acronymTypeExam).' : '.$valueTypeExam->nameTypeExam}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="selectSubject">Materia*</label>
                        <select name="selectSubject" id="selectSubject" style="width: 100%" class="form-control select2Subject" data-placeholder="Seleccione...">
                            <option value=""></option>
                            @foreach ($tSubject as $valueSubject)
                                <option value="{{$valueSubject->idSubject}}">{{$valueSubject->nameSubject}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="selectGrade">Grado*</label>
                        <select name="selectGrade" id="selectGrade" style="width: 100%" class="form-control select2Grade" data-placeholder="Seleccione...">
                            <option value=""></option>
                            @foreach ($tGrade as $valueGrade)
                                <option value="{{$valueGrade->idGrade}}">{{$valueGrade->numberGrade.'° de '.$valueGrade->nameGrade}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fileExamExtension">Archivo pdf*</label>
                        <input type="file" id="fileExamExtension" name="fileExamExtension" class="form-control" accept=".pdf" style="padding: 5px;">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtTotalPageExam">N° de páginas*</label>
                        <input type="number" id="txtTotalPageExam" name="txtTotalPageExam" min="1" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="selectKeywordExam">Palabras clave*</label>
                        <select name="selectKeywordExam[]" id="selectKeywordExam" class="form-control select2ExamKeyword" multiple style="width: 100%;"></select>
                    </div>
                </div>
                <div class="row" >
                    <div class="form-group col-md-3" style="font-weight: bold; font-size: 16px;">
                        ¿Registrar respuestas para la evaluación?
                    </div>
                    <div class="form-group col-md-1" style="font-weight: bold; font-size: 16px;">
                        <label style="font-weight: bold;">
                            <input type="radio" name="rdStatusAnswer" id="rdStatusAnswer" value="Si Registrar">
                            Si
                        </label>
                    </div>
                    <div class="form-group col-md-2" style="font-weight: bold; font-size: 16px;">
                        <label style="font-weight: bold;">
                            <input type="radio" name="rdStatusAnswer" id="rdStatusAnswer" value="No Registrar" checked>
                            No
                        </label>
                    </div>
                    <div class="form-group col-md-6"></div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 text-right">
                        {{csrf_field()}}
                        <input type="button" class="btn btn-primary" value="Registrar Evaluación" onclick="sendInsertExam();">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{asset('viewResources/exam/insert.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
