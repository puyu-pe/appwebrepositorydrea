@extends('template.layout')
@section('title', 'Lista de evaluaciones '.strtoupper($tTypeExam->acronymTypeExam))
@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1">
            <div id="divSearch" class="row">
                <div class="form-group col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </div>
                        <input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" onkeyup="searchTypeExam(this.value, '{{url('tipoexamen/'.$tTypeExam->acronymTypeExam.'/1')}}', event);" value="{{$searchParameter}}" autocomplete="off" autofocus>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    {!!ViewHelper::renderPagination('tipoexamen/'.$tTypeExam->acronymTypeExam, $quantityPage, $currentPage, $searchParameter)!!}
                </div>
            </div>
            <div class="table-responsive">
                <table id="tableExam" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Documento</th>
                            <th class="text-center">Año</th>
                            <th class="text-center">Nombre del examen</th>
                            <th class="text-center">Breve descripción</th>
                            <th class="text-center">N° de páginas</th>
                            <th class="text-center">Palabras clave</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listTExam as $value)
                            <tr>
                                <td class="text-center" style="width: 80px;">
                                    <a class="btn btn-xs btn-danger" target="_black" href="{{url('examen/verarchivo/'.$value->idExam)}}?x={{$value->updated_at}}">Ver examen</a>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->yearExam}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->nameExam}}</div>
                                </td>
                                <td>
                                    <div>{{$value->descriptionExam}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->totalPageExam==1 ? $value->totalPageExam.' páginas' : $value->totalPageExam.' páginas'}}</div>
                                </td>
                                <td class="text-center">
                                    @foreach(explode('__7SEPARATOR7__', $value->keywordExam) as $item)
                                        <span class="label label-default">{{$item}}</span>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('viewResources/typeexam/view.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
