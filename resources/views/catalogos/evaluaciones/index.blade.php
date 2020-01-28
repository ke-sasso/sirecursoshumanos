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
{{-- MENSAJE DE EXITO --}}

{{-- MENSAJE DE ERROR --}}
@if(Session::has('msnError'))
	<div class="alert alert-danger square fade in alert-dismissable">
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
		<strong>Algo ha salido mal.!</strong>
			{{ Session::get('msnError') }}
	</div>
@endif


<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<a href="{{route('insertar.evaluacion')}}" style="" type="button" id="cancelar" class="btn btn-primary m-t-10"><i class="fa fa-plus" aria-hidden="true"></i>Nueva evaluaci&oacute;n</a>
</div>
</div>


    <div class="the-box">

	<div class="table-responsive">
	<table class="table table-striped table-hover"  id="tr-Evaluacion" style="font-size:12.5px;" width="100%">
		<thead class="the-box dark full">
			<tr>
				        <th>CORRELATIVO</th>
                <th>NOMBRE</th>
                <th>PERIODO</th>
                <th>FECHA INICIO</th>
                <th>FECHA FIN</th>
                <th>ESTADO</th>
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

        <form role="form" method="post" action="{{route('post.editar.evaluacion')}}"   autocomplete="off" id="formModal">
              <div class="form-group">
                     <div class="row">
                    <div class="col-sm-12 col-md-12">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Nombre de evaluaci&oacute;n</b></div>
                      <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" >
                    </div>
                    </div>
                    </div>
                </div>
                
                 <div class="form-group">
                     <div class="row">
                    <div class="col-sm-6 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Periodo</b></div>
                      <input type="text" class="form-control periodo" title="formato ##-##" id="periodo" name="periodo" autocomplete="off" >
                    </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Estado</b></div>
                        <select name="estado" id="estado" class="form-control">
                             
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
                       <input type="text" name="fechaInicio"  id="fechaInicio" title="Ejemplo: 2017-01-31" class="form-control date_masking2 datepicker" placeholder="yyyy-mm-dd"  data-date-format="yyyy-mm-dd" maxlength="10" autocomplete="off" >  
                    </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                     <div class="input-group ">
                      <div class="input-group-addon"><b>Fecha fin</b></div>
                 <input type="text" name="fechaFin"  id="fechaFin" title="Ejemplo: 2017-01-31" class="form-control date_masking2 datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" maxlength="10" autocomplete="off"  title="La fecha inicial debe ser menor que la fecha final" oninput="validate()"> 
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

<script>

$( document ).ready(function() {
  $('.periodo').mask('00-00');
$('.date_masking2').mask('0000-00-00');

    var table = $('#tr-Evaluacion').DataTable({
        filter:true,
        processing: true,
        serverSide: false,

        ajax: {
            url: "{{route('dt.row.data.evaluacion')}}",
        },
        columns: [
	      	{
                "className":      'details-control',
                "orderable":      false,
                "searchable":     false,
                "data":           null,
                "defaultContent": ''
            }, // <-- This is will your index column
           {data: 'nombre', name: 'nombre'},
           {data: 'periodo', name: 'periodo'},
           {data: 'fechaInicio', name: 'fechaInicio'},
           {data: 'fechaFin', name: 'fechaFin'},
           {data: 'estado', name: 'estado'},
		      {data: 'detalle', name: 'detalle',ordenable:false,searchable:false},
            
        ],
        language: {
            "sProcessing": '<div class=\"dlgwait\"></div>',
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"

   
        },
       "columnDefs": [ {
         "searchable": false,
            "orderable": false,      
             "targets": [0,6]
        } ],

        "order": [[ 1, 'asc' ]]
    } );
	
	
    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
       $('#tr-Evaluacion tbody').on('click', 'td.details-control', function () {
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
  $des = d.descripcion;

  if($des==='' || $des==null){
    return '<table  cellspacing="0" border="0">'+
        '<tr>'+
            '<td><b>Descripci&oacute;n de la evaluaci&oacute;n: <b>&nbsp;&nbsp;</td>'+
            '<td>No existe ning&uacute;na descripci&oacute;n</td>'+
        '</tr>'+
        '<tr>'+
    '</table>';
  }else{
    return '<table  cellspacing="0" border="0" style="padding-left:50px;" width="100%">'+
        '<tr>'+
            '<td><b>Descripci&oacute;n de la evaluaci&oacute;n: <b>&nbsp;&nbsp;</td>'+
            '<td>'+$des+'</td>'+
        '</tr>'+
        '<tr>'+
    '</table>';


  }
}

function editarInfo(id){
      $.get("{{route('data.evaluacion')}}?param="+id, function(data) {
                    try{
                     $('#nombre').val(""); 
                      $('#id').val("");
                      $('#descripcion').val("");
                      $('#fechaInicio').val("");
                      $('#fechaFin').val("");
                      $('#periodo').val("");
                      document.getElementById("estado").length=0;
                     
                      $('#nombre').val(data.nombre); 
                      $('#periodo').val(data.periodo);
                      $('#fechaInicio').val(data.fechaInicio); 
                       $('#fechaFin').val(data.fechaFin); 
                       $('#descripcion').val(data.descripcion); 
                      $('#id').val(data.idEvaluacion);

                      if(data.activo==1){
                         $('#estado').append('<option selected value="1">ACTIVO</option>');
                          $('#estado').append('<option value="0">INACTIVO</option>');
                            }else{
                               $('#estado').append('<option  value="1">ACTIVO</option>');
                              $('#estado').append('<option selected value="0">INACTIVO</option>');
                            }


        

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
                window.location.href = "{{route('evaluacion.listar')}}";
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
