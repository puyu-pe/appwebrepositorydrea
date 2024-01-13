@extends('frontoffice.layout')
@section('title', 'Formulario de contacto')
@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1">
            <form id="frmContact" action="{{url('general/contacto')}}" method="post">
                <div class="row">
                    <div class="form-group col-md-12">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-user-o"></i>
							</div>
							<input type="text" id="txtFullName" name="txtFullName" class="form-control pull-right" placeholder="Nombres*" value="{{Session::has('firstName') && Session::has('surName') ? Session::get('firstName') . ' ' .Session::get('surName') : ''}}" autocomplete="off">
						</div>
                    </div>
                </div>
                <div class="row">
					<div class="form-group col-md-12">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-envelope-o"></i>
							</div>
							<input type="text" id="txtEmail" name="txtEmail" class="form-control pull-right" placeholder="Correo electrónico*" value="{{Session::has('email') ? Session::get('email') : ''}}" autocomplete="off">
						</div>
                    </div>
                </div>
				<div class="row">
					<div class="form-group col-md-12">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-book"></i>
							</div>
							<input type="text" id="txtSubject" name="txtSubject" class="form-control pull-right" placeholder="Asunto*" autocomplete="off">
						</div>
                    </div>
				</div>
                <div class="row">
					<div class="form-group col-md-12">
						<textarea id="txtMessage" name="txtMessage" class="form-control" placeholder="Mensaje que desea dejar*" rows="7" onkeyup="lineJumpTextArea(this, true, true, event);" data-fv-field="txtMessage"></textarea>
                    </div>
				</div>
                <div class="row">
                    <div class="form-group col-md-12 text-right">
                        {{csrf_field()}}
                        <input type="button" class="btn btn-primary" value="Enviar datos" onclick="sendFrmContact();">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{asset('viewResources/contact/insert.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
