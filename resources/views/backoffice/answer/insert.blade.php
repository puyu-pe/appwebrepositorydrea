<form id="frmInsertAnswer" action="{{url('respuesta/insertar')}}" method="post">

    <div style="max-height: calc(100vh - 300px); overflow-y: scroll">

        <div class="table-responsive">
            <table class="table table-bordered" id="tblResponseExam">
                <thead>
                <tr>
                    <th style="width: 140px;">N° de pregunta</th>
                    <th>Descripción de la respuesta</th>
                </tr>
                </thead>
                <tbody>
                @if($tAnswer->isNotEmpty())
                    @for($i = 0; $i < $tExam->number_question; $i++)
                        @php
                            $numberAnswer = $i + 1;
                        @endphp
                        <tr>
                            <input type="hidden" id="hdIdAnswer{{$numberAnswer}}" name="hdIdAnswer[]"
                                   value="{{$numberAnswer}}">

                            <td class="text-center">
                                <div>{{$numberAnswer}}</div>
                            </td>

                            <td>
                                <input type="text" id="txtValueResponseExam{{$numberAnswer}}"
                                       name="txtValueResponseExam[]" value="{{$tAnswer[$i]->descriptionAnswer ?? ''}}"
                                       class="form-control">
                            </td>
                        </tr>
                    @endfor
                @else
                    @for($i = 0; $i < $tExam->number_question; $i++)
                        <tr>
                            <input type="hidden" id="hdIdAnswer{{$i+1}}" name="hdIdAnswer[]" value="">
                            <td class="text-center">
                                <div>{{$i+1}}</div>
                            </td>
                            <td>
                                <input type="text" id="txtValueResponseExam{{$i+1}}" name="txtValueResponseExam[]"
                                       value="" class="form-control">
                            </td>
                        </tr>
                    @endfor
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="hidden" name="hdIdExam" id="hdIdExam" value="{{$tExam->idExam}}">
            <input type="button" class="btn btn-dark pull-left col-4" data-dismiss="modal" value="Cerrar ventana">
            <input type="button" class="btn btn-primary col-3" value="Guardar" onclick="sendInsertAnswer();" style="float: right">
        </div>
    </div>
</form>
<script src="{{asset('assets/backoffice/viewResources/answer/insert.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
