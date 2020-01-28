@extends('master')

@section('css')
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
    	<strong>Función {{ $funcion->literal }}</strong><br>
    	{{ $funcion->nombreFuncion }}
	</div>
  </div>

  <label style="display: inline-block;margin-bottom: 1%;"><strong>TAREAS</strong></label>
  <button style="display: inline-block; margin-right: 1%;margin-bottom: 1%; color: white;" type="button" class="btn btn-primary btn-xs btn-perspective" title="Agregar Tarea" onclick="nuevaTarea();" data-toggle="modal" data-target="#editarTarea"><i class="fa fa-plus" aria-hidden="true"></i>
  </button>

 <div class="table-responsive">
 	<table class="table table-striped table-hover">
 		<thead class="the-box dark full">
 			<th>TAREA</th>
 			<th width="85%">DESCRIPCIÓN</th>
 			<th>-</th>
 			<th>-</th>
      <th>-</th>

 		</thead>
 		<tbody>
 		@foreach($funcion->tareas()->where('activo',1)->orderBy('numero','asc')->get() as $tarea)
 			<tr>
 				<td>{{$loop->iteration}}</td>
 				<td>{{$tarea->nombreTarea}}</td>
 				<td><a class="btn btn-xs btn-success btn-perspective" title="Editar Tarea" onclick="editarTarea('{{$tarea->idTarea}}','{{trim($tarea->nombreTarea)}}');" data-toggle="modal" data-target="#editarTarea"><i class="fa fa-pencil"></i></a></td>
 				<td><a href="{{route('tarea.detalle',['idTarea' => Crypt::encrypt($tarea->idTarea)])}}" class="btn btn-xs btn-success btn-perspective" title="Mostrar Tarea"><i class="fa fa-eye"></i></a></td>
        <td><a class="btn btn-danger btn-xs btn-perspective" title="Eliminar Tarea" onClick="return confirmar('{{Crypt::encrypt($tarea->idTarea)}}');"><i class="fa fa-times"></i> </a></td>
 			</tr>
 		@endforeach

 		</tbody>
 	</table>

 </div>
</div>

<div class="modal fade modal-center" id="editarTarea" name="editarTarea"  style='display:none;' tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel">
                    EDITAR TAREA
                </h4>
                <h4 class="modal-title" id="frmModalLabel2">
                    NUEVA TAREA
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

              <form role="form" method="post" action="{{route('store.tarea')}}"   autocomplete="off" id="formModal">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label><b>Nombre:</b></label>
                        <textarea name="nombreTarea" id="nombreTarea" class="form-control" rows="3"></textarea>
                        <input type="hidden" name="idTarea" id="idTarea">
                        <input type="hidden" name="editandoTarea" id="editandoTarea">
                        <input type="hidden" name="idFuncion" id="idFuncion" value="{{$funcion->idFuncion}}">
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
@endsection

@section('js')
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
@if(Session::has('msnExito'))
 <script type="text/javascript">
   alertify.success('¡EXITO!¡LA TAREA FUE ELIMINADA CON EXITO!');
  {{Session::forget('msnExito')}}
  table.ajax.reload();
 </script>
@endif
<script type="text/javascript">

function nuevaTarea(){

  //seteamos los valores
  $('#nombreTarea').val("");
  $('#idTarea').val("");
  $('#editandoTarea').val("0");

  //cambiamos el encabezado
  document.getElementById('frmModalLabel').hidden = true;
  document.getElementById('frmModalLabel2').hidden = false;

}

function editarTarea($idTarea,$nombreTarea){
  //seteamos las variables
  $('#nombreTarea').val("");
  $('#idTarea').val("");
  $('#editandoTarea').val("");

  //asignamos los valores
  $('#idTarea').val($idTarea);
  $('#nombreTarea').val($nombreTarea);
  $('#editandoTarea').val("1");

  //cambiamos el encabezado
  document.getElementById('frmModalLabel').hidden = false;
  document.getElementById('frmModalLabel2').hidden = true;
}

function confirmar(id){

  alertify.confirm('NECESITA CONFIRMACION',"Esta seguro que desea eliminar la tarea?",
  function(){
    window.location = "{{url('cat/plazaFunc/funcion/eliminarTarea')}}"+'/'+id;
  },
  function(){
    alertify.error('Cancel');

  });
  return false;
}

$( document ).ready(function() {

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

                if($('#editandoTarea').val()=="1"){
                    alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Tarea Actualizada de forma exitosa!</p></strong>",function(){
                    var obj =  JSON.parse(response);
                    location.reload();
                    $("#boton1" ).trigger( "click" );
                    });
                }else{
                  alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Tarea Guardada de forma exitosa!</p></strong>",function(){
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

              if($('#editandoTarea').val()=="1"){
                $('body').modalmanager('loading');
                alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo actualizar la Tarea!</p></strong>");

              }else{
                $('body').modalmanager('loading');
                alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo Guardar la Tarea!</p></strong>");
              }

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