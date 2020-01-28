<div class="modal fade modal-center" id="nuevoFormDocumento"  style='display:none;' tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel">
                    NUEVO DOCUMENTO
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>  
            </div>  
                
        <!-- Modal Body -->
      <div class="modal-body">
        <form role="form" method="post" action="{{route('post.nuevo.documeno')}}"   autocomplete="off" id="formDocumentoEmpleado">
 
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Descripción</b></div>
                      <textarea class="form-control"  rows="2" id="descripcion" name="descripcion"></textarea>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <label>Documento (PDF)</label>
                       <input type="file" id="fileDocumentoEmple" name="fileDocumentoEmple" class="form-control file-loading" accept="application/pdf">
                       <div id="errorBlockDocumento" class="help-block"></div>
                    </div>
                    </div>
                    </div>
                </div>


                 <input type="hidden" class="form-control"  id="duiEmpleado" value="{{$persona->dui}}" name="duiEmpleado">
                 <input type="hidden"   id="idTipoDoc" value="" name="idTipoDoc">
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