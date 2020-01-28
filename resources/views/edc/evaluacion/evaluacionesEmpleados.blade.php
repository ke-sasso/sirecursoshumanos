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

<div class="panel panel-success">

    <div class="panel-heading" >
        <h3 class="panel-title">
            <a class="block-collapse collapsed" id='colp' data-toggle="collapse" href="#collapse-filter">
            B&uacute;squeda Avanzada de evaluaciones
            <span class="right-content">
                <span class="right-icon"><i class="fa fa-plus icon-collapse"></i></span>
            </span>
            </a>
        </h3>
    </div>


    
    <div id="collapse-filter" class="collapse" style="height: 0px;">
        <div class="panel-body " >

            {{-- COLLAPSE CONTENT --}}
            <form role="form" id="search-form">
               <div class="row">
                    <div class="form-group col-sm-5 col-xs-12 col-md-10 col-lg-10">
                        <label>Seleccione la unidad:</label>
                          <select class="form-control" name="unidad" id="unidad" >
                            <option value="" selected>Seleccione...</option>
                             @foreach($unidades as $uni)
                                <option value="{{$uni->idUnidad}}">
                                  {{$uni->nombreUnidad}}
                                </option>
                            @endforeach
                            
                         </select>
                    </div>
               </div>
               <div class="row">
                    
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Fecha evaluación:</label>
                       <input type="text" name="fechaInicio"  id="fechaInicio" class="form-control datepicker" placeholder="yyyy-mm-dd" maxlength="10" autocomplete="off">        
                    </div>



                    <div class="form-group col-sm-3 col-xs-12">
                             <label>Código empleado:</label>
                             <input type="number" min="1" name="codigo"  id="codigo" class="form-control" placeholder="Código" maxlength="10" autocomplete="off">
                     </div>

                    <div class="form-group col-sm-3 col-xs-12">
                             <label>Nombre empleado:</label>
                             <input type="text" name="nombre"  id="nombre" class="form-control" placeholder="Nombres" maxlength="100" autocomplete="off">
                     </div>
                                         <div class="form-group col-sm-3 col-xs-12">
                             <label>Apellido empleado:</label>
                             <input type="text" name="apellido"  id="apellido" class="form-control" placeholder="Apellidos" maxlength="100" autocomplete="off">
                     </div>

               </div>
               <div class="row">
                  <div class="form-group col-sm-4">
                    <label>Finalizadas</label>
                    <select name="txtFinalizadas" id="txtFinalizadas" class="form-control">
                      <option value="">-- Seleccione --</option>
                      <option value="1">Ver Finalizadas</option>
                      <option value="0">Ver No Finalizadas</option>
                    </select>
                    
                  </div>
               </div>
                    
                <div class="modal-footer" >
                    <div align="center">
                             <input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
                  <button type="submit" class="btn btn-success btn-perspective"><i class="fa fa-search"></i> Buscar</button>
                           </div>
                        </div>
                    
                    
            </form>
            {{-- /.COLLAPSE CONTENT --}}
        </div><!-- /.panel-body -->
    </div><!-- /.collapse in -->
</div>


    <div class="the-box">

	<div class="table-responsive">
	<table class="table table-striped table-hover"  id="tr-permisos" style="font-size:13px;" width="100%">
		<thead class="the-box dark full">
			<tr>
				        <th width="10%" align="left">CORRELATIVO</th>
                <th>NOMBRE EMPLEADO</th>
                 <th>APELLIDO EMPLEADO</th>
                <th>COD EMPLEADO</th>
                <th>UNIDAD</th>
                <th>FECHA EVALUACIÓN</th>
                <th><i class="fa fa-location-arrow"></i></th>
                <th><i class="fa fa-eye"></i></th>
                <th>CALIFICACIÓN</th>
                 <th>-</th>

               
               
			</tr>
     	</thead>
     	<tbody></tbody>
    
	</table>
	</div><!-- /.table-responsive -->
</div><!-- /.the-box .default -->
<!-- END DATA TABLE -->
@endsection

@section('js')



<script>
$( document ).ready(function() {
     
    $('#fechaInicio').mask('0000-00-00');

    var table = $('#tr-permisos').DataTable({
        filter:false,
        processing: true,
        serverSide: true,

        ajax: {
            url: "{{route('dt.row.data.evaluacionesEmpleados',['idEvaluacion'=>$idEvaluacion])}}",
             data: function (d) {
                d.unidad= $('#unidad').val();
                d.fechaInicio= $('#fechaInicio').val();
                d.codigo= $('#codigo').val();
                d.nombre= $('#nombre').val();
                d.apellido= $('#apellido').val();
                d.finalizada = $('#txtFinalizadas').val();
            }
        },
        columns: [
           {
                
                "orderable":      false,
                "searchable":     false,
                "data":           null,
                "defaultContent": ''
            },
	      	 // <-- This is will your index column
          {data: 'nombresEmpleado', name: 'emp.nombresEmpleado'},
          {data: 'apellidosEmpleado', name: 'emp.apellidosEmpleado'},
          {data: 'idEmpleado', name: 'resul.idEmpleado'},
          {data: 'nombreUnidad', name: 'uni.nombreUnidad'},
          {data: 'fechaEvaluacion', name: 'resul.fechaEvaluacion'},
          {data: 'finalizada', name: 'resul.finalizada'},
          {data: 'finalizada', name: 'resul.finalizada'},
          {data: 'CP', name: 'resul.CP'},
		      {data: 'detalle', name: 'detalle',ordenable:false,searchable:false},
            
        ],
        language: {
            "sProcessing": '<div class=\"dlgwait\"></div>',
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
            
            
        },
       "columnDefs": [ {
            "width": "10%",
            
            "searchable": false,
            "orderable": false,
           "targets": [7]
            
          
        } ],

        "order": [[ 3, 'desc' ]]
    } );
	
	
    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

   
    $('#search-form').on('submit', function(e) {

        table.draw();
        e.preventDefault();
        $("#colp").attr("class", "block-collapse collapsed");
        $("#collapse-filter").attr("class", "collapse");
    });
        

    table.rows().remove();



      
});

function format (d) {   
  $comen = d.comentarios;

  if($comen==='' || $comen==null){
    return '<table  cellspacing="0" border="0"  width="50%">'+
        '<tr>'+
            '<td><b>Comentarios sobre la evaluación:<b>&nbsp;&nbsp;</td>'+
            '<td>Este empleado no tiene ningún comentario</td>'+
        '</tr>'+
        '<tr>'+
    '</table>';
  }else{
    return '<table  cellspacing="0" border="0" style="padding-left:50px;" width="100%">'+
        '<tr>'+
            '<td><b>Comentarios sobre la evaluación:<b>&nbsp;&nbsp;</td>'+
            '<td>'+d.comentarios+'</td>'+
        '</tr>'+
        '<tr>'+
    '</table>';


  }
}

       
</script>
@endsection
