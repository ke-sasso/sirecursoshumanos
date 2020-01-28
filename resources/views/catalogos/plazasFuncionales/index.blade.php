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
{{-- MENSAJE DE EXITO --}}

{{-- MENSAJE DE ERROR --}}
@if(Session::has('msnError'))
	<div class="alert alert-danger square fade in alert-dismissable">
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
		<strong>Algo ha salido mal.!</strong>
			{{ Session::get('msnError') }}
	</div>
@endif
<div class="panel panel-primary">
    <div class="panel-heading" >
        <h3 class="panel-title">
            <a class="block-collapse collapsed" id='colp' data-toggle="collapse" href="#collapse-filter">
            B&uacute;squeda Avanzada de Plazas Funcionales
            <span class="right-content">
                <span class="right-icon"><i class="fa fa-plus icon-collapse"></i></span>
            </span>
            </a>
        </h3>
    </div>
    <div id="collapse-filter" class="collapse" style="height: 0px;">
        <div class="panel-body">

            {{-- COLLAPSE CONTENT --}}
            <form role="form" id="search-form">
              <div class="row">
                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                  <label>Nombre Plaza Funcional:</label>
                  <select id="plazaFuncional" name="plazaFuncional" placeholder="Ingrese una Plaza..." class="form-control"></select>
                </div>
                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                  <label>Nombre Plaza Nominal:</label>
                  <select id="plazaNominal" name="plazaNominal" placeholder="Ingrese una Plaza..." class="form-control"></select>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                  <label>Unidad:</label>
                  <select name="unidad" id="unidad" class="form-control">
                    <option value="">Seleccione</option>
                    @foreach($unidades as $unidad)
                    <option value="{{$unidad->idUnidad}}">{{$unidad->nombreUnidad}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                  <label>Empleado:</label>
                  <select id="plazaEmpleado" name="plazaEmpleado" placeholder="Ingrese un Empleado..." class="form-control"></select>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                  <label>Plaza a la que se reporta:</label>
                  <select id="plazaPadre" name="plazaPadre" placeholder="Ingrese una Plaza..." class="form-control"></select>
                </div>
              </div>

              <div class="modal-footer" >
                <div align="center">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
                  <button  type="submit" class="btn btn-primary btn-perspective" ><i class="fa fa-search"></i> Buscar</button>
                </div>
              </div>

            </form>
            {{-- /.COLLAPSE CONTENT --}}
        </div><!-- /.panel-body -->
    </div><!-- /.collapse in -->
</div>

<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<a href="{{route('insertar.plazaFunc')}}" style="" type="button" id="cancelar" class="btn btn-primary m-t-10"><i class="fa fa-plus" aria-hidden="true"></i>Nueva plaza funcional</a>
</div>
</div>


    <div class="the-box">

	<div class="table-responsive">
	<table class="table table-striped table-hover"  id="tr-PlazaFunc" style="font-size:12.5px;" width="100%">
		<thead class="the-box dark full">
			<tr>
				        <th >CORRELATIVO</th>
                <th>NOMBRE DE LA PLAZA</th>
                <th>UNIDAD</th>
                <th>PLAZA NOMINAL</th>
                <th>PLAZA PADRE</th>
                <th>FECHA INICIAL</th>
                <th>-</th>
                <th>-</th>
			</tr>
     	</thead>
     	<tbody></tbody>
	</table>
	</div><!-- /.table-responsive -->
</div><!-- /.the-box .default -->
<!-- END DATA TABLE -->
<div class="modal fade modal-center" id="info"  style='display:none;' tabindex="-1" role="dialog" >
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

        <form role="form" method="post" action="{{route('post.editar.plazaFunc')}}"   autocomplete="off" id="formModal">
                   <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Nombre de la plaza</b></div>
                      <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" >
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
                      <div class="input-group-addon"><b>Unidad</b></div>
                      <select name="idUnidad" id="idUnidad" class="form-control" style="width: 100%;" >
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
                      <select name="idNominal" id="idNominal" class="form-control" style="width: 100%;" >
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
                      <select name="idPadre" id="idPadre" class="form-control" style="width: 100%;" >
                      </select>
                    </div>
                    </div>
                    </div>
                </div>
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Fecha inicial</b></div>
                      <input type="text" class="form-control date_masking datepicker" id="fecha" name="fecha" data-date-format="yyyy-mm-dd">
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Misión del puesto</b></div>
                      <textarea class="form-control"  rows="2" id="mision" name="mision"></textarea>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Misión del puesto</b></div>
                         <textarea class="summernote-lg"  style="display: none;"></textarea>
                    </div>
                    </div>
                    </div>
                </div>



                 <input type="hidden" class="form-control"  id="id" name="id">



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
@endsection


@section('js')
 {!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
 {{-- SElECTIZE JS --}}
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}

<script>

$( document ).ready(function() {

/*Funcion para buscar el empleado*/
var plazaEmpleado = $('#plazaEmpleado').selectize({
    valueField: 'idPlazaFuncional',
    labelField: 'nombreCompleto',
    searchField:'nombreCompleto',
    maxOptions: 10,
    options: [],
    create: false,
    render: {
        option: function(item, escape) {
            return '<div>' +escape(item.nombreCompleto)+'</div>';
          }
    },
    load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: "{{ route('find.empleado') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    q: query
                },
                error: function() {
                    callback();
                },
                success: function(res) {
                  console.log(res.data);
                    callback(res.data);
                }
            });
    }
});

/*Funcion para buscar la plaza funcional*/
var plazaEmpleado = $('#plazaFuncional').selectize({
    valueField: 'idPlazaFuncional',
    labelField: 'nombrePlaza',
    searchField:'nombrePlaza',
    maxOptions: 10,
    options: [],
    create: false,
    render: {
        option: function(item, escape) {
            return '<div>' +escape(item.nombrePlaza)+'</div>';
          }
    },
    load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: "{{ route('find.plazaFunc') }}",
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

/*Funcion para buscar la plaza nominal*/
var plazaEmpleado = $('#plazaNominal').selectize({
    valueField: 'idPlazaNominal',
    labelField: 'nombrePlazaNominal',
    searchField:'nombrePlazaNominal',
    maxOptions: 10,
    options: [],
    create: false,
    render: {
        option: function(item, escape) {
            return '<div>' +escape(item.nombrePlazaNominal)+'</div>';
          }
    },
    load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: "{{ route('find.plazaNom') }}",
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

/*Funcion para buscar la plaza Padre*/
var plazaEmpleado = $('#plazaPadre').selectize({
    valueField: 'idPlazaFuncional',
    labelField: 'nombrePlaza',
    searchField:'nombrePlaza',
    maxOptions: 10,
    options: [],
    create: false,
    render: {
        option: function(item, escape) {
            return '<div>' +escape(item.nombrePlaza)+'</div>';
          }
    },
    load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: "{{ route('find.plazaFunc') }}",
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
        var $states = $(".js-source-states");
                    var statesOptions = $states.html();
                    $states.remove();
                    $(".js-states").append(statesOptions);
                    $(".select_plaza").select2({
                        placeholder: "Seleccione...",
                        allowClear: true
                    });
    var table = $('#tr-PlazaFunc').DataTable({
        filter:false,
        processing: true,
        serverSide: true,

        ajax: {
            url: "{{route('dt.row.data.plazaFunc')}}",
            data: function (d) {
                d.plazaFuncional= $('#plazaFuncional').val();
                d.unidad= <?php echo (!empty($unidadJefatura)) ? $unidadJefatura : '$(\'#unidad\').val()' ; ?>;
                d.plazaNominal=$('#plazaNominal').val();
                d.plazaEmpleado=$('#plazaEmpleado').val();
                d.plazaPadre=$('#plazaPadre').val();
            }
        },
        columns: [
	      	{
                "className":      'details-control',
                "orderable":      false,
                "searchable":     false,
                "data":           null,
                "defaultContent": ''
            }, // <-- This is will your index column
           {data: 'nombrePlaza', name: 'PF1.nombrePlaza'},/*especifico la tabla para evitar ambiguedad*/
           {data: 'nombreUnidad', name: 'nombreUnidad'},
           {data: 'nombrePlazaNominal', name: 'nombrePlazaNominal'},
           {data: 'plazaPadre', name: 'plazaPadre'},
           {data: 'fechaInicial', name: 'fechaInicial'},
		      {data: 'detalle', name: 'detalle',ordenable:false,searchable:false},
          {data: 'perfil', name: 'perfil',ordenable:false,searchable:false},

        ],
        language: {
            "sProcessing": '<div class=\"dlgwait\"></div>',
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"


        },
       "columnDefs": [ {
         "searchable": false,
            "orderable": false,
             "targets": [0,6,7]
        } ],

        "order": [[ 1, 'asc' ]]
    } );

    $('#search-form').on('submit', function(e) {

        table.draw();
        e.preventDefault();
        $("#colp").attr("class", "block-collapse collapsed");
        $("#collapse-filter").attr("class", "collapse");
    });

    table.rows().remove();


    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
       $('#tr-PlazaFunc tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });



});
function format (d) {
  $des = d.descripcionPlaza;
  $mision = d.mision;
  if($mision==='' || $mision==null){
    $mision='No existe ning&uacute;na descripci&oacute;n';
  }
  if($des==='' || $des==null){
    $des='No existe ning&uacute;na descripci&oacute;n';
  }

    return '<table  cellspacing="0" border="0" width="100%">'+
        '<tr>'+
            '<td><b>Descripci&oacute;n de la plaza:<b>&nbsp;&nbsp;</td>'+
            '<td>'+$des+'</td>'+
        '</tr>'+
         '<tr>'+
            '<td><b>Misión del puesto:<b>&nbsp;&nbsp;</td>'+
            '<td>'+$mision+'</td>'+
        '</tr>'+
    '</table>';

}

function editarInfo(id){
      $.get("{{route('data.plazaFunc')}}?param="+id, function(data) {
                    try{
                     $('#nombre').val("");
                      $('#id').val("");
                      $('#descripcion').val("");
                      $('#fecha').val("");
                      $('#mision').val("");
                       document.getElementById("idUnidad").length=0;
                       document.getElementById("idPadre").length=0;
                       document.getElementById("idNominal").length=0;

                      $('#nombre').val(data.nombrePlaza);
                      $('#fecha').val(data.fechaInicial);
                       $('#descripcion').val(data.descripcionPlaza);
                      $('#id').val(data.idPlazaFuncional);
                      $('#mision').val(data.mision);
                      var idUnidad = data.idUnidad;
                      var idPlazaN = data.idPlazaNominal;
                      var idPlazaP = data.idPlazaFuncionalPadre;
                      var b1 =1;
                      var b2 =1;
                      var b3 =1;
                         $.get("{{route('data.unidades')}}", function(data){
                               $.each(data, function(i, value) {
                                     if(idUnidad==value.idUnidad){
                              $('#idUnidad').append('<option selected value="'+value.idUnidad+'">'+value.nombreUnidad+'</option>');
                              b3= b3 +1;
                            }else{
                              $('#idUnidad').append('<option value="'+value.idUnidad+'">'+value.nombreUnidad+'</option>');
                            }

                                });
                              if(b3==1){
                                $('#idUnidad').append('<option selected value="">Seleccione la unidad...</option>');
                              }
                          });

                    $.get("{{route('data.plazaNom.listar')}}", function(data){

                               $.each(data, function(i, value){
                                     if(idPlazaN==value.idPlazaNominal){
                              $('#idNominal').append('<option selected value="'+value.idPlazaNominal+'">'+value.nombrePlazaNominal+'</option>');
                              b1 = b1 +1;
                            }else{
                              $('#idNominal').append('<option value="'+value.idPlazaNominal+'">'+value.nombrePlazaNominal+'</option>');

                            }
                                });
                               if(b1==1){
                                    $('#idNominal').append('<option selected value="">Seleccione una plaza nominal...</option>');
                               }

                          });

                      $.get("{{route('data.plazaFunListar')}}", function(data){

                               $.each(data, function(i, value) {
                                     if(idPlazaP==value.idPlazaFuncional){
                              $('#idPadre').append('<option selected value="'+value.idPlazaFuncional+'">'+value.nombrePlaza+'</option>');
                              b2= b2 +1;
                            }else{
                              $('#idPadre').append('<option value="'+value.idPlazaFuncional+'">'+value.nombrePlaza+'</option>');
                            }

                                });
                               if(b2==1){
                                 $('#idPadre').append('<option selected value="">Seleccione una plaza padre...</option>');

                               }

                          });



                    }
                    catch(e)
                    {
                      console.log(e);
                    }

                  });



    $('#info').modal('toggle');


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
              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n actualizada de forma exitosa!</p></strong>",function(){
                var obj =  JSON.parse(response);
                window.location.href = "{{route('plazaFunc.listar')}}";
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

}


</script>
@endsection
