<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Repositorio DREA Apurímac</title>
        <link rel="icon" type="image/jpg" href="{{asset('img/dreaapurimac.png')}}">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{asset('plugins/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{asset('plugins/adminlte/bower_components/select2/dist/css/select2.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('plugins/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{asset('plugins/adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('plugins/adminlte/dist/css/AdminLTE.min.css')}}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{asset('plugins/adminlte/dist/css/skins/_all-skins.min.css')}}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="{{asset('plugins/pnotify/pnotify.custom.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/layout.css')}}">
        <link rel="stylesheet" href="{{asset('css/cssPagination.css')}}">
        <!-- jQuery 3 -->
        <script src="{{asset('plugins/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
    </head>
    <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-blue layout-top-nav">
    <script>
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
                  timer: '{{Session::get('type')=='success' ? '3000': '8000'}}',
                  html: true
                });
          @endif
      @endif
      });
    </script>
  <div class="wrapper">
    <header class="main-header">
      <nav class="navbar navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <a href="#" class="navbar-brand"><b>DREA Apurímac</b></a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              @include('template/partial/menu')
          </div>
          <!-- /.navbar-collapse -->
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                  @if (Session::has('idUser'))
                      <li class="dropdown user user-menu">
                          <a href="{{url('usuario/editar')}}" class="dropdown-toggle">
                            <img src="{{Session::get('avatarExtension')=='' ?
                                          asset('img/userlogo.png') :
                                          asset('img/logo/user/'.Session::get('idUser').'.'.Session::get('avatarExtension').'?x='.Session::get('updated_at'))}}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{Session::get('firstName').' '.Session::get('surName')}}</span>
                          </a>
                      </li>
                      <li class="dropdown">
                        <a href="{{url('panel')}}" class="dropdown-toggle" data-toggle="tooltip" data-original-title="Panel Usuario" data-placement="bottom">
                            <i class="fa fa-gear"></i>
                        </a>
                      </li>
                      <li class="dropdown">
                          <a href="{{url('usuario/salir')}}" class="dropdown-toggle" data-toggle="tooltip" data-original-title="Cerrar Sesión" data-placement="bottom">
                              <i class="fa fa-sign-out"></i>
                          </a>
                      </li>
                  @endif
              </ul>
          </div>
          <!-- /.navbar-custom-menu -->
        </div>
        <!-- /.container-fluid -->
      </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
      <div class="container">
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
      <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="text-center hidden-xs">
          <strong>Dirección Regional de Eduación &copy; {{date('Y')}} <a href="#">Abancay-Apurímac</a>.</strong> Todos los derechos reservados.
      </div>
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
  </div>
  <!-- ./wrapper -->
      <!-- Bootstrap 3.3.7 -->
      <script src="{{asset('plugins/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
      <!-- Slimscroll -->
      <script src="{{asset('plugins/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
      <!-- FastClick -->
      <script src="{{asset('plugins/adminlte/bower_components/fastclick/lib/fastclick.js')}}"></script>
       <!-- Select2 -->
       <script src="{{asset('plugins/adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
      <!-- AdminLTE App -->
      <script src="{{asset('plugins/adminlte/dist/js/adminlte.min.js')}}"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="{{asset('plugins/adminlte/dist/js/demo.js')}}"></script>
      <script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script>
      <script src="{{asset('js/codideepHelpers.js')}}"></script>
      <script src="{{asset('plugins/formvalidation/formValidation.min.js')}}"></script>
      <script src="{{asset('plugins/formvalidation/bootstrap.validation.min.js')}}"></script>
      <script src="{{asset('plugins/pnotify/pnotify.custom.min.js')}}"></script>
      <script src="{{asset('viewResources/template/layout.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
    </body>
</html>
