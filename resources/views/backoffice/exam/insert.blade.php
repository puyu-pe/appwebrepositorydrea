@extends('backoffice.layout')
@section('title', 'Registrar una nuevo evaluación')
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
                        <label for="selectTypeExam">Tipo de evaluación*</label>
                        <select name="selectTypeExam" id="selectTypeExam" style="width: 100%" class="form-control select2TypeExam" data-placeholder="Seleccione...">
                            <option value=""></option>
                            @foreach ($tTypeExam as $valueTypeExam)
                                <option value="{{$valueTypeExam->idTypeExam}}">{{strtoupper($valueTypeExam->acronymTypeExam).' : '.$valueTypeExam->nameTypeExam}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="selectDirectionExam">DRE a la que pertenece</label>
                        <select name="selectDirectionExam" id="selectDirectionExam" style="width: 100%" class="form-control select2DirectionExam" data-placeholder="Seleccione...">
                            <option value=""></option>
                            <option value="General">General</option>
                            @foreach ($tDirection as $valueDirection)
                                <option value="{{$valueDirection->idDirection}}">{{$valueDirection->namesortDirection}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="txtYearExam">Año*</label>
                        <input type="number" id="txtYearExam" name="txtYearExam" min="1000" max="{{date('Y')}}" value="{{date('Y')}}" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="numberEvaluationExecute">N° de Evaluación*</label>
                        <input type="number" id="numberEvaluationExecute" name="numberEvaluationExecute" min="1" class="form-control" value="1">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtTotalPageExam">N° de páginas*</label>
                        <input type="number" id="txtTotalPageExam" name="txtTotalPageExam" min="1" class="form-control">
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
                        <label for="selectSubject">Materia*</label>
                        <select name="selectSubject" id="selectSubject" style="width: 100%" class="form-control select2Subject" data-placeholder="Seleccione...">
                            <option value=""></option>
                            @foreach ($tSubject as $valueSubject)
                                <option value="{{$valueSubject->idSubject}}">{{$valueSubject->nameSubject}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="selectKeywordExam">Palabras clave*</label>
                        <select name="selectKeywordExam[]" id="selectKeywordExam" class="form-control select2ExamKeyword" multiple style="width: 100%;"></select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="selectRegisterAnswer">Permite respuestas*</label>
                        <select name="selectRegisterAnswer" id="selectRegisterAnswer" style="width: 100%" class="form-control" onchange="showButtonResponse($(this).val());">
                            <option value="" selected disabled>Seleccione ...</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="txtResponseExamPermit">N° preguntas</label>
                        <input type="number" id="txtResponseExamPermit" name="txtResponseExamPermit" min="1" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fileExamExtension">Archivo pdf*</label>
                        <input type="file" id="fileExamExtension" name="fileExamExtension" class="form-control" accept=".pdf" style="padding: 5px;">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="fileTableResource">Tabla de especificaciones</label>
                        <input type="file" id="fileTableResource" name="fileTableResource" class="form-control" accept=".pdf" style="padding: 5px;">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fileResource">Recursos adicionales</label>
                        <input type="file" name="fileResource[]" id="fileResource" multiple accept=".pdf" class="form-control" style="padding: 5px;">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 text-right">
                        {{csrf_field()}}
                        <input type="button" class="btn btn-facebook" value="Registrar respuestas" id="btnModalResponse" onclick="openModal()" style="display: none;">
                        <input type="button" class="btn btn-primary" value="Registrar Evaluación" onclick="sendInsertExam();">
                    </div>
                </div>
            </form>
            <div class="modal fade" id="modalAccess" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-xs">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Registrar respuestas</h4>
                        </div>
                        <div class="modal-body" id="dvExamResponse">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="numberResponse">N° de pregunta*</label>
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="txtDescriptionResponse">Respuesta (puede ser solo la vocal, n° o fundamentar la respuesta)*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <input type="number" id="numberResponse" name="numberResponse" class="form-control" min="1" value="1">
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" id="txtDescriptionResponse" name="txtDescriptionResponse" class="form-control">
                                </div>
                                <div class="form-group col-md-1">
                                    <span class="btn btn-default btn-sm glyphicon glyphicon-plus pull-right" data-toggle="tooltip" title="Añadir" data-placement="left" onclick="addElementConcept();"></span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tblResponseExam">
                                    <thead>
                                    <tr>
                                        <th style="width: 120px;">N° de pregunta</th>
                                        <th>Descripción de la respuesta</th>
                                        <th class="text-center" style="width: 40px;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="form-group col-md-12 text-center">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar Ventana</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/backoffice/viewResources/exam/insert.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
