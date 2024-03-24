@extends('backoffice.layout')
@section('title', 'Panel principal')
@section('generalBody')
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-document-text"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total de evaluaciones</span>
                        <span class="info-box-number" id="total_exam">
                            <i class="fa fa-spinner fa-spin"></i> Evaluaciones</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-eye"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">EVALUACIONES PÚBLICAS</span>
                        <span class="info-box-number" id="total_exam_public">
                            <i class="fa fa-spinner fa-spin"></i> Evaluaciones</span>
                    </div>
                </div>
            </div>

            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="ion ion-eye-disabled"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">EVALUACIONES OCULTAS</span>
                        <span class="info-box-number" id="total_exam_hidden">
                            <i class="fa fa-spinner fa-spin"></i> Evaluaciones</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-filing"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mensajes pendientes</span>
                        <span class="info-box-number" id="total_pending_messages"><i class="fa fa-spinner fa-spin"></i> Mensaje(s)</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!--
                    <div class="box-header with-border">
                        <h3 class="box-title">VISITAS MENSUALES A EVALUACIONES</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-center">
                                    <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                                </p>
                                <div class="chart">
                                    <canvas id="salesChart" style="height: 180px; width: 1073px;"></canvas>
                                </div>

                            </div>

                        </div>

                    </div>
                    -->
                    <!--
                                        <div class="box-footer">
                                            <h3 class="box-title">Crecimiento constante de visitas por categoria de examen</h3>
                                            <div class="row">
                                                <div class="col-sm-3 col-xs-6">
                                                    <div class="description-block border-right">
                                                        <span class="description-percentage text-green"><i
                                                                class="fa fa-caret-up"></i> 17%</span>
                                                        <h5 class="description-header">210</h5>
                                                        <span class="description-text">ECE</span>
                                                    </div>

                                                </div>

                                                <div class="col-sm-3 col-xs-6">
                                                    <div class="description-block border-right">
                                                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                                                        <h5 class="description-header">390</h5>
                                                        <span class="description-text">ERA</span>
                                                    </div>

                                                </div>

                                                <div class="col-sm-3 col-xs-6">
                                                    <div class="description-block border-right">
                                                        <span class="description-percentage text-green"><i
                                                                class="fa fa-caret-up"></i> 20%</span>
                                                        <h5 class="description-header">813</h5>
                                                        <span class="description-text">LLECE</span>
                                                    </div>

                                                </div>

                                                <div class="col-sm-3 col-xs-6">
                                                    <div class="description-block">
                                                        <span class="description-percentage text-red"><i
                                                                class="fa fa-caret-down"></i> 18%</span>
                                                        <h5 class="description-header">120</h5>
                                                        <span class="description-text">EM</span>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                    -->
                </div>
            </div>
            <div class="row">

                <div class="col-md-8">

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Evaluaciones mas vistas</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Evaluacion</th>
                                        <th>Visitas</th>
                                        <th>Valoracion</th>
                                    </tr>
                                    </thead>
                                    <tbody id="topViewedDetails">
                                    <tr>
                                        <td colspan="4">
                                            <i class="fa fa-spinner fa-spin"></i> No se encontraron vistas para los
                                            registros
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!--
                                            <div class="box-footer clearfix">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All
                                                    Orders</a>
                                            </div>
                        -->
                    </div>

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Evaluaciones mejor calificadas</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Evaluacion</th>
                                        <th>Visitas</th>
                                        <th>Valoracion</th>
                                    </tr>
                                    </thead>
                                    <tbody id="topQualifiedDetails">
                                    <tr>
                                        <td colspan="4">
                                            <i class="fa fa-spinner fa-spin"></i> No se encontraron valoraciones para
                                            los registros
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!--
                                            <div class="box-footer clearfix">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All
                                                    Orders</a>
                                            </div>
                        -->
                    </div>

                </div>

                <div class="col-md-4">

                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Evaluaciones por curso</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="chart-responsive">
                                        <canvas id="pieChart" style="width: 329px; height: 155px;">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </canvas>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <ul class="chart-legend clearfix">
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
    <script src="{{asset('assets/backoffice/viewResources/general/panel.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
    <script src="{{asset('assets/backoffice/viewResources/general/chart.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
