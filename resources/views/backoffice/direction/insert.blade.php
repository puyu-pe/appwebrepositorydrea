<form id="frmInsertDirection" action="{{url('direccion/insertar')}}" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="form-group col-md-7">
            <label for="txtNameComplete">Nombre completo de la Dirección*</label>
            <input type="text" id="txtNameComplete" name="txtNameComplete" class="form-control" autocomplete="off">
        </div>
        <div class="form-group col-md-5">
            <label for="txtNameSort">Nombre corto*</label>
            <input type="text" id="txtNameSort" name="txtNameSort" class="form-control" autocomplete="off">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-7">
            <label for="txtNameRegion">Departamento de la dirección*</label>
            <input type="text" id="txtNameRegion" name="txtNameRegion" class="form-control" autocomplete="off">
        </div>
        <div class="form-group col-md-5">
            <label for="fileLogoExtension">Logotipo de la dirección</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-image"></i>
                </div>
                <input type="file" id="fileLogoExtension" name="fileLogoExtension" class="form-control pull-right" accept=".jpg,.png,.jpeg" style="padding: 5px;">
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="button" class="btn btn-default pull-left" data-dismiss="modal" value="Cerrar ventana">
            <input type="button" class="btn btn-primary" value="Registrar" onclick="sendFrmInsertDirection();">
        </div>
    </div>
</form>
<script src="{{asset('viewResources/direction/insert.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
