<form id="frmEditExam" action="{{url('examen/editar')}}" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="txtDescriptionExam">Descripción del exámen*</label>
            <input type="text" id="txtDescriptionExam" name="txtDescriptionExam" value="{{$tExam->descriptionExam}}" class="form-control" autocomplete="off">
        </div>
        <div class="form-group col-md-3">
            <label for="selectTypeExam">Tipo de evaluación*</label>
            <select name="selectTypeExam" id="selectTypeExam" style="width: 100%" class="form-control select2TypeExam">
                @foreach ($tTypeExam as $valueTypeExam)
                    <option value="{{$valueTypeExam->idTypeExam}}" {{$tExam->idTypeExam==$valueTypeExam->idTypeExam ? 'selected' : ''}}>{{strtoupper($valueTypeExam->acronymTypeExam).' : '.$valueTypeExam->nameTypeExam}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="selectDirectionExam">DRE a la que pertenece</label>
            <select name="selectDirectionExam" id="selectDirectionExam" style="width: 100%" class="form-control select2DirectionExam" data-placeholder="Seleccione...">
                <option value=""></option>
                <option value="General" {{$tExam->idDirection == null ? 'selected' : ''}}>General</option>
                @foreach ($tDirection as $valueDirection)
                    <option value="{{$valueDirection->idDirection}}" {{$tExam->idDirection == $valueDirection->idDirection ? 'selected' : ''}}>{{$valueDirection->namesortDirection}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-2">
            <label for="txtYearExam">Año*</label>
            <input type="number" id="txtYearExam" name="txtYearExam" min="2000" max="{{date('Y')}}" value="{{$tExam->yearExam}}" class="form-control" autocomplete="off">
        </div>
        <div class="form-group col-md-2">
            <label for="numberEvaluationExecute">N° de Evaluación*</label>
            <input type="number" id="numberEvaluationExecute" name="numberEvaluationExecute" min="1" class="form-control" autocomplete="off" value="{{$tExam->numberEvaluation}}" min="1">
        </div>
        <div class="form-group col-md-2">
            <label for="txtTotalPageExam">N° de páginas*</label>
            <input type="number" id="txtTotalPageExam" name="txtTotalPageExam" min="1" value="{{$tExam->totalPageExam}}" class="form-control" autocomplete="off">
        </div>
        <div class="form-group col-md-3">
            <label for="selectGrade">Grado*</label>
            <select name="selectGrade" id="selectGrade" style="width: 100%" class="form-control select2Grade">
                @foreach ($tGrade as $valueGrade)
                    <option value="{{$valueGrade->idGrade}}" {{$tExam->idGrade==$valueGrade->idGrade ? 'selected' : ''}}>{{$valueGrade->numberGrade.'° de '.$valueGrade->nameGrade}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="selectSubject">Materia*</label>
            <select name="selectSubject" id="selectSubject" style="width: 100%" class="form-control select2Subject">
                @foreach ($tSubject as $valueSubject)
                    <option value="{{$valueSubject->idSubject}}" {{$tExam->idSubject==$valueSubject->idSubject ? 'selected' : ''}}>{{$valueSubject->nameSubject}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-9">
            <label for="selectKeywordExam">Palabras clave*</label>
            <select name="selectKeywordExam[]" id="selectKeywordExam" class="form-control select2ExamKeyword" multiple style="width: 100%;">
                @foreach(explode('__7SEPARATOR7__',$tExam->keywordExam) as $value)
                    <option value="{{$value}}" selected>{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="fileExamExtension">Archivo pdf</label>
            <input type="file" id="fileExamExtension" name="fileExamExtension" class="form-control" accept=".pdf" style="padding: 5px;">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="hidden" name="hdIdExam" id="hdIdExam" value="{{$tExam->idExam}}">
            <input type="button" class="btn btn-default pull-left" data-dismiss="modal" value="Cerrar ventana">
            <input type="button" class="btn btn-primary" value="Guardar cambios" onclick="sendFrmEditExam();">
        </div>
    </div>
</form>
<script src="{{asset('assets/backoffice/viewResources/exam/edit.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
