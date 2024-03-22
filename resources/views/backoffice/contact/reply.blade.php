<form id="frmReplyContact" action="{{url('contacto/responder')}}" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="txtName">Nombre Completo</label>
            <input type="text" id="txtname" value="{{$tContact->completeNameContact}}" class="form-control" readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="txtEmail">Correo</label>
            <input type="text" id="txtEmail" value="{{$tContact->emailContact}}" class="form-control" readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="txtPhone">Telefono</label>
            <input type="text" id="txtPhone" name="txtDescriptionExam" value="{{$tContact->phoneContact}}"
                   class="form-control" readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="txtDate">Fecha</label>
            <input type="text" id="txtDate" name="txtDescriptionExam"
                   value="{{\Carbon\Carbon::parse($tContact->dateContact)->format('d/m/Y')}}" class="form-control"
                   readonly>
        </div>
        <div class="form-group col-md-12">
            <label for="txtAffair">Asunto</label>
            <input type="text" id="txtAffair" name="txtDescriptionExam" value="{{$tContact->affairContact}}"
                   class="form-control" readonly>
        </div>
        <div class="form-group col-md-12">
            <label>Consulta: </label>
            <p>
                {{$tContact->messageContact}}
            </p>
            <label for="txtMessage">Responder: </label>
            <textarea id="txtMessage" name="txtMessage" class="form-control" autocomplete="off" placeholder="Mensaje"
                      id="" cols="30" rows="10"
            {{$tContact->statusContact == 1 ? 'readonly' : ''}}
            >{{$tContact->replyContact}}</textarea>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="hidden" name="hdIdContact" id="hdIdContact" value="{{$tContact->idContact}}">
            <input type="button" class="btn btn-default pull-left" data-dismiss="modal" value="Cerrar ventana">
            @if($tContact->statusContact == 0)
                <input type="button" class="btn btn-primary" value="Responder consulta"
                       onclick="sendFrmReplyContact();">
            @endif
        </div>
    </div>
</form>
<script src="{{asset('assets/backoffice/viewResources/contact/reply.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
