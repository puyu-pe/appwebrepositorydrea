<form id="frmInsertAnswer" action="{{url('respuesta/insertar')}}" method="post">

    <div style="max-height: calc(100vh - 300px); overflow-y: scroll">

        <div class="table-responsive">
            <table class="table table-bordered" id="tblResponseExam">
                <thead>
                <tr>
                    <th class="text-center">N°</th>
                    <th>Respuesta</th>
                </tr>
                </thead>
                <tbody>
                @if($tAnswer->isNotEmpty())
                    @foreach($tAnswer as $key => $tanswer_value)
                        <tr>
                            <input type="hidden" id="hdIdAnswer{{$tanswer_value->numberAnswer}}" name="hdIdAnswer[]" value="{{$tanswer_value->idAnswer}}">
                            <td class="text-center">
                                <div>{{$tanswer_value->numberAnswer}}</div>
                            </td>
                            <td>
                                <input type="text" id="txtValueResponseExam{{$tanswer_value->numberAnswer}}" name="txtValueResponseExam[]" value="{{$tanswer_value->descriptionAnswer}}" class="form-control">
                            </td>
                        </tr>
                    @endforeach
                    @if($maxNumberAnswer<$tExam->number_question)
                        @for($i = $maxNumberAnswer+1; $i <= $tExam->number_question; $i++)
                            <tr>
                                <input type="hidden" id="hdIdAnswer{{$i}}" name="hdIdAnswer[]" value="">
                                <td class="text-center">
                                    <div>{{$i}}</div>
                                </td>
                                <td>
                                    <input type="text" id="txtValueResponseExam{{$i}}" name="txtValueResponseExam[]" value="" class="form-control">
                                </td>
                            </tr>
                        @endfor
                    @endif
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
            <input type="button" class="btn btn-dark pull-left col-3" data-dismiss="modal" data-bs-dismiss="modal" value="Cerrar">
            <input type="button" class="btn btn-primary col-3" value="Guardar" onclick="sendInsertAnswer();" style="float: right">
        </div>
    </div>
</form>
<script src="{{asset('assets/backoffice/viewResources/answer/insert.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
