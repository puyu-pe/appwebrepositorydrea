<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>DREA Apurimac Login</title>
        <link rel="icon" type="image/png" href="{{asset('img/dreaapurimac.png')}}">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{asset('plugins/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('plugins/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{asset('plugins/adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('plugins/adminlte/dist/css/AdminLTE.min.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{asset('plugins/adminlte/plugins/iCheck/square/blue.css')}}">
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="{{asset('plugins/pnotify/pnotify.custom.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/layout.css')}}">
        <!-- jQuery 3 -->
        <script src="{{asset('plugins/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b>DREA </b>Apurímac</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
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
                <p class="login-box-msg">Ingresar al Sistema</p>
                <form id="frmLogin" action="{{url('usuario/acceder')}}" method="post">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Correo Electrónico">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" id="passPassword" name="passPassword" class="form-control" placeholder="Contraseña" onkeyup="onKeyUpPassPassword(event);">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        {{csrf_field()}}
                        <div class="col-xs-8">
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <input type="button" class="btn btn-primary btn-block btn-flat" value="Ingresar" onclick="sendfrmLogin();">
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <a href="{{url('usuario/recuperar')}}">Olvide mi contraseña</a><br>
                <a href="{{url('usuario/registrar')}}" class="text-center">Registrar nuevo usuario</a>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
        <div id="modalLoading" style="display: none;">
            <div>
                <div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{asset('plugins/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- iCheck -->
        <script src="{{asset('plugins/adminlte/plugins/iCheck/icheck.min.js')}}"></script>
        <script src="{{asset('js/codideepHelpers.js')}}"></script>
        <script src="{{asset('plugins/formvalidation/formValidation.min.js')}}"></script>
        <script src="{{asset('plugins/formvalidation/bootstrap.validation.min.js')}}"></script>
        <script src="{{asset('plugins/pnotify/pnotify.custom.min.js')}}"></script>
        <script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script>
        <script src="{{asset('viewResources/user/login.js')}}?x={{env('CACHE_LAST_UPDATE')}}"></script>
    </body>
</html>
