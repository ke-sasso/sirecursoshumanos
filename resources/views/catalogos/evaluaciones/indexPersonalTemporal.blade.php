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


<!--<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<a href="{{route('insertar.evaluacionTemporal')}}" style="" type="button" id="cancelar" class="btn btn-primary m-t-10"><i class="fa fa-plus" aria-hidden="true"></i>Nueva evaluaci&oacute;n</a>
	</div>
</div> -->


<div class="the-box">
	<div class="table-responsive">
		<table class="table table-striped table-hover"  id="tr-Evaluacion" style="font-size:12.5px;" width="100%">
			<thead class="the-box dark full">
				<tr>
					<th>CORRELATIVO</th>
	                <th width="60%">NOMBRE</th>
	                <th>ESTADO</th>
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
 {!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}

<script>

$( document ).ready(function() {

    var table = $('#tr-Evaluacion').DataTable({
        filter:true,
        processing: true,
        serverSide: false,

        ajax: {
            url: "{{route('dt.row.data.evaluacionTemp')}}",
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
             "targets": [0,3]
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
       
</script>
@endsection