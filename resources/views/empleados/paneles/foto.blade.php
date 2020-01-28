<div class="modal fade modal-center" id="foto"  style='display:none;' tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel" align="center">
                     {{$persona->nombresEmpleado}}  {{$persona->apellidosEmpleado}}
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
 <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR
            </button> 
               </div>
            </div>  
            </div>  
                
        <!-- Modal Body -->
      <div class="modal-body" align="center">

        <img src="data:{{$persona->tipoImagen}};base64,{{$img_e}}" class="img-rounded" alt="" width="550" height="450">
            </div>
   
      </div>
    </div>
 
</div>