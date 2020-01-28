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
    	<strong>PLAZA FUNCIONAL <br>{{$plazaFuncional->nombrePlaza}}</strong><br>
	</div>
 </div>
  <label style="display: inline-block;"><strong>FUNCIONES</strong></label>
  <button style="display: inline-block; margin-right: 1%; color: white;" type="button" class="btn btn-primary btn-xs btn-perspective" title="Agregar Función" onclick="nuevaFuncion();" data-toggle="modal" data-target="#nuevaFuncion"><i class="fa fa-plus" aria-hidden="true"></i>
  </button>

 <div class="table-responsive">
 	<table class="table table-striped table-hover"  id="dt-funciones" style="font-size:12.5px;" width="100%">
 	  <thead class="the-box dark full">
		<tr>
			<th>FUNCIÓN</th>
            <th width="85%">DESCRIPCIÓN</th>
            <th>-</th>
            <th>-</th>
            <th>-</th>
		</tr>
      </thead>
      <tbody>
      	@foreach($plazaFuncional->funciones()->where('activo',1)->orderBy('literal','asc')->get() as $funcion)
      	<tr>
      		<td>Función {{$funcion->literal}}</td>
      		<td>{{$funcion->nombreFuncion}}</td>
      		<td><a class="btn btn-xs btn-success btn-perspective" title="Editar Función" onclick="editarFuncion('{{$funcion->idFuncion}}','{{trim($funcion->nombreFuncion)}}','{{$funcion->activo}}','{{$funcion->literal}}');" data-toggle="modal" data-target="#editarFuncion"><i class="fa fa-pencil"></i></a></td>
      		<td><a href="{{route('funcion.tareas',['idFuncion' => Crypt::encrypt($funcion->idFuncion)])}}" class="btn btn-xs btn-success btn-perspective" title="Mostrar Tareas"><i class="fa fa-eye"></i></a></td>
          <td><a class="btn btn-danger btn-xs btn-perspective" title="Eliminar Función" onClick="return confirmar('{{Crypt::encrypt($funcion->idFuncion)}}');"><i class="fa fa-times"></i> </a></td>
      	</tr>

      	@endforeach

      </tbody>
 	</table>

 </div>
</div>

<div class="modal fade modal-center" id="editarFuncion" name="editarFuncion"  style='display:none;' tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel">
                    EDITAR FUNCIÓN
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

              <form role="form" method="post" action="{{route('editar.funcion')}}"   autocomplete="off" id="formModal">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label><b>Nombre:</b></label>
                        <textarea name="nombreFuncion" id="nombreFuncion" class="form-control" rows="3"></textarea>
                        <input type="hidden" name="idFuncion" id="idFuncion">
                      </div>
                    </div>
                  </div>
                  <div class="form-group" >
                    <div class="row">
                      <div class="col-sm-6 col-md-6 col-lg-6">
                        <label><b>Literal:</b></label>
                        <input name="literal" id="literalEdit" class="form-control text-uppercase">
                      </div>
                    </div>
                  </div>
                  <div class="form-group" >
                    <div class="row">
                      <div class="col-sm-6 col-md-6">
                          <label><b>Estado</b></label>
                          <select name="estado" id="estado" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                          </select>
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
<div class="modal fade modal-center" id="nuevaFuncion" name="nuevaFuncion"  style='display:none;' tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
            <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <h4 class="modal-title" id="frmModalLabel">
                    NUEVA FUNCIÓN
                </h4>
            </div>
                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">

               </div>
            </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

              <form role="form" method="post" action="{{route('store.funcion')}}" autocomplete="off" id="formModal2">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label><b>Nombre:</b></label>
                        <textarea name="nombreF" id="nombreF" class="form-control" rows="3"></textarea>
                        <input type="hidden" name="idPlazaFuncional" id="idPlazaFuncional" value="{{$plazaFuncional->idPlazaFuncional}}">
                      </div>
                    </div>
                  </div>
                  <div class="form-group" >
                    <div class="row">
                      <div class="col-sm-6 col-md-6 col-lg-6">
                        <label><b>Literal:</b></label>
                        <input name="literal" id="literal" class="form-control text-uppercase">
                      </div>
                      <!--<div class="col-sm-6 col-md-6">
                          <label><b>Estado</b></label>
                          <select name="estado" id="estado" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                          </select>
                      </div> -->
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

@endsection

@section('js')
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
@if(Session::has('msnExito'))
 <script type="text/javascript">
   alertify.success('¡EXITO!¡LA FUNCIÓN FUE ELIMINADA CON EXITO!');
  {{Session::forget('msnExito')}}
  table.ajax.reload();
 </script>
@endif
<script type="text/javascript">

function nuevaFuncion(){
  //seteamos los valores de los campos
  $('#nombreF').val("");
  $('#literal').val("");
  $('#estado').val("");
}

function editarFuncion($idFuncion,$nombreFuncion,$estado,$literal){
  //seteamos las variables
  $('#nombreFuncion').val("");
  $('#idFuncion').val("");
  $('#estado').val("");

  //asignamos los valores
  $('#idFuncion').val($idFuncion);
  $('#nombreFuncion').val($nombreFuncion);
  $('#literalEdit').val($literal);
  $('#estado').val($estado);
}

function confirmar(id){

  alertify.confirm('NECESITA CONFIRMACION',"Esta seguro que desea eliminar la función?",
  function(){
    window.location = "{{url('cat/plazaFunc/funcion/eliminarFuncion')}}"+'/'+id;
  },
  function(){
    alertify.error('Cancel');

  });
  return false;
}

$( document ).ready(function() {

	var table = $('#dt-funciones').DataTable({
		filter:false,
        processing: true,
        paginate:false,
        info:false,

		language: {
            "sProcessing": '<div class=\"dlgwait\"></div>',
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"


        },
       "columnDefs": [ {
         "searchable": false,
            "orderable": false,
             "targets": [1,2,3]
        } ],

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
                alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Función Actualizada de forma exitosa!</p></strong>",function(){
                  var obj =  JSON.parse(response);
                  location.reload();
                  $("#boton1" ).trigger( "click" );
                });

              }else{
                alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('body').modalmanager('loading');
                alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo actualizar la Función!</p></strong>");
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
                alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Función Guardada de forma exitosa!</p></strong>",function(){
                  var obj =  JSON.parse(response);
                  location.reload();
                  $("#boton2" ).trigger( "click" );
                });

              }else{
                alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('body').modalmanager('loading');
                alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo Guardar la Función!</p></strong>");
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