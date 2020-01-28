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

<form role="form" method="post" action="{{route('store.conocimiento')}}" autocomplete="off" id="formConocimiento">

  <div class="form-group" >
    <div class="row">
      <div class="col-sm-6 col-md-6">
          <label style="display: inline-block;margin-bottom: 2%;">Tipo de Conocimiento:</label>
          <button style="display: inline-block; margin-right: 1%; color: white;" type="button" class="btn btn-primary btn-xs btn-perspective" title="Agregar Tipo de Conocimiento" data-toggle="modal" data-target="#nuevoTipoConocimiento"><i class="fa fa-plus" aria-hidden="true"></i></button>
          <select id="tipoConocimiento" name="tipoConocimiento" class="form-control select_tipo js-states" style="width:100%;" onchange="cambiarNombreConocimiento();"><option></option></select>                         
      </div>
      <div class="col-sm-4 col-md-4">

          <label style="display: inline-block;margin-bottom: 2%;"><b>Nivel</b></label>
          <select name="nivel" id="nivel" class="form-control">
            <option value="">Seleccione</option>
            @foreach($niveles as $nivel)
            <option value="{{$nivel->idNivel}}" @if($conocimiento->idNivel==$nivel->idNivel) selected @endif>{{$nivel->nombreNivel}}</option>
            @endforeach
             
          </select>

      </div>
    </div>
  </div> 

 <div class="form-group">
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <label><b>Nombre:</b></label>
        <textarea name="nombreConocimiento" id="nombreConocimiento" class="form-control" rows="3" readonly="true">{{$conocimiento->nombreConocimiento}}</textarea>
        <input type="hidden" name="idConocimiento" id="idConocimiento" value="{{$conocimiento->idConocimiento}}">
        <input type="hidden" name="idTareaConocimiento" id="idTareaConocimiento" value="{{$conocimiento->idTarea}}">
      </div>
    </div>
  </div>

  <div class="form-group">
 
   <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <button type="submit" class="btn btn-primary btn-perspective"><i class="fa fa-save"></i>Guardar</button>
      <a href="javascript:window.history.back();"><button type="button" id="Regresar" class="btn btn-warning btn-perspective NextStep-2"><i class="fa fa-arrow-left"></i>Regresar</button></a>
  </div>
                    
</form>

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

              <form role="form" method="post" action="{{route('store.tipoConocimiento')}}"   autocomplete="off" id="formTipoConocimiento">
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
<script type="text/javascript">

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

$( document ).ready(function(){

  //inicializamos el valor que tendra el selectize
  $('#tipoConocimiento').append('<option selected value="{{$tipoConocimiento->idTipoConocimiento}}">{{$tipoConocimiento->nombreTipoConocimiento}}</option>');

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

  $('#formConocimiento').submit(function(e){
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

                  alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Conocimiento  Actualizado de forma exitosa!</p></strong>",function(){
                  var obj =  JSON.parse(response);

                  });                
                
              }else{
                alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('body').modalmanager('loading');

                  alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo actualizar el Conocimiento!</p></strong>");
                
                console.log("Error en peticion AJAX!");  
            }
      });
      e.preventDefault(); //Prevent Default action. 

  });

  $('#formTipoConocimiento').submit(function(e){
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