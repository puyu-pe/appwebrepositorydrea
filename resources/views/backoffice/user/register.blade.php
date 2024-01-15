<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Repositorio DREA Apurímac</title>
        <link rel="icon" type="image/png" href="{{asset('img/dreaapurimac.png')}}">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/dist/css/AdminLTE.min.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/plugins/iCheck/square/blue.css')}}">
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/pnotify/pnotify.custom.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/layout.css')}}">
        <!-- jQuery 3 -->
        <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
    </head>
    <body class="hold-transition register-page">
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
        <div class="register-box">
            <div class="register-logo">
                <a href="#"><b>DREA </b>Apurímac</a>
            </div>
            <div class="register-box-body">
                <p class="login-box-msg">Registrarse para acceder al sistema</p>
                <form id="frmRegister" action="{{url('usuario/registrar')}}" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="txtFirstName" name="txtFirstName" placeholder="Nombres">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="txtSurName" name="txtSurName" placeholder="Apellidos">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="txtNumberDni" name="txtNumberDni" placeholder="N° de DNI">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="txtEmail" name="txtEmail" placeholder="Correo electrónico">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" id="passPasswordUser" name="passPasswordUser" placeholder="Contraseña">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" id="passPasswordRetypeUser" name="passPasswordRetypeUser" placeholder="Repite la Contraseña">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                    <div class="row">
                        {{csrf_field()}}
                        <div class="col-xs-8">
                        </div>
                        <div class="col-xs-4">
                            <input type="button" class="btn btn-primary btn-block btn-flat" value="Registrarse" onclick="sendfrmRegister();">
                        </div>
                    </div>
                </form>
                <a href="{{url('usuario/acceder')}}" class="text-center">Ya tengo un Usuario Registrado</a>
            </div>
        </div>
        <div id="modalLoading" style="display: none;">
            <div>
                <div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- iCheck -->
        <script src="{{asset('assets/backoffice/plugins/adminlte/plugins/iCheck/icheck.min.js')}}"></script>
        <script src="{{asset('js/codideepHelpers.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/formvalidation/formValidation.min.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/formvalidation/bootstrap.validation.min.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/pnotify/pnotify.custom.min.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/sweetalert/sweetalert.min.js')}}"></script>
        <script src="{{asset('assets/backoffice/viewResources/user/register.js')}}?x={{env('CACHE_LAST_UPDATE')}}"></script>
    </body>
</html>
