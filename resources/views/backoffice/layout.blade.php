<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Panel Repositorio DREA</title>
      <link rel="icon" type="image/png" href="{{asset('img/dreaapurimac.png')}}">
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.7 -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
      <!-- Bootstrap time Picker -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">
      <!-- Select2 -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/select2/dist/css/select2.min.css')}}">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
      <!-- Ionicons -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
      <!-- fullCalendar -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/fullcalendar/dist/fullcalendar.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/fullcalendar/dist/fullcalendar.print.min.css')}}" media="print">
       <!-- DataTables -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
      <!-- Theme style -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/dist/css/AdminLTE.min.css')}}">
      <!-- AdminLTE Skins. Choose a skin from the css/skins
          folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/dist/css/skins/_all-skins.min.css')}}">
      <!-- Morris chart -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/morris.js/morris.css')}}">
      <!-- jvectormap -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/jvectormap/jquery-jvectormap.css')}}">
      <!-- Date Picker -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
      <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
      <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/pnotify/pnotify.custom.min.css')}}">
      <link rel="stylesheet" href="{{asset('css/cssPagination.css')}}">
      <link rel="stylesheet" href="{{asset('css/layout.css')}}">
      <!-- jQuery 3 -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
    </head>
  <body class="hold-transition skin-blue sidebar-mini">
      <script>

          const  BASE_URL = '{{ url('/') }}';

        $(function()
        {
          @if(Session::has('globalMessage'))
            @if(Session::get('type')=='error' || Session::get('type')=='exception')
              @foreach(Session::get('globalMessage') as $value)
                @if(trim($value)!='')
                  new PNotify(
                    {
                      title : 'No se pudo proceder',
                      text : '{{$value}}',
                      type : 'error'
                    });
                @endif
              @endforeach
            @else
                swal(
                  {
                    title: '{{Session::get('type')=='success' ? 'Correcto' : 'Alerta'}}',
                    text: '{!!Session::get('globalMessage')[0]!!}',
                    icon: '{{Session::get('type')}}',
                    timer: '{{stristr(Session::get('globalMessage')[0], 'Bienvenido al sistema, ')==true ? '3000' : '1000'}}',
                    html: true
                  });
            @endif
        @endif
        });
      </script>
      <div class="wrapper">
        <header class="main-header">
          <!-- Logo -->
          <a href="" class="logo" style="background-color: #000000;">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini"><b>DRE</b>A</span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg"><b>DREA </b>Apurímac</span>
          </a>
          <!-- Header Navbar: style can be found in header.less -->
          <nav class="navbar navbar-static-top" style="background-color: #000000;">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" onclick="openCloseMenu();">
                  <span class="sr-only">Toggle navigation</span>
              </a>
              <div class="navbar-custom-menu">
                  <ul class="nav navbar-nav">
                      <!-- User Account: style can be found in dropdown.less -->
                      @include('backoffice/partial/useraccount')
                      <!-- Control Sidebar Toggle Button -->
                      <li>
                          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                      </li>
                  </ul>
              </div>
          </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
              <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{Session::get('avatarExtension')=='' ?
                        asset('img/userlogo.png') :
                        asset('img/logo/user/'.Session::get('idUser').'.'.Session::get('avatarExtension').'?x='.Session::get('updated_at'))}}" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{Session::get('firstName')}}</p>
                        <a href="#"><i class="fa fa-circle text-success"></i>En Línea</a>
                    </div>
                </div>
                @include('backoffice/partial/menu')
            </section>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                  @yield('title')
                </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                @yield('generalBody')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2021-2022 <a href="https://adminlte.io" style="_blank">Abancay-Apurímac</a>.</strong> Todos los derechos reservados.
        </footer>
        <div id="modalLoading" style="display: none;">
          <div>
              <div>
                  <div>
                  </div>
              </div>
          </div>
      </div>
      <div id="divGeneralContainer"></div>
        <!-- Control Sidebar -->
        @include('backoffice/partial/controlsidebar')
      </div>
      <!-- jQuery UI 1.11.4 -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
      <script>
        $.widget.bridge('uibutton', $.ui.button);
      </script>
      <!-- Bootstrap 3.3.7 -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
      <!-- DataTables -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
      <!-- Morris.js charts -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/raphael/raphael.min.js')}}"></script>
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/morris.js/morris.min.js')}}"></script>
      <!-- Sparkline -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
      <!-- jvectormap -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
      <script src="{{asset('assets/backoffice/plugins/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
      <!-- jQuery Knob Chart -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
      <!-- daterangepicker -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/moment/min/moment.min.js')}}"></script>
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
      <!-- datepicker -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
      <!-- datepicker en español -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js')}}"></script>
      <!-- bootstrap time picker -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
      <!-- Slimscroll -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
      <!-- FastClick -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/fastclick/lib/fastclick.js')}}"></script>
      <!-- Select2 -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
      <!-- AdminLTE App -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/dist/js/adminlte.min.js')}}"></script>
      <!--Sweet Alert-->
      <script src="{{asset('assets/backoffice/plugins/sweetalert/sweetalert.min.js')}}"></script>
      <!-- fullCalendar -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/moment/moment.js')}}"></script>
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/fullcalendar/dist/fullcalendar.min.js')}}"></script>
      <!-- fullCalendar es español -->
      <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/fullcalendar/dist/locale/es.js')}}"></script>
      <script src="{{asset('js/codideepHelpers.js')}}"></script>
      <script src="{{asset('assets/backoffice/plugins/formvalidation/formValidation.min.js')}}"></script>
      <script src="{{asset('assets/backoffice/plugins/formvalidation/bootstrap.validation.min.js')}}"></script>
      <script src="{{asset('assets/backoffice/plugins/pnotify/pnotify.custom.min.js')}}"></script>
      <script src="{{asset('assets/backoffice/viewResources/template/layout.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
  </body>
</html>
