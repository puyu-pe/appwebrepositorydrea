@extends('dashboard.layout')
@section('title', 'Registrar respuestas para la evaluación')
@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1">
            <form id="frmInsertExam" action="{{url('cuestionario/registrar/'.$tExam->idExam)}}" method="post">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="txtDescriptionExam">Descripción del exámen*</label>
                        <input type="text" id="txtDescriptionExam" name="txtDescriptionExam" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtYearExam">Año*</label>
                        <input type="number" id="txtYearExam" name="txtYearExam" min="2000" max="{{date('Y')}}" value="{{date('Y')}}" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 text-right">
                        {{csrf_field()}}
                        <input type="button" class="btn btn-primary" value="Registrar respuestas" onclick="sendRegisterQuestion();">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{asset('viewResources/question/register.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
