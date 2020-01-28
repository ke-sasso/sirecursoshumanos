@extends('master')

@section('css')
{{-- SElECTIZE JS --}}
{!! Html::style('plugins/selectize-js/dist/css/selectize.bootstrap3.css') !!}
<style type="text/css">
    td.details-control {
        background: url("{{ asset('/plugins/datatable/images/details_open.png') }}") no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url("{{ asset('/plugins/datatable/images/details_close.png') }}") no-repeat center center;
    }

</style>
@endsection

@section('contenido')
<div class="panel-body">
  <div class="row">
 	<div class="alert alert-info square fade in alert-dismissable">
    	<strong>Tarea</strong><br>
    	{{ $tarea->nombreTarea }}
	</div>
  </div>

  <div class="table-responsive">
  	<table class="table table-th-block" width="100%">
  		<thead>
  			<tr style="background-color:#C9DFE8">
            <th style="width: 85%;text-align: center;" >CRITERIOS DE DESEMPEÑO <button style="display: inline-block; margin-left: 1%; color: white;" type="button" class="btn btn-primary btn-xs btn-perspective" title="Nuevo Criterio de Desempeño" onclick="nuevoCriterio('{{$tarea->idTarea}}');" data-toggle="modal" data-target="#editarCriterio"><i class="fa fa-plus" aria-hidden="true"></i>Nuevo</button></th>
            <th>-</th>
            <th>-</th>
        </tr>
  		</thead>
  		<tbody>
  		@foreach($tarea->desempenios()->where('activo',1)->orderBy('numero','asc')->get() as $dese)
  			<tr>
  				<td>{{ $dese->nombreDesempenio }}</td>
  				<td><a class="btn btn-xs btn-success btn-perspective" title="Editar Criterio de Desempeño" onclick="editarCriterio('{{$dese->idDesempenio}}','{{trim($dese->nombreDesempenio)}}');" data-toggle="modal" data-target="#editarCriterio"><i class="fa fa-pencil"></i></a></td>
          <td><a class="btn btn-danger btn-xs btn-perspective" title="Eliminar Desempeño" onClick="return confirmarDesempenio('{{Crypt::encrypt($dese->idDesempenio)}}');"><i class="fa fa-times"></i> </a></td>
  			</tr>

  		@endforeach

  		</tbody>
  	</table>

  </div>

  <br>

  <div class="table-responsive">
  	<table class="table table-th-block" width="100%">
  		<thead>
  			<tr style="background-color:#C9DFE8">
          <th style="width: 85%;text-align: center;" >PRODUCTOS <button style="display: inline-block; margin-left: 1%; color: white;" type="button" class="btn btn-primary btn-xs btn-perspective" title="Nuevo Producto" onclick="nuevoProducto('{{$tarea->idTarea}}');" data-toggle="modal" data-target="#editarProducto"><i class="fa fa-plus" aria-hidden="true"></i>Nuevo</button></th>
          <th>-</th>
          <th>-</th>
        </tr>
  		</thead>
  		<tbody>
  		@foreach($tarea->productos()->where('activo',1)->orderBy('numero','asc')->get() as $producto)
  			<tr>
  				<td>{{ $producto->nombreProducto }}</td>
  				<td><a class="btn btn-xs btn-success btn-perspective" title="Editar Producto" onclick="editarProducto('{{$producto->idProducto}}','{{trim($producto->nombreProducto)}}');" data-toggle="modal" data-target="#editarProducto"><i class="fa fa-pencil"></i></a></td>
          <td><a class="btn btn-danger btn-xs btn-perspective" title="Eliminar Producto" onClick="return confirmarProducto('{{Crypt::encrypt($producto->idProducto)}}');"><i class="fa fa-times"></i> </a></td>
  			</tr>

  		@endforeach

  		</tbody>
  	</table>

  </div>

  <br>

  <div class="table-responsive">
  	<table class="table table-th-block" width="100%">
  		<thead>
  			<tr style="background-color:#C9DFE8">

                <th style="width: 85%;text-align: center;" >CONOCIMIENTOS <button style="display: inline-block; margin-left: 1%; color: white;" type="button" class="btn btn-primary btn-xs btn-perspective" title="Nuevo Conocimiento" onclick="nuevoConocimiento('{{$tarea->idTarea}}');" data-toggle="modal" data-target="#editarConocimiento"><i class="fa fa-plus" aria-hidden="true"></i>Nuevo</button></th>
                <th>-</th>
                <th>-</th>

  		</thead>
  		<tbody>
  		@foreach($tarea->conocimientos()->where('activo',1)->orderBy('numero','asc')->get() as $conocimiento)
  			<tr>

  				<td>{{ $conocimiento->nombreConocimiento }}</td>
          <td>
            <a href="{{route('editar.conocimiento',['idConocimiento' => Crypt::encrypt($conocimiento->idConocimiento)])}}" class="btn btn-xs btn-success btn-perspective" title="Editar Conocimiento"><i class="fa fa-pencil" aria-hidden="true"></i></a>
          </td>
          <td><a class="btn btn-danger btn-xs btn-perspective" title="Eliminar Conocimiento" onClick="return confirmarConocimiento('{{Crypt::encrypt($conocimiento->idConocimiento)}}');"><i class="fa fa-times"></i> </a></td>
  			</tr>

  		@endforeach

  		</tbody>
  	</table>

  </div>

  <br>

  <div class="table-responsive">
  	<table class="table table-th-block" width="100%">
  		<thead>
  			<tr style="background-color:#C9DFE8">

                <th style="width: 85%;text-align: center;" >ACTITUDES <button style="display: inline-block; margin-left: 1%; color: white;" type="button" class="btn btn-primary btn-xs btn-perspective" title="Nueva Actitud" onclick="nuevaActitud('{{$tarea->idTarea}}');" data-toggle="modal" data-target="#editarActitud"><i class="fa fa-plus" aria-hidden="true"></i>Nuevo</button></th>
                <th>-</th>
                <th>-</th>

  		</thead>
  		<tbody>
  		@foreach($tarea->actitudes()->where('activo',1)->orderBy('numero','asc')->get() as $actitud)
  			<tr>

  				<td>{{ $actitud->nombreActitud }}</td>
          <td>
            <a href="{{route('editar.actitud',['idActitud' => Crypt::encrypt($actitud->idActitud)])}}" class="btn btn-xs btn-success btn-perspective" title="Editar Actitud"><i class="fa fa-pencil" aria-hidden="true"></i></a>
          </td>
          <td><a class="btn btn-danger btn-xs btn-perspective" title="Eliminar Actitud" onClick="return confirmarActitud('{{Crypt::encrypt($actitud->idActitud)}}');"><i class="fa fa-times"></i> </a></td>
  			</tr>

  		@endforeach

  		</tbody>
  	</table>

  </div>

</div>

<!--PANEL PARA EDITAR/CREAR CRITERIO DE DESEMPEÑO -->
<div class="modal fade modal-center" id="editarCriterio" name="editarCriterio"  style='display:none;' tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel">
                    EDITAR CRITERIO DE DESEMPEÑO
                </h4>
                <h4 class="modal-title" id="frmModalLabel2">
                    NUEVO CRITERIO DE DESEMPEÑO
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

              <form role="form" method="post" action="{{route('store.criterio')}}"   autocomplete="off" id="formModal">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label><b>Nombre:</b></label>
                        <textarea name="nombreCriterio" id="nombreCriterio" class="form-control" rows="3"></textarea>
                        <input type="hidden" name="idCriterio" id="idCriterio">
                        <input type="hidden" name="idTareaCriterio" id="idTareaCriterio">
                        <input type="hidden" name="editandoCriterio" id="editandoCriterio">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">

                   <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                      <button type="submit" class="btn btn-primary btn-perspective">Guardar<i></i></button>
                  </div>
              </form>
            </div><!-- End Modal Body -->
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="boton1">CERRAR
                </button>
            </div>
      </div>
    </div>

</div>

<!--PANEL PARA EDITAR/CREAR PRODUCTOS -->
<div class="modal fade modal-center" id="editarProducto" name="editarProducto"  style='display:none;' tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel3">
                    EDITAR PRODUCTO
                </h4>
                <h4 class="modal-title" id="frmModalLabel4">
                    NUEVO PRODUCTO
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

              <form role="form" method="post" action="{{route('store.producto')}}"   autocomplete="off" id="formModal2">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label><b>Nombre:</b></label>
                        <textarea name="nombreProducto" id="nombreProducto" class="form-control" rows="3"></textarea>
                        <input type="hidden" name="idProducto" id="idProducto">
                        <input type="hidden" name="idTareaProducto" id="idTareaProducto">
                        <input type="hidden" name="editandoProducto" id="editandoProducto">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">

                   <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                      <button type="submit" class="btn btn-primary btn-perspective">Guardar<i></i></button>
                  </div>
              </form>
            </div><!-- End Modal Body -->
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="boton2">CERRAR
                </button>
            </div>
      </div>
    </div>

</div>

<!--PANEL PARA EDITAR/CREAR CONOCIMIENTOS -->
<div class="modal fade modal-center" id="editarConocimiento" name="editarConocimiento"  style='display:none;' role="dialog" ><!-- con tabindex no funciona el input de busqueda en el select-->
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel6">
                    NUEVO CONOCIMIENTO
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

              <form role="form" method="post" action="{{route('store.conocimiento')}}"   autocomplete="off" id="formModal3">
                  <div class="form-group" >
                    <div class="row">
                      <div class="col-sm-12 col-md-12">
                          <label style="display: inline-block;margin-bottom: 2%;">Tipo de Conocimiento:</label>
                          <button style="display: inline-block; margin-right: 1%;margin-bottom: 2%; color: white;" type="button" class="btn btn-primary btn-xs btn-perspective" title="Agregar Tipo de Conocimiento" data-toggle="modal" data-target="#nuevoTipoConocimiento"><i class="fa fa-plus" aria-hidden="true"></i></button>
                          <select id="tipoConocimiento" name="tipoConocimiento" class="form-control select_tipo js-states" style="width:100%;" onchange="cambiarNombreConocimiento();"><option></option></select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label><b>Nombre:</b></label>
                        <textarea name="nombreConocimiento" id="nombreConocimiento" class="form-control" rows="3" readonly="true"></textarea>
                        <input type="hidden" name="idConocimiento" id="idConocimiento">
                        <input type="hidden" name="idTareaConocimiento" id="idTareaConocimiento">
                        <input type="hidden" name="editandoConocimiento" id="editandoConocimiento">
                      </div>
                    </div>
                  </div>
                  <div class="form-group" >
                    <div class="row">
                      <div class="col-sm-6 col-md-6">
                        <div class="input-group ">
                          <div class="input-group-addon"><b>Nivel</b></div>
                          <select name="nivel" id="nivel" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach($niveles as $nivel)
                            <option value="{{$nivel->idNivel}}">{{$nivel->nombreNivel}}</option>
                            @endforeach

                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">

                   <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                      <button type="submit" class="btn btn-primary btn-perspective">Guardar<i></i></button>
                  </div>
              </form>
            </div><!-- End Modal Body -->
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="boton3">CERRAR
                </button>
            </div>
      </div>
    </div>

</div>

<!--PANEL PARA EDITAR/CREAR ACTITUDES -->
<div class="modal fade modal-center" id="editarActitud" name="editarActitud"  style='display:none;' role="dialog" ><!-- con tabindex no funciona el input de busqueda en el select-->
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel8">
                    NUEVA ACTITUD
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

              <form role="form" method="post" action="{{route('store.actitud')}}"   autocomplete="off" id="formModal4">
                  <div class="form-group" >
                    <div class="row">
                      <div class="col-sm-12 col-md-12">
                          <label style="display: inline-block;margin-bottom: 2%;">Tipo de Actitud:</label>
                          <a href="{{route('insertar.tipoActitud')}}" target="_blank"><button style="display: inline-block; margin-right: 1%;margin-bottom: 2%; color: white;" type="button" class="btn btn-primary btn-xs btn-perspective" title="Agregar Tipo de Actitud"><i class="fa fa-plus" aria-hidden="true"></i></button></a>
                          <select id="tipoActitud" name="tipoActitud" class="form-control select_tipoA js-states2" style="width:100%;" onclick="hacerSelectizeTA();" onchange="cambiarNombreActitud();"><option></option></select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label><b>Nombre:</b></label>
                        <textarea name="nombreActitud" id="nombreActitud" class="form-control" rows="3" readonly="true"></textarea>
                        <input type="hidden" name="idActitud" id="idActitud">
                        <input type="hidden" name="idTareaActitud" id="idTareaActitud">
                        <input type="hidden" name="editandoActitud" id="editandoActitud">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">

                   <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                      <button type="submit" class="btn btn-primary btn-perspective">Guardar<i></i></button>
                  </div>
              </form>
            </div><!-- End Modal Body -->
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="boton4">CERRAR
                </button>
            </div>
      </div>
    </div>

</div>

<!--PANEL PARA NUEVO TIPO DE CONOCIMIENTO -->
<div class="modal fade modal-center" id="nuevoTipoConocimiento" name="nuevoTipoConocimiento"  style='display:none;' tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="">
                    NUEVO TIPO DE CONOCIMIENTO
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

              <form role="form" method="post" action="{{route('store.tipoConocimiento')}}"   autocomplete="off" id="formModal5">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label><b>Nombre:</b></label>
                        <textarea name="nombreTipoConocimiento" id="nombreTipoConocimiento" class="form-control text-uppercase" rows="3"></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">

                   <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                      <button type="submit" class="btn btn-primary btn-perspective">Guardar<i></i></button>
                  </div>
              </form>
            </div><!-- End Modal Body -->
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="boton5">CERRAR
                </button>
            </div>
      </div>
    </div>

</div>
@endsection

@section('js')
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
{{-- SElECTIZE JS --}}
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
@if(Session::has('msnExitoD'))
 <script type="text/javascript">
   alertify.success('¡EXITO!¡EL CRITERIO DE DESEMPEÑO FUE ELIMINADO CON EXITO!');
  {{Session::forget('msnExitoD')}}
 </script>
@endif
@if(Session::has('msnExitoP'))
 <script type="text/javascript">
   alertify.success('¡EXITO!¡EL PRODUCTO FUE ELIMINADO CON EXITO!');
  {{Session::forget('msnExitoP')}}
 </script>
@endif
@if(Session::has('msnExitoC'))
 <script type="text/javascript">
   alertify.success('¡EXITO!¡EL CONOCIMIENTO FUE ELIMINADO CON EXITO!');
  {{Session::forget('msnExitoC')}}
 </script>
@endif
@if(Session::has('msnExitoA'))
 <script type="text/javascript">
   alertify.success('¡EXITO!¡LA ACTITUD FUE ELIMINADA CON EXITO!');
  {{Session::forget('msnExitoA')}}
 </script>
@endif
<script type="text/javascript">

function editarCriterio($idCriterio,$nombreCriterio){
  //seteamos las variables
  $('#nombreCriterio').val("");
  $('#idCriterio').val("");
  $('#idTareaCriterio').val("");
  $('#editandoCriterio').val("");

  //asignamos los valores
  $('#idCriterio').val($idCriterio);
  $('#nombreCriterio').val($nombreCriterio);
  $('#editandoCriterio').val("1");//valor para decir que estamos editando
  //cambiamos el encabezado
  document.getElementById('frmModalLabel').hidden = false;
  document.getElementById('frmModalLabel2').hidden = true;
}

function nuevoCriterio($idTareaCriterio){
  //seteamos las variables
  $('#nombreCriterio').val("");
  $('#idCriterio').val("");
  $('#idTareaCriterio').val("");
  $('#editandoCriterio').val("");

  //asignamos los valores
  $('#idTareaCriterio').val($idTareaCriterio);//para saber a que tarea pertenecerá
  $('#editandoCriterio').val("0");//valor para decir que estamos creando un nuevo criterio
  //cambiamos el encabezado
  document.getElementById('frmModalLabel').hidden = true;
  document.getElementById('frmModalLabel2').hidden = false;

}

function editarProducto($idProducto,$nombreProducto){
  //seteamos las variables
  $('#nombreProducto').val("");
  $('#idProducto').val("");
  $('#idTareaProducto').val("");
  $('#editandoProducto').val("");

  //asignamos los valores
  $('#idProducto').val($idProducto);
  $('#nombreProducto').val($nombreProducto);
  $('#editandoProducto').val("1");//valor para decir que estamos editando
  //cambiamos el encabezado
  document.getElementById('frmModalLabel3').hidden = false;
  document.getElementById('frmModalLabel4').hidden = true;
}

function nuevoProducto($idTareaProducto){
  //seteamos las variables
  $('#nombreProducto').val("");
  $('#idProducto').val("");
  $('#idTareaProducto').val("");
  $('#editandoProducto').val("");

  //asignamos los valores
  $('#idTareaProducto').val($idTareaProducto);//para saber a que tarea pertenecerá
  $('#editandoProducto').val("0");//valor para decir que estamos creando un nuevo producto
  //cambiamos el encabezado
  document.getElementById('frmModalLabel3').hidden = true;
  document.getElementById('frmModalLabel4').hidden = false;

}

function nuevoConocimiento($idTareaConocimiento){
  //seteamos las variables
  $('#nombreConocimiento').val("");
  $('#idConocimiento').val("");
  $('#idTareaConocimiento').val("");
  $('#editandoConocimiento').val("");
  $('#tipoConocimiento').val("").trigger('change');
  $('#nivel').val("");

  //asignamos los valores
  $('#idTareaConocimiento').val($idTareaConocimiento);//para saber a que tarea pertenecerá

}

function nuevaActitud($idTareaActitud){
  //seteamos las variables
  $('#nombreActitud').val("");
  $('#idActitud').val("");
  $('#idTareaActitud').val("");
  $('#editandoActitud').val("");
  $('#tipoActitud').val("").trigger('change');

  //asignamos los valores
  $('#idTareaActitud').val($idTareaActitud);//para saber a que tarea pertenecerá

}

function cambiarNombreConocimiento(){
  var nombreConocimiento = $('#nombreConocimiento').val();
  var nuevoNombreConocimiento = $('#tipoConocimiento option:selected').text();

  //comparamos los strings
  var comparaStrings = nuevoNombreConocimiento.toUpperCase() === nombreConocimiento.toUpperCase();

  if(!comparaStrings){
    //asignamos el nuevo nombre
    $('#nombreConocimiento').val(nuevoNombreConocimiento);
  }

}

function cambiarNombreActitud(){
  var nombreActitud = $('#nombreActitud').val();
  var nuevoNombreActitud = $('#tipoActitud option:selected').text();

  //comparamos los strings
  var comparaStrings = nuevoNombreActitud.toUpperCase() === nombreActitud.toUpperCase();

  if(!comparaStrings){
    //asignamos el nuevo nombre
    $('#nombreActitud').val(nuevoNombreActitud);
  }

}

function confirmarDesempenio(id){

  alertify.confirm('NECESITA CONFIRMACION',"Esta seguro que desea eliminar el Criterio de desempeño?",
  function(){
    window.location = "{{url('cat/plazaFunc/funcion/eliminarDesempenio')}}"+'/'+id;
  },
  function(){
    alertify.error('Cancel');

  });
  return false;
}

function confirmarProducto(id){

  alertify.confirm('NECESITA CONFIRMACION',"Esta seguro que desea eliminar el producto?",
  function(){
    window.location = "{{url('cat/plazaFunc/funcion/eliminarProducto')}}"+'/'+id;
  },
  function(){
    alertify.error('Cancel');

  });
  return false;
}

function confirmarConocimiento(id){

  alertify.confirm('NECESITA CONFIRMACION',"Esta seguro que desea eliminar el conocimiento?",
  function(){
    window.location = "{{url('cat/plazaFunc/funcion/eliminarConocimiento')}}"+'/'+id;
  },
  function(){
    alertify.error('Cancel');

  });
  return false;
}

function confirmarActitud(id){

  alertify.confirm('NECESITA CONFIRMACION',"Esta seguro que desea eliminar la actitud?",
  function(){
    window.location = "{{url('cat/plazaFunc/funcion/eliminarActitud')}}"+'/'+id;
  },
  function(){
    alertify.error('Cancel');

  });
  return false;
}

$( document ).ready(function(){

  /*Funcion para buscar el TipoConocimiento*/
  var tipoConocimiento = $('#tipoConocimiento').selectize({
    valueField: 'idTipoConocimiento',
    labelField: 'nombreTipoConocimiento',
    searchField:'nombreTipoConocimiento',
    maxOptions: 10,
    options: [],
    create: false,
    render: {
        option: function(item, escape) {
            return '<div>' +escape(item.nombreTipoConocimiento)+'</div>';
          }
    },
    load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: "{{ route('find.tipoConocimiento') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    q: query
                },
                error: function() {
                    callback();
                },
                success: function(res) {
                    callback(res.data);
                }
            });
    }
  });

  /*Funcion para buscar el tipo de Actitud*/
  var tipoActitud = $('#tipoActitud').selectize({
    valueField: 'idTipoActitud',
    labelField: 'nombreTipoActitud',
    searchField:'nombreTipoActitud',
    maxOptions: 10,
    options: [],
    create: false,
    render: {
        option: function(item, escape) {
            return '<div>' +escape(item.nombreTipoActitud)+'</div>';
          }
    },
    load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: "{{ route('find.tipoActitud') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    q: query
                },
                error: function() {
                    callback();
                },
                success: function(res) {
                    callback(res.data);
                }
            });
    }
  });

  $('#formModal').submit(function(e){
      var formObj = $(this);
      var formURL = formObj.attr("action");
      var formData = new FormData(this);
      $.ajax({
        data: formData,
        url: formURL,
        type: 'post',
        mimeType:"multipart/form-data",
          contentType: false,
            cache: false,
            processData:false,
        beforeSend: function() {
          $('body').modalmanager('loading');
        },
            success:  function (response){
              $('body').modalmanager('loading');
              if(isJson(response)){

                if($('#editandoCriterio').val()=="1"){//cuando estamos editando
                  alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Criterio de Desempeño Actualizado de forma exitosa!</p></strong>",function(){
                  var obj =  JSON.parse(response);
                  location.reload();
                  $("#boton1" ).trigger( "click" );
                  });
                }else{//cuando estamos creando un criterio nuevo
                  alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Criterio de Desempeño Guardado de forma exitosa!</p></strong>",function(){
                  var obj =  JSON.parse(response);
                  location.reload();
                  $("#boton1" ).trigger( "click" );
                  });
                }


              }else{
                alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('body').modalmanager('loading');
                if($('#editandoCriterio').val()=="1"){//cuando estamos editando
                  alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo actualizar el Criterio de Desempeño!</p></strong>");
                }else{//cuando estamos creando un criterio nuevo
                  alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo guardar el Criterio de Desempeño!</p></strong>");
                }

                console.log("Error en peticion AJAX!");
            }
      });
      e.preventDefault(); //Prevent Default action.

  });

  $('#formModal2').submit(function(e){
      var formObj = $(this);
      var formURL = formObj.attr("action");
      var formData = new FormData(this);
      $.ajax({
        data: formData,
        url: formURL,
        type: 'post',
        mimeType:"multipart/form-data",
          contentType: false,
            cache: false,
            processData:false,
        beforeSend: function() {
          $('body').modalmanager('loading');
        },
            success:  function (response){
              $('body').modalmanager('loading');
              if(isJson(response)){

                if($('#editandoProducto').val()=="1"){//cuando estamos editando
                  alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Producto  Actualizado de forma exitosa!</p></strong>",function(){
                  var obj =  JSON.parse(response);
                  location.reload();
                  $("#boton2" ).trigger( "click" );
                  });
                }else{//cuando estamos creando un criterio nuevo
                  alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Producto Guardado de forma exitosa!</p></strong>",function(){
                  var obj =  JSON.parse(response);
                  location.reload();
                  $("#boton2" ).trigger( "click" );
                  });
                }


              }else{
                alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('body').modalmanager('loading');
                if($('#editandoProducto').val()=="1"){//cuando estamos editando
                  alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo actualizar el Producto!</p></strong>");
                }else{//cuando estamos creando un criterio nuevo
                  alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo guardar el Producto!</p></strong>");
                }

                console.log("Error en peticion AJAX!");
            }
      });
      e.preventDefault(); //Prevent Default action.

  });

  $('#formModal3').submit(function(e){
      var formObj = $(this);
      var formURL = formObj.attr("action");
      var formData = new FormData(this);
      $.ajax({
        data: formData,
        url: formURL,
        type: 'post',
        mimeType:"multipart/form-data",
          contentType: false,
            cache: false,
            processData:false,
        beforeSend: function() {
          $('body').modalmanager('loading');
        },
            success:  function (response){
              $('body').modalmanager('loading');
              if(isJson(response)){

                  alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Conocimiento Guardado de forma exitosa!</p></strong>",function(){
                  var obj =  JSON.parse(response);
                  location.reload();
                  $("#boton3" ).trigger( "click" );
                  });

              }else{
                alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('body').modalmanager('loading');

                  alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo guardar el Conocimiento!</p></strong>");

                console.log("Error en peticion AJAX!");
            }
      });
      e.preventDefault(); //Prevent Default action.

  });


  $('#formModal4').submit(function(e){
      var formObj = $(this);
      var formURL = formObj.attr("action");
      var formData = new FormData(this);
      $.ajax({
        data: formData,
        url: formURL,
        type: 'post',
        mimeType:"multipart/form-data",
          contentType: false,
            cache: false,
            processData:false,
        beforeSend: function() {
          $('body').modalmanager('loading');
        },
            success:  function (response){
              $('body').modalmanager('loading');
              if(isJson(response)){

                  alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Actitud Guardada de forma exitosa!</p></strong>",function(){
                  var obj =  JSON.parse(response);
                  location.reload();
                  $("#boton4" ).trigger( "click" );
                  });

              }else{
                alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('body').modalmanager('loading');

                  alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo guardar la Actitud!</p></strong>");

                console.log("Error en peticion AJAX!");
            }
      });
      e.preventDefault(); //Prevent Default action.

  });

  $('#formModal5').submit(function(e){
      var formObj = $(this);
      var formURL = formObj.attr("action");
      var formData = new FormData(this);
      $.ajax({
        data: formData,
        url: formURL,
        type: 'post',
        mimeType:"multipart/form-data",
          contentType: false,
            cache: false,
            processData:false,
        beforeSend: function() {
          $('body').modalmanager('loading');
        },
            success:  function (response){
              $('body').modalmanager('loading');
              if(isJson(response)){

                  alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Tipo de Conocimiento Guardado de forma exitosa!</p></strong>",function(){
                  var obj =  JSON.parse(response);
                  $("#boton5" ).trigger( "click" );
                  });

              }else{
                alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('body').modalmanager('loading');

                alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo guardar el Tipo de Conocimiento!</p></strong>");

                console.log("Error en peticion AJAX!");
            }
      });
      e.preventDefault(); //Prevent Default action.

  });

function isJson(str) {
try {
    JSON.parse(str);
} catch (e) {
    return false;
}
return true;
}

});
</script>
@endsection