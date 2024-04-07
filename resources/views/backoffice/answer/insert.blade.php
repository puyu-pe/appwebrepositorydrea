<div id="dvRegisterData">
    <div class="row">
        <input type="hidden" name="hdTotalAnswer" id="hdTotalAnswer" value="{{$tExam->number_question}}">
        <div class="form-group col-md-3">
            <label for="numberResponse">N° de pregunta*</label>
        </div>
        <div class="form-group col-md-9">
            <label for="txtDescriptionResponse">Respuesta (puede ser solo la vocal, n° o fundamentar la respuesta)*</label>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <input type="number" id="numberResponse" name="numberResponse" class="form-control" min="1" value="{{$maxNumberAnswer+1}}">
        </div>
        <div class="form-group col-md-8">
            <input type="text" id="txtDescriptionResponse" name="txtDescriptionResponse" class="form-control">
        </div>
        <div class="form-group col-md-1">
            <span class="btn btn-default btn-sm glyphicon glyphicon-plus pull-right" data-toggle="tooltip" title="Añadir" data-placement="left" onclick="addElementConcept();"></span>
        </div>
    </div>
</div>
<form id="frmInsertAnswer" action="{{url('respuesta/insertar')}}" method="post">
    <div class="table-responsive">
        <table class="table table-bordered" id="tblResponseExam">
            <thead>
            <tr>
                <th style="width: 140px;">N° de pregunta</th>
                <th>Descripción de la respuesta</th>
                <th class="text-center" style="width: 40px;"></th>
            </tr>
            </thead>
            <tbody>
                @foreach($tAnswer as $key => $tanswer_value)
                    <tr>
                        <input type="hidden" id="hdIdAnswer{{$key+1}}" name="hdIdAnswer[]" value="{{$tanswer_value->idAnswer}}">
                        <td class="text-center">
                            <input type="number" id="numberValueExam{{$key+1}}" name="numberValueExam[]" min="1" value="{{$tanswer_value->numberAnswer}}" class="form-control" readonly>
                        </td>
                        <td>
                            <input type="text" id="txtValueResponseExam{{$key+1}}" name="txtValueResponseExam[]" value="{{$tanswer_value->descriptionAnswer}}" class="form-control">
                        </td>
                        <td class="text-center">
                            <span class="btn btn-default btn-sm glyphicon glyphicon-remove" data-toggle="tooltip" title="Quitar" data-placement="left" onclick="removeTableRowResponse(this);"></span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="hidden" name="hdIdExam" id="hdIdExam" value="{{$tExam->idExam}}">
            <input type="button" class="btn btn-default pull-left" data-dismiss="modal" value="Cerrar ventana">
            <input type="button" class="btn btn-primary" value="Guardar" onclick="sendInsertAnswer();">
        </div>
    </div>
</form>
<script src="{{asset('assets/backoffice/viewResources/answer/insert.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
