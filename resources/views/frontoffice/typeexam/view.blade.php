@extends('frontoffice.layout')
@section('generalBody')
    <!-- breadcrumb-area-start -->
    <div class="it-breadcrumb-area it-breadcrumb-bg"
         data-background="{{asset('assets/frontoffice/img/breadcrumb/breadcrumb.jpg')}}">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="it-breadcrumb-content z-index-3 text-center">
                        <div class="it-breadcrumb-title-box">
                            <h3 class="it-breadcrumb-title">{{'Lista de evaluaciones '.strtoupper($tTypeExam->acronymTypeExam)}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-end -->

    <!-- cart-area-start -->
    <section class="cart-area pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div id="divSearch" class="row">
                        <div class="form-group col-md-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-search"></i>
                                </div>
                                <input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right"
                                       placeholder="Información para búsqueda (Enter)"
                                       onkeyup="searchTypeExam(this.value, '{{url('tipoexamen/'.$tTypeExam->acronymTypeExam.'/1')}}', event);"
                                       value="{{$searchParameter}}" autocomplete="off" autofocus>
                            </div>
                            <br>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="hidden" id="downloadUrl" value="{{ route('download.selected') }}">
                            <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
                            <button id="downloadBtn" style="display:none;" class="btn btn-primary">Descargar selección
                            </button>
                        </div>
                        <div class="form-group col-md-5">
                            {!!ViewHelper::renderPagination('tipoexamen/'.$tTypeExam->acronymTypeExam, $quantityPage, $currentPage, $searchParameter)!!}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tableExam" class="table table-bordered">
                            <tbody>
                            @foreach($listTExam as $value)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="result[]" value="{{$value->idExam}}"
                                               style="width: 30px; height: 30px">
                                    </td>
                                    <td class="text-left">
                                        <div style="text-decoration: underline;text-transform: uppercase;">
                                            <a href="{{url('examen/ver/'.$value->codeExam)}}" target="_blank">
                                                <h4>{{$value->nameExam}}</h4>
                                            </a>
                                        </div>
                                        <div>{{$value->descriptionExam}}</div>
                                    </td>
                                    <td class="text-center">
                                        <div>{{$value->yearExam}}</div>
                                    </td>
                                    <td class="text-center">
                                        <div>{{$value->totalPageExam==1 ? $value->totalPageExam.' páginas' : $value->totalPageExam.' páginas'}}</div>
                                    </td>
                                    <td class="text-center" style="width: 100px;">
                                        <a href="{{url('examen/verarchivo/'.$value->idExam)}}?x={{$value->updated_at}}"
                                           target="_blank">
                                            <span class="fa fa-file-pdf-o"></span> Ver evaluación
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- cart-area-end -->
    <script src="{{asset('assets/frontoffice/viewResources/typeexam/view.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
