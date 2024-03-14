<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>DREA Apurímac Recuperar</title>
        <link rel="icon" type="image/png" href="{{asset('img/dreaapurimac.png')}}">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/adminlte/dist/css/AdminLTE.min.css')}}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/pnotify/pnotify.custom.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/layout.css')}}">
        <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
    </head>
    <body class="hold-transition lockscreen">
        <div class="lockscreen-wrapper">
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
            <div class="lockscreen-logo">
                <a href="{{url('/')}}"><b>DREA </b>Apurímac</a>
            </div>
            <div class="lockscreen-item">
                <div class="lockscreen-image">
                    <img src="{{asset('img/userlogo.png')}}" alt="User Image">
                </div>
                <form class="lockscreen-credentials" action="{{url('usuario/recuperar')}}" method="post" id="frmRecuperate">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="txtEmail" name="txtEmail" onkeyup="onKeyUpPassPassword(event);" placeholder="Correo electrónico" autocomplete="off">
                            <div class="input-group-btn">
                                {{csrf_field()}}
                                <button type="button" class="btn" onclick="sendFrmRecuperate();"><i class="fa fa-arrow-right text-muted"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="help-block text-center">
                Ingrese su correo electrónico y de en el botón, le enviaremos un link a su correo para que pueda restablercerlo.
            </div>
            <div class="lockscreen-footer text-center">
                Copyright &copy; {{date('Y')}} <b><a href="" class="text-black">Almsaeed Studio</a></b><br>
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
        <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/codideepHelpers.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/formvalidation/formValidation.min.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/formvalidation/bootstrap.validation.min.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/pnotify/pnotify.custom.min.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/sweetalert/sweetalert.min.js')}}"></script>
        <script src="{{asset('assets/backoffice/viewResources/user/recuperate.js')}}?x={{env('CACHE_LAST_UPDATE')}}"></script>
    </body>
</html>
