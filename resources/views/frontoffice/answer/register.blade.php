<form id="frmInsertAnswer" action="{{url('respuesta/registrar')}}" method="post">
    <div class="row">
        <div class="col-md-7">
            <iframe src="{{ url('examen/verarchivo/' . $tExam->idExam) }}?x={{ $tExam->updated_at }}#toolbar=0"
                    frameborder="0" allowfullscreen style="height: 100%; width: 100%; border: none;"></iframe>
        </div>
        <div class="col-md-5">
            <div style="max-height: calc(100vh - 300px); overflow-y: scroll">

                <div class="table-responsive">
                    <table class="table table-bordered" id="tblResponseExam">
                        <thead>
                        <tr>
                            <th class="text-center">N°</th>
                            <th>Alternativa</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($tAnswerDetail)
                            @foreach($tAnswerDetail as $key => $tanswer_value)
                                <tr>
                                    <input type="hidden" id="hdIdAnswerDetail{{$tanswer_value->numberAnswer}}" name="hdIdAnswerDetail[]" value="{{$tanswer_value->idAnswerDetail}}">
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
                                        <input type="hidden" id="hdIdAnswerDetail{{$i}}" name="hdIdAnswerDetail[]" value="">
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
                                    <input type="hidden" id="hdIdAnswerDetail{{$i+1}}" name="hdIdAnswerDetail[]" value="">
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
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="hidden" name="hdIdExam" id="hdIdExam" value="{{$tExam->idExam}}">
            <input type="hidden" name="hdIdAnswer" id="hdIdAnswer" value="{{$tAnswer ? $tAnswer->idAnswer : ''}}">
            <input type="button" class="btn btn-xs btn-dark pull-left col-md-3" data-dismiss="modal" data-bs-dismiss="modal" value="Cerrar">
            <input type="button" class="btn btn-xs btn-primary col-md-3" value="Guardar respuestas" onclick="sendInsertAnswer();" style="float: right">
        </div>
    </div>
</form>
<script src="{{asset('assets/backoffice/viewResources/answer/insert.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>