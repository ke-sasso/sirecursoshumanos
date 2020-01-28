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
            B&uacute;squeda Avanzada de Permisos
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
                     <div class="form-group col-sm-3 col-xs-12">
              
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Fecha Inicio:</label>
                       <input type="text" name="fechaInicio"  id="fechaInicio" class="form-control datepicker date_masking" placeholder="yyyy-mm-dd" maxlength="10" data-date-format="yyyy-mm-dd"  autocomplete="off" >        
                    </div>

                    <div class="form-group col-sm-3 col-xs-12">
                             <label>Fecha Fin:</label>
                             <input type="text" name="fechaFin"  id="fechaFin" class="form-control datepicker date_masking" placeholder="yyyy-mm-dd" maxlength="10" autocomplete="off"  data-date-format="yyyy-mm-dd"  title="La fecha inicial debe ser menor que la fecha final" oninput="validate()">
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
    

				        <th width="58" align="left">CORRELATIVO</th>
                <th>NOMBRE</th>
                <th>PERIODO</th>
                <th>DESCRIPCIÓN</th>
                <th>FECHA INICIO</th>
                <th>FECHA FIN</th>
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
function validate() {
    var fin=     document.getElementById('fechaFin').value;
     var inicio = document.getElementById('fechaInicio').value;

     var i = new Date(inicio);
     var f = new Date(fin);
    if(f<i) 
        document.getElementById('fechaFin').setCustomValidity('Esta fecha debe ser mayor a la fecha inicial');
    else 
        document.getElementById('fechaFin').setCustomValidity('');
}
$( document ).ready(function() {
     
    

    var table = $('#tr-permisos').DataTable({
        filter:false,
        processing: true,
        serverSide: true,

        ajax: {
            url: "{{route('dt.row.data.evaluaciones')}}",
             data: function (d) {
                d.unidad= $('#nombre').val();
                d.fechaInicio= $('#fechaInicio').val();
                d.fechaFin= $('#fechaFin').val();
              
            }
        },
        columns: [
	      	{ "data": null }, // <-- This is will your index column
          {data: 'nombre', name: 'nombre'},
          {data: 'periodo', name: 'periodo'},
        {data: 'descripcion', name: 'descripcion'},
          {data: 'fechaInicio', name: 'fechaInicio'},
          {data: 'fechaFin', name: 'fechaFin'},
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
            "targets": [0,3,6]
        } ],

        "order": [[ 4, 'desc' ]]
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

       
</script>
@endsection
