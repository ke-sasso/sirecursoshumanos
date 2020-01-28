<div class="modal fade modal-center" id="editarInfoLaboral"  style='display:none;' tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel">
                  EDITAR INFORMACI&Oacute;N LABORAL
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>  
            </div>  
                
        <!-- Modal Body -->
      <div class="modal-body">

        <form role="form" method="post" action="{{route('data.infoLaboral.editar')}}"   autocomplete="off" id="formEditarInfoLaboral">
              <input type="hidden" name="id" id="idInfoLaboralEditar">
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Unidad</b></div>
                      <select name="idUnidad" id="idUnidadEditar" class="form-control" style="width: 100%;" >
                         <option value="" selected>Seleccione una unidad...</option>
                        @foreach($unidades as $uni)
                                <option value="{{$uni->idUnidad}}">
                                  {{$uni->nombreUnidad}}
                                </option>
                         @endforeach
                      </select>
                    </div>
                    </div>
                    </div>
                </div>
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Plaza funcional</b></div>
                          <select name="idPadre" id="idPadreEditar" style="width:600px; z-index: 110;" class="form-control chosen" >
                             <option value="" selected>Seleccione una plaza funcional...</option>
                              @foreach($plazasFun as $fun)

                                             <option value="{{$fun->idPlazaFuncional}}"> {{$fun->nombrePlaza}} - 
                                             <?php echo substr($fun->fechaInicial, 0,4); ?></option>
                                  @endforeach
                          </select>
                       
                    </div>
                    </div>
                    </div>
                </div>
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-6 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Fecha inicial</b></div>
                      <input type="date" class="form-control" id="fechaInicioEditar" name="fechaInicio" data-date-format="yyyy-mm-dd">
                    </div>
                    </div>
                     <div class="col-sm-6 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Fecha fin</b></div>
                      <input type="date" class="form-control" id="fechaFinEditar" name="fechaFin" data-date-format="yyyy-mm-dd">
                    </div>
                    </div>
                    </div>
                </div>
                    <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Observación</b></div>
                      <textarea class="form-control"  rows="2" id="observacionEditar" name="observacion"></textarea>
                    </div>
                    </div>
                    </div>
                </div>
                 <input type="hidden" class="form-control"  id="dui" name="dui" value="{{$persona->dui}}">

                                    

                      <div class="from-group" align="center">
                     
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                     <button type="submit" class="btn btn-primary btn-perspective">Guardar <i class="fa fa-check"></i></button>
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