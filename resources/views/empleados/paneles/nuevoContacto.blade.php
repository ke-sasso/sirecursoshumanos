<div class="modal fade modal-center" id="nuevoFormContacto"  style='display:none;' tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel">
                    NUEVO CONTACTO
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>  
            </div>  
                
        <!-- Modal Body -->
      <div class="modal-body">

        <form role="form" method="post" action="{{route('post.nuevo.contactoEmp')}}"   autocomplete="off" id="formNuevoContacto">
              <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Nombre</b></div>
                      <input type="text" class="form-control" placeholder="Ingrese el nombre del pariente" id="nombre" name="nombre" autocomplete="off" >
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Parentesco</b></div>
                        <select name="idParentescoNuevo" id="idParentescoNuevo" class="form-control"></select>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-6 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Celular</b></div>
                        <input name="telMovil"  id="telMovil" type="text" class="form-control phone_sv_masking" placeholder="0000-0000" maxlength="9" autocomplete="off">
                    </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Tel&eacute;fono fijo</b></div>
                     <input name="telFijo" id="telFijo" type="text" class="form-control phone_sv_masking" placeholder="0000-0000" maxlength="9" autocomplete="off">
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Direcci&oacute;n</b></div>
                      <textarea class="form-control"  rows="2" id="direccion" name="direccion"></textarea>
                    </div>
                    </div>
                    </div>
                </div>
                 <input type="hidden" class="form-control"  id="duiEmpleado" value="{{$persona->dui}}" name="duiEmpleado">

                                    

                      <div class="from-group" align="center">
                     
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                     <button type="submit" class="btn btn-primary btn-perspective">Registrar <i class="fa fa-check"></i></button>
                      </div>      
            </form>
            </div>
                        
         

        <!-- End Modal Body -->
        <!-- Modal Footer -->
        <div class="modal-footer">                        
            <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR
            </button>                
        </div>
      </div>
    </div>
 
</div>