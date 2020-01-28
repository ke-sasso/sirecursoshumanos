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

<div class="the-box">

	<div class="table-responsive">
	<table class="table table-striped table-hover"  id="dt-empleados" style="font-size:13px;" width="100%">
		<thead class="the-box dark full">
			<tr>
				<!--<th>EVALUACION</th> -->
                <th width="15%">UNIDAD</th>
                <th width="15%">NOMBRE EMPLEADO</th>
                <th width="15%">APELLIDO EMPLEADO</th>
                <th>PLAZA FUNCIONAL</th>
                <th>INICIO PRUEBAS</th>
                <th>FIN PRUEBAS</th>
                <th>EVALUACIÓN</th>               
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
$(document).ready(function(){

    var table = $('#dt-empleados').DataTable({
        filter:false,  
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dt.row.data.evalEmpleadosTemp') }}",
            data: function (d) {
               
            }
        },
        columns: [
            {data: 'nombreUnidad', name: 'nombreUnidad',orderable: false, searchable: false},
            {data: 'nombresEmpleado', name: 'Emp.nombresEmpleado'},
            {data: 'apellidosEmpleado', name: 'apellidosEmpleado'},
            {data: 'nombrePlaza', name: 'nombrePlaza'}, 
            {data: 'fechaInicioPruebas', name: 'fechaInicioPruebas', orderable: false, searchable: false}, 
            {data: 'fechaFinPruebas', name: 'fechaFinPruebas', orderable: false, searchable: false},           
            {data: 'evaluacion', name: 'evaluacion', orderable: false, searchable: false}            
        ],
        language: {
            "sProcessing": '<div class=\"dlgwait\"></div>',
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
            
            
        },
        columnDefs: [
            {
              
                "visible": false
            }
        ],
        order: [[1, 'asc']]
        
    }); //end Datatable

});
</script>
@endsection