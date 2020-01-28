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

    <form role="form" method="post" action="{{route('post.editar.plazaFunc')}}"   autocomplete="off" id="formEditPlaza">
                   <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Nombre de la plaza</b></div>
                      <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" value="{{$plazaFun->nombrePlaza}}">
                    </div>
                    </div>
                    </div>
                </div>
                  <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Descripci&oacute;n</b></div>
                      <textarea class="form-control"  rows="2" id="descripcion" name="descripcion">{{$plazaFun->descripcionPlaza}}</textarea>
                    </div>
                    </div>
                    </div>
                </div>
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Unidad</b></div>
                      <select name="idUnidad" id="idUnidad" class="form-control chosen-select" style="width: 100%;" >
                        @foreach($unidad as $uni)
                         @if($plazaFun->idUnidad==$uni->idUnidad)
                           <option value="{{$uni->idUnidad}}" selected> {{$uni->nombreUnidad}}</option>
                         @else
                           <option value="{{$uni->idUnidad}}" > {{$uni->nombreUnidad}}</option>
                         @endif

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
                      <select name="idNominal" id="idNominal" class="form-control chosen-select" style="width: 100%;" >

                       @foreach($plazaNom as $nom)
                         @if($nom->idPlazaNominal==$plazaFun->idPlazaNominal)
                           <option value="{{$nom->idPlazaNominal}}" selected> {{$nom->nombrePlazaNominal}}</option>
                         @else
                           <option value="{{$nom->idPlazaNominal}}" > {{$nom->nombrePlazaNominal}}</option>
                         @endif

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
                      <select name="idPadre" id="idPadre" class="form-control chosen-select" style="width: 100%;" >
                        @foreach($plazaPadre as $padre)
                          @if($plazaFun->idPlazaFuncionalPadre==$padre->idPlazaFuncional)
                          <option value="{{$padre->idPlazaFuncional}}" selected>{{$padre->nombrePlaza}}</option>
                          @else
                          <option value="{{$padre->idPlazaFuncional}}">{{$padre->nombrePlaza}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="input-group">
                              <div class="input-group-addon">La plaza es jefatura?</div>
                              <input class="checkbox-inline" type="checkbox" @if ($esJefe) checked="checked" @endif name="esJefe" id="esJefe">
                          </div>
                      </div>
                  </div>
                </div>
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Fecha inicial</b></div>
                      <input type="text" class="form-control date_masking datepicker" id="fecha" name="fecha" value="{{$plazaFun->fechaInicial}}"data-date-format="yyyy-mm-dd">
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
                  @if(count($plazaConocimientos)>0)
                      @foreach($conocimientos as $cono)
                        @if(in_array($cono->idTipoActitud, $plazaConocimientos))
                         <option value="{{$cono->idTipoActitud}}" selected>{{$cono->nombreTipoActitud}}</option>
                        @else
                           @if($cono->activo==1)
                             <option value="{{$cono->idTipoActitud}}">{{$cono->nombreTipoActitud}}</option>
                           @endif
                        @endif
                       @endforeach

                 @else
                    @foreach($conocimientos as $cono)
                      <option value="{{$cono->idTipoActitud}}">{{$cono->nombreTipoActitud}}</option>
                    @endforeach
                 @endif

                  </select>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Misión del puesto</b></div>
                      <textarea class="form-control"  rows="2" id="mision" name="mision">{{$plazaFun->mision}}</textarea>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Habilidades generales</b></div>
                         <textarea id="habilidades" name="habilidades" class="form-control summernote-lg">{{$plazaFun->habilidades}}</textarea>
                         </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Conocimientos generales</b></div>
                         <textarea id="conocimiento" name="conocimiento" class="form-control summernote-lg">{{$plazaFun->conocimientos}}</textarea>
                         </div>
                    </div>
                    </div>
                </div>
                  <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Maquinas equipo y materiales</b></div>
                         <textarea id="equipo" name="equipo" class="form-control summernote-lg">{{$plazaFun->equipoMateriales}}</textarea>
                         </div>
                    </div>
                    </div>
                </div>
                 <input type="hidden" class="form-control"  id="id" name="id" value="{{$plazaFun->idPlazaFuncional}}">
                    <div class="from-group" align="center">

                       <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                     <button type="submit" class="btn btn-primary btn-perspective">Actualizar <i class="fa fa-check"></i></button>
                    </div>
            </form>

@endsection

@section('js')
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
{{-- SElECTIZE JS --}}
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
<script type="text/javascript">


$( document ).ready(function(){

  $('#formEditPlaza').submit(function(e){
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

                  alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Se han actualizado los datos de forma exitosa!</p></strong>",function(){
                  var obj =  JSON.parse(response);
                   location.reload();
                  });

              }else{
                alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('body').modalmanager('loading');

                alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo guardar la información!</p></strong>");

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
