@extends('backoffice.layout')
@section('title', 'Panel principal')
@section('generalBody')
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-connection-bars"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total de evaluaciones</span>
                        <span class="info-box-number">25<small>Evaluaciones</small></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="ion ion-eye"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Evaluaciones mas vistas</span>
                        <span class="info-box-number">25 Evaluaciones</span>
                    </div>

                </div>

            </div>


            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-ios-star"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Con mayor puntaje</span>
                        <span class="info-box-number">40 Evaluaciones</span>
                    </div>

                </div>

            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-filing"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mensajes pendientes</span>
                        <span class="info-box-number">1 Mensaje</span>
                    </div>

                </div>

            </div>


        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cantidad de visita mensual a las evaluaciones</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-center">
                                    <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                                </p>
                                <div class="chart">

                                    <canvas id="salesChart" style="height: 180px; width: 1073px;" height="180"
                                            width="1073"></canvas>
                                </div>

                            </div>

                        </div>

                    </div>

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


        <div class="row">

            <div class="col-md-8">

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Evaluaciones mas visitadas</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Evaluaciones</th>
                                    <th>Valoracion</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                    <td>1° EVALUACIÓN ERA APURÍMAC MATEMÁTICA 2° PRIMARIA</td>
                                    <td>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                    <td>1° EVALUACIÓN ERA APURÍMAC MATEMÁTICA 2° PRIMARIA</td>
                                    <td>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                    <td>1° EVALUACIÓN ERA APURÍMAC MATEMÁTICA 2° PRIMARIA</td>
                                    <td>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                    <td>1° EVALUACIÓN ERA APURÍMAC MATEMÁTICA 2° PRIMARIA</td>
                                    <td>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                    <td>1° EVALUACIÓN ERA APURÍMAC MATEMÁTICA 2° PRIMARIA</td>
                                    <td>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                    <td>1° EVALUACIÓN ERA APURÍMAC MATEMÁTICA 2° PRIMARIA</td>
                                    <td>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="box-footer clearfix">
                        <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All
                            Orders</a>
                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cantidad de evaluaciones por curso</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="pieChart" height="155" width="329"
                                            style="width: 329px; height: 155px;"></canvas>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <ul class="chart-legend clearfix">
                                    <li><i class="fa fa-circle-o text-red"></i> Comunicación</li>
                                    <li><i class="fa fa-circle-o text-green"></i> Matemática</li>
                                    <li><i class="fa fa-circle-o text-yellow"></i> Ciencia Tecnología y Ambiente</li>
                                    <li><i class="fa fa-circle-o text-aqua"></i> Razonamiento Matemático</li>
                                    <li><i class="fa fa-circle-o text-light-blue"></i> Comprensión Lectora</li>
                                    <li><i class="fa fa-circle-o text-gray"></i> Navigator</li>
                                </ul>
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
