<div class="modal fade modal-center" id="nuevoEstudio"  style='display:none;' tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel">
                    NUEVO ESTUDIO
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>  
            </div>  
                
        <!-- Modal Body -->
      <div class="modal-body">

        <form role="form" method="post" action="{{route('post.nuevo.estudioEmp')}}"   autocomplete="off" id="formNuevoEstudio">
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Título</b></div>
                      <input type="text" class="form-control" id="titulo" placeholder="Título que obtuvo el empleado" name="titulo" autocomplete="off" >
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Tipo de estudio</b></div>
                        <select name="idTipoNuevo" id="idTipoNuevo" class="form-control"></select>
                    </div>
                    </div>
                     <div class="col-sm-12 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Año</b></div>
                        <input type="number" min="1900" step="1" max="9999" placeholder="Ejemplo: 2015" maxlength="4" class="form-control" id="anno" name="anno" autocomplete="off" >
                    </div>
                    </div>
                    </div>
                </div>
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-6 col-md-6">
                 
                      <div class="input-group-addon"><b>Instituci&oacute;n</b></div>
                        <select name="idInstitucionNuevo"  placeholder="Ingrese el nombre de la institución de estudio" id="idInstitucionNuevo" style="width: 100%;"  class="form-control"></select>
               
                    </div>
                    <div class="col-sm-6 col-md-6">
                    <label>Documento (PDF)</label>
                    <input type="file" id="fileEstudiosNew" name="fileEstudiosNew" class="form-control file-loading" accept="application/pdf">
                    <div id="errorBlockNew" class="help-block"></div>
                  </div>
                    </div>
                </div>
            
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Lugar</b></div>
                      <textarea class="form-control"  placeholder="Lugar donde realizó el título" rows="2" id="lugar" name="lugar"></textarea>
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