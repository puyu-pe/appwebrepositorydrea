@extends('frontoffice.layout')
@section('title', $tExam->ttypeexam->nameTypeExam)
@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="row">
                        <table class="tblDates">
                            <tbody>
                                <tr>
                                    <td><p style="font-weight: bold;">Nombre de la evaluación</p></td>
                                    <td><p>:</p></td>
                                    <td><p style="font-weight: bold;">{{$tExam->nameExam}}</p></td>
                                </tr>
                                <tr>
                                    <td style="width: 200px;"><p style="font-weight: bold;">Fecha de publiación</p></td>
                                    <td style="width: 80px;"><p>:</p></td>
                                    <td><p style="font-weight: bold;">{{date('d-m-Y',strtotime($tExam->created_at))}}</p></td>
                                </tr>
                                <tr>
                                    <td><p style="font-weight: bold;">Descripción</p></td>
                                    <td><p>:</p></td>
                                    <td><p style="font-weight: bold;">{{$tExam->descriptionExam}}</p></td>
                                </tr>
                                <tr>
                                    <td><p style="font-weight: bold;">N° de páginas</p></td>
                                    <td><p>:</p></td>
                                    <td><p>{{$tExam->totalPageExam}}</p></td>
                                </tr>
                                <tr>
                                    <td><p style="font-weight: bold;">Año que se aplicó</p></td>
                                    <td><p>:</p></td>
                                    <td><p>{{$tExam->yearExam}}</p></td>
                                </tr>
                                <tr>
                                    <td><p style="font-weight: bold;">Palabras clave de búsqueda</p></td>
                                    <td><p>:</p></td>
                                    <td><p>{{str_replace("__7SEPARATOR7__", "; ", $tExam->keywordExam)}}</p></td>
                                </tr>
                                <tr>
                                    <td><p style="font-weight: bold;">Opción</p></td>
                                    <td><p>:</p></td>
                                    <td><p><a href="{{url('examen/verarchivo/'.$tExam->idExam)}}?x={{$tExam->updated_at}}" target="_blank">Ver pdf de evaluación</a></p></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</div>
@endsection
