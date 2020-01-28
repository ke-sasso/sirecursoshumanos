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

<form role="form" method="post" action="{{route('store.actitud')}}" autocomplete="off" id="formActitud">

  <div class="form-group" >
    <div class="row">
      <div class="col-sm-6 col-md-6">
          <label style="display: inline-block;margin-bottom: 2%;">Tipo de Actitud:</label>
          <a href="{{route('insertar.tipoActitud')}}" target="_blank"><button style="display: inline-block; margin-right: 1%;margin-bottom: 2%; color: white;" type="button" class="btn btn-primary btn-xs btn-perspective" title="Agregar Tipo de Actitud"><i class="fa fa-plus" aria-hidden="true"></i></button></a>
          <select id="tipoActitud" name="tipoActitud" class="form-control select_tipo js-states" style="width:100%;" onchange="cambiarNombreActitud();"><option></option></select>                         
      </div>

    </div>
  </div> 

 <div class="form-group">
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <label><b>Nombre:</b></label>
        <textarea name="nombreActitud" id="nombreActitud" class="form-control" rows="3" readonly="true">{{$actitud->nombreActitud}}</textarea>
        <input type="hidden" name="idActitud" id="idActitud" value="{{$actitud->idActitud}}">
        <input type="hidden" name="idTareaActitud" id="idTareaActitud" value="{{$actitud->idTarea}}">
      </div>
    </div>
  </div>

  <div class="form-group">
 
   <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <button type="submit" class="btn btn-primary btn-perspective"><i class="fa fa-save"></i>Guardar</button>
      <a href="javascript:window.history.back();"><button type="button" id="Regresar" class="btn btn-warning btn-perspective NextStep-2"><i class="fa fa-arrow-left"></i>Regresar</button></a>
  </div>
                    
</form>
@endsection

@section('js')
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
{{-- SElECTIZE JS --}}
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
<script type="text/javascript">

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

$( document ).ready(function(){

  //inicializamos el valor que tendra el selectize
  $('#tipoActitud').append('<option selected value="{{$tipoActitud->idTipoActitud}}">{{$tipoActitud->nombreTipoActitud}}</option>');

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

  $('#formActitud').submit(function(e){
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

                  alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Actitud  Actualizada de forma exitosa!</p></strong>",function(){
                  var obj =  JSON.parse(response);

                  });                
                
              }else{
                alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('body').modalmanager('loading');

                  alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo actualizar la Actitud!</p></strong>");
                
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