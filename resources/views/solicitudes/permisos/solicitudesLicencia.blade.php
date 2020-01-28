@extends('master')

@section('css')
{!! Html::style('plugins/bootstrap-modal/css/bootstrap-modal.css') !!}
{!! Html::style('plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') !!}
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
                    <div class="form-group col-sm-5 col-xs-12 col-md-12 col-lg-12">
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
                       
                    <div class="form-group col-sm-6 col-xs-6">
                        <label>Fecha Inicio:</label>
                       <input type="text" name="fechaInicio"  id="fechaInicio" class="form-control  datepicker date_masking" placeholder="yyyy-mm-dd" maxlength="10"  data-date-format="yyyy-mm-dd"  autocomplete="off">        
                    </div>
                       <div class="form-group col-sm-6 col-xs-6">
                        <label>Fecha Fin:</label>
                       <input type="text" name="fechaFin"  id="fechaFin" class="form-control  datepicker date_masking" placeholder="yyyy-mm-dd" maxlength="10"  data-date-format="yyyy-mm-dd"  autocomplete="off">        
                    </div>


                    </div>
                    <div class="row">
                     <div class="form-group col-sm-6 col-xs-6">
                     <label>Seleccione:</label>
                          <select class="form-control" name="procesada" id="procesada" >
                            <option value="" selected>Seleccione...</option>
                                <option value="0">
                                  NO PROCESADA</option>
                                <option value="1">
                                  PROCESADA</option>
                            
                            </select>
                    </div>

                    <div class="form-group col-sm-6 col-xs-6">
                     <label>Tipo de Permiso:</label>
                          <select class="form-control" name="tipo" id="tipo" >
                            <option value="" selected>Seleccione...</option>
                                <option value="1">
                                  NO MARCACIÓN</option>
                                <option value="2">
                                  LICENCIA</option>
                            
                            </select>
                    </div>
               </div>
                    
                <div class="modal-footer" >
                    <div align="center">
                             <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" class="form-control"/>
                            
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
	<table class="table table-responsive table-hover"  id="tr-permisos" style="font-size:11px;" width="100%">
		<thead >
			<tr>
    

				        <th width="5%" align="left">CORRELATIVO</th>
                <th>TIPO</th>
                <th>MOTIVO</th>
                <th>FECHA PERMISO</th>
                <th>USUARIO</th>
                <th>COD. EMPLEADO</th>
                <th>UNIDAD</th>
				        <th>ESTADO</th>
                <th>-</th>
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
{!!Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js')!!}
@if(Session::has('msnExito'))
 <script type="text/javascript">
   alertify.success('¡EXITO! La solicitud de licencia fue procesada');
 </script>
@endif

<script>
   
function validate() {
    var inicio =document.getElementById('fechaFin').value;
     var fin = document.getElementById('fechaInicio').value;

     var i = new Date(inicio);
     var f = new Date(fin);
    if(i< f) 
        document.getElementById('fechaFin').setCustomValidity('Esta fecha debe ser mayor a la fecha inicial');
    else 
        document.getElementById('fechaFin').setCustomValidity('');
}
  var table;
$( document ).ready(function() {

    

     table = $('#tr-permisos').DataTable({
        filter:false,
        processing: true,
        serverSide: true,

        ajax: {
            url: "{{ route('dt.row.data.permisos.dnm') }}",
             data: function (d) {
                d.unidad= $('#unidad').val();
                d.fechaInicio= $('#fechaInicio').val();
                d.fechaFin= $('#fechaFin').val();
                d.procesada= $('#procesada').val();
                d.tipo= $('#tipo').val();
            }
        },
        columns: [
	      	{ "data": null }, // <-- This is will your index column
          {data: 'tipo', name: 'tipo'},
          {data: 'motivo', name: 'motivo'},
          {data: 'fechaCreacion', name: 'fechaCreacion'},
          {data: 'nombreEmpleado', name: 'nombreEmpleado'},
          {data: 'idEmpleadoCrea', name: 'idEmpleadoCrea'},
          {data: 'nombreUnidad', name: 'nombreUnidad',ordenable:false,searchable:false},
		      {data: 'estadoSol', name: 'estadoSol',ordenable:false,searchable:false},
          {data: 'procesado', name: 'procesado',ordenable:false,searchable:false},
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
            "targets": [0,7,8,9]
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
    table.ajax.reload();
});

function NoProcesar(idTipo,idSol,accion){
    
    var token =$('#_token').val();
    $.ajax({
            
            url:   "{{route('noprocesar.solicitud')}}",
            type:  'post',
            data:'idSolicitud='+idSol+'&idTipo='+idTipo+'&accion='+accion+'&_token='+token,
            beforeSend: function() {
               $('body').modalmanager('loading');
            },
            success:  function (r){
                $('body').modalmanager('loading');
                if(r.status == 200){
                   table.ajax.reload();
                  // table.ajax.reload(null,false);
                }
                else if (r.status == 400){
                    alertify.alert("Mensaje de sistema - Error",r.message);
                }else if(r.status == 401){
                    alertify.alert("Mensaje de sistema",r.message
                    );
                }else{
                    //Unknown
                    //alertify.alert("Mensaje de sistema","Este mandamiento no ha sido pagado o ya ha sido utilizado");
                }
            },
            error: function(data){
                // Error...
                var errors = $.parseJSON(data.responseText);
                console.log(errors);
                $.each(errors, function(index, value) {
                    $.gritter.add({
                        title: 'Error',
                        text: value
                    });
                });
            }
        });
}

       
</script>
@endsection
