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
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($tAnswerDetail as $key => $tanswer_value)
                            <tr style="color: {{$tanswer_value->is_correct == 1 ? 'green;' : 'red;'}}}">
                                <td class="text-center">
                                    <div>{{$tanswer_value->numberAnswer}}</div>
                                </td>
                                <td>
                                    <div>{{$tanswer_value->descriptionAnswer}}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="form-group col-md-12 text-center">
        {{csrf_field()}}
        <input type="hidden" name="hdIdExam" id="hdIdExam" value="{{$tExam->idExam}}">
        <input type="hidden" name="hdIdAnswer" id="hdIdAnswer" value="{{$tAnswer ? $tAnswer->idAnswer : ''}}">
        <input type="button" class="btn btn-xs btn-dark pull-left col-md-3" data-dismiss="modal" data-bs-dismiss="modal" value="Cerrar">
    </div>
</div>
