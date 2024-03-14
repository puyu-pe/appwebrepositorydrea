<form id="frmEditTypeExam" action="{{url('tipoexamen/editar')}}" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="txtNameTypeExam">Nombre completo del examen*</label>
            <input type="text" id="txtNameTypeExam" name="txtNameTypeExam" class="form-control" value="{{$tTypeExam->nameTypeExam}}" autocomplete="off">
        </div>
        <div class="form-group col-md-3">
            <label for="txtAcronymTypeExam">Siglas*</label>
            <input type="text" id="txtAcronymTypeExam" name="txtAcronymTypeExam" class="form-control" value="{{$tTypeExam->acronymTypeExam}}" autocomplete="off">
        </div>
        <div class="form-group col-md-3">
            <label for="fileTypeExamLogo">Logotipo</label>
            <input type="file" id="fileTypeExamLogo" name="fileTypeExamLogo" class="form-control" accept=".jpg,.png,.jpeg" style="padding: 5px;">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-2">
            <label for="numberExecute">Ejecución*</label>
            <input type="number" name="numberExecute" id="numberExecute" class="form-control" min="1" value="{{$tTypeExam->numberExecuteYear}}">
        </div>
        <div class="form-group col-md-10">
            <label for="txtDescriptionTypeExam">Breve Descripción*</label>
            <input type="text" id="txtDescriptionTypeExam" name="txtDescriptionTypeExam" class="form-control" value="{{$tTypeExam->descriptionTypeExam}}" autocomplete="off">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="hidden" name="hdIdTypeExam" id="hdIdTypeExam" value="{{$tTypeExam->idTypeExam}}">
            <input type="button" class="btn btn-default pull-left" data-dismiss="modal" value="Cerrar ventana">
            <input type="button" class="btn btn-primary" value="Guardar cambios" onclick="sendFrmEditTypeExam();">
        </div>
    </div>
</form>
<script src="{{asset('assets/backoffice/viewResources/typeexam/edit.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
