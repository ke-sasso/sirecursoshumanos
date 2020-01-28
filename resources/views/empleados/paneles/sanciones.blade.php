<div class="modal fade modal-center" id="infoSanciones"  style='display:none;' tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel">
                    EDITAR INFORMACI&Oacute;N
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>  
            </div>  
                
        <!-- Modal Body -->
      <div class="modal-body">

        <form role="form" method="post" action="{{route('post.editar.sancionEmp')}}"   autocomplete="off" id="formSanciones">
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Tipo de sanci&oacute;n</b></div>
                        <select name="idTipoSancion" id="idTipoSancion" class="form-control"></select>
                    </div>
                    </div>
                    </div>
                </div>
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-6 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Fecha</b></div>

                      <input type="text" name="fecha"  id="fecha" title="Ejemplo: 2017-01-31" class="form-control date_masking2 datepicker" placeholder="yyyy-mm-dd"  data-date-format="yyyy-mm-dd" maxlength="10" autocomplete="off" > 
                    </div>
                    </div>
                     <div class="col-sm-6 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Fecha prescripci&oacute;n</b></div>
                      <input type="text" name="fechaPrescripcion"  id="fechaPrescripcion" title="Ejemplo: 2017-01-31" class="form-control date_masking2 datepicker" placeholder="yyyy-mm-dd"  data-date-format="yyyy-mm-dd" maxlength="10" autocomplete="off" > 
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Motivo</b></div>
                      <textarea class="form-control"  rows="2" id="motivo" name="motivo"></textarea>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Descripci&oacute;n</b></div>
                      <textarea class="form-control"  rows="4" id="descripcion" name="descripcion"></textarea>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pdfAmonestacion">Pdf Escaneado (opcional)</label>
                    <input type="file" id="pdfAmonestacion" name="pdfAmonestacion"></input>
                </div>
                 <input type="hidden" class="form-control"  id="idSancion" name="idSancion">

                                    

                      <div class="from-group" align="center">
                     
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                     <button type="submit" class="btn btn-primary btn-perspective">Actualizar <i class="fa fa-check"></i></button>
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
