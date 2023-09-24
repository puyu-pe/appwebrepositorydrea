@extends('template.layout')
@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1">
            <div class="row">
                @foreach($tTypeExam as $value)
                    <div class="col-md-3 text-center">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h5 class="box-title">{{strtoupper($value->acronymTypeExam)}}</h5>
                            </div>
                            <div class="box-body">
                                <div class="pull-left image">
                                    <img src="{{asset('img/logo/typeexam/'.$value->idTypeExam.'.'.$value->extensionImageType.'?x='.$value->updated_at)}}" height="70" width="70">
                                </div>
                                <div class="pull-left">
                                    <div style="font-size: 15px;">{{$value->descriptionTypeExam}}</div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-md-6">
                                    <input type="button" class="btn btn-primary" value="Ver pruebas" onclick="{{url('typeexam/view/'.$value->idTypeExam)}}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
