@extends('master')
{{-- CSS ESPECIFICOS --}}


{{-- CONTENIDO PRINCIPAL --}}
@section('contenido')
{{-- ERRORES DE VALIDACIÓN --}}
@if($errors->any())
  <div class="alert alert-warning square fade in alert-dismissable">
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
    <strong>Oops!</strong>
    Debes corregir los siguientes errores para poder continuar    
    <ul class="inline-popups">
      @foreach ($errors->all() as $error)
        <li  class="alert-link">{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
     
  <form role="form" method="post" action="{{route('guardar.evaluacionTemporal')}}" autocomplete="off" id="formEvaluacion">
    <div class="form-group">
         <div class="row">
        <div class="col-sm-12 col-md-12">
         <div class="input-group ">
          <div class="input-group-addon"><b>Nombre de evaluación</b></div>
          <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" >
        </div>
        </div>
        </div>
    </div>
            
    <div class="form-group">
         <div class="row">
         <div class="col-sm-6 col-md-6">
         <div class="input-group ">
          <div class="input-group-addon"><b>Estado</b></div>
            <select name="estado" id="estado" class="form-control">
                  <option value="1" selected>ACTIVO</option>
                  <option value="0">INACTIVO</option>
            </select>
        </div>
        </div>
        </div>
    </div>
    <div class="form-group">
         <div class="row">
        <div class="col-sm-12 col-md-12">
         <div class="input-group ">
          <div class="input-group-addon"><b>Descripci&oacute;n</b></div>
          <textarea class="form-control"  rows="2" id="descripcion" name="descripcion"></textarea>
        </div>
        </div>
        </div>
    </div>              
     

    <div class="from-group" align="center">
         
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <input type="hidden" class="form-control"  id="id" name="id"><!--Para poder usar el mismo método al editar -->
          <button type="submit" class="btn btn-primary btn-perspective">Registrar <i class="fa fa-plus"></i></button>
          <a href="{{route('evaluacionPersonalTemp.listar')}}" style="" type="button" id="cancelar" class="btn btn-warning btn-perspective">Regresar<i class="fa fa-reply" aria-hidden="true"></i></a>
    </div>                      
              
  </form>  

@endsection

{{-- JS ESPECIFICOS --}}
@section('js')

{{-- Bootstrap Modal --}}

{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}

<script>

$(document).ready(function(){ 

//inicio almacenar el nuevo principio activo
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
  
    
    $('#formEvaluacion').submit(function(e){
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
              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n registrada de forma exitosa!</p></strong>",function(){
                var obj =  JSON.parse(response);
                window.location.href = "{{route('insertar.evaluacionTemporal')}}";
              });
              
            }else{
              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
        $('body').modalmanager('loading');
        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
              console.log("Error en peticion AJAX!");  
          }
    });
    e.preventDefault(); //Prevent Default action. 

    });
  
function isJson(str){
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