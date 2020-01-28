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

        <form role="form" method="post" action="{{route('guardar.plazaFunc')}}" autocomplete="off" id="formPlazaFunc">
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Nombre de la plaza</b></div>
                      <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" >
                    </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Fecha inicial</b></div>
                      <input type="text" name="fecha"  id="fecha" title="Ejemplo: 2017-01-31" class="form-control date_masking2 datepicker" placeholder="yyyy-mm-dd"  data-date-format="yyyy-mm-dd" maxlength="10" autocomplete="off" >
                    </div>
                    </div>
                    </div>
                </div>

                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Unidad</b></div>
                        <select name="idUnidad" id="idUnidad" class="form-control select_plaza js-states"
                             style="width: 100%;" >
                              <option></option>
                        </select>
                        <select class="js-source-states" style="visibility: hidden">
                          @foreach($unidad as $u)
                          <option value="{{$u->idUnidad}}">{{ $u->nombreUnidad}}</option>
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
                      <div class="input-group-addon"><b>Plaza nominal</b></div>
                        <select name="idNominal" id="idNominal" class="form-control select_plaza2 js-states2"
                             style="width: 100%;" >
                              <option></option>
                        </select>
                        <select class="js-source-states2" style="visibility: hidden">
                          @foreach($plazaNom as $pn)
                          <option value="{{ $pn->idPlazaNominal}}">{{ $pn->nombrePlazaNominal}}</option>
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
                      <div class="input-group-addon"><b>Plaza funcional padre</b></div>
                        <select name="idPadre" id="idPadre" class="form-control select_plaza3 js-states3"
                             style="width: 100%;" >
                              <option></option>
                        </select>
                        <select class="js-source-states3" style="visibility: hidden">
                          @foreach($plazaFun as $pf)
                          <option value="{{ $pf->idPlazaFuncional}}">{{ $pf->nombrePlaza}}</option>
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
                      <div class="input-group-addon"><b>Descripci&oacute;n</b></div>
                      <textarea class="form-control"  rows="2" id="descripcion" name="descripcion"></textarea>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Actitudes</b></div>
                <select data-placeholder="Seleccione una o más actitudes.." class="form-control chosen-select" multiple="" tabindex="-99" style="; width: 600px;" width="900" name="idConocimiento[]" id="idConocimiento">
                    <option value="">&nbsp;</option>
                    @foreach($conocimientos as $cono)
                      <option value="{{$cono->idTipoActitud}}">{{$cono->nombreTipoActitud}}</option>
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
                      <div class="input-group-addon"><b>Misi&oacute;n del puesto</b></div>
                      <textarea class="form-control"  rows="2" id="mision" name="mision"></textarea>
                    </div>
                    </div>
                    </div>
                </div>
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Habilidades genelares</b></div>
                         <textarea id="habilidades" name="habilidades" class="form-control summernote-lg"></textarea>
                         </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Conocimientos generales</b></div>
                         <textarea id="conocimiento" name="conocimiento" class="form-control summernote-lg"></textarea>
                         </div>
                    </div>
                    </div>
                </div>
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Maquinas equipo y materiales</b></div>
                         <textarea id="equipo" name="equipo" class="form-control summernote-lg"></textarea>
                         </div>
                    </div>
                    </div>
                </div>




                    <div class="from-group" align="center">

                       <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                     <button type="submit" class="btn btn-primary btn-perspective">Registrar <i class="fa fa-plus"></i></button>
                       <a href="{{route('plazaFunc.listar')}}" style="" type="button" id="cancelar" class="btn btn-warning btn-perspective">Regresar<i class="fa fa-reply" aria-hidden="true"></i></a>
                      </div>



            </form>



@endsection

{{-- JS ESPECIFICOS --}}
@section('js')

{{-- Bootstrap Modal --}}

{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}

<script>

$(document).ready(function(){
  $('.date_masking2').mask('0000-00-00');

//inicio almacenar el nuevo principio activo
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });


    $('#formPlazaFunc').submit(function(e){
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
                window.location.href = "{{route('insertar.plazaFunc')}}";
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

  function isJson(str) {
      try {
          JSON.parse(str);
      } catch (e) {
          return false;
      }
      return true;
  }
        var $states = $(".js-source-states");
                    var statesOptions = $states.html();
                    $states.remove();
                    $(".js-states").append(statesOptions);
                    $(".select_plaza").select2({
                        placeholder: "Seleccione la unidad...",
                        allowClear: true
                    });

          var $states = $(".js-source-states2");
                    var statesOptions = $states.html();
                    $states.remove();
                    $(".js-states2").append(statesOptions);
                    $(".select_plaza2").select2({
                        placeholder: "Seleccione la plaza nominal...",
                        allowClear: true
                    });
          var $states = $(".js-source-states3");
                    var statesOptions = $states.html();
                    $states.remove();
                    $(".js-states3").append(statesOptions);
                    $(".select_plaza3").select2({
                        placeholder: "Seleccione la plaza padre...",
                        allowClear: true
                    });

});

</script>
@endsection
