@extends('master')
@section('css')
{!! Html::style('plugins/selectize-js/dist/css/selectize.bootstrap3.css') !!} 
<style type="text/css">
	.text-uppercase
	{
		text-transform: uppercase;
	}
</style>
@endsection
@section('contenido')
	
	<div class="modal fade" id="modal-id">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="frmCapacitacion">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<div class="modal-header bg-success">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Crear Plan de Capacitaciones</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="input-group">
									<div class="input-group-addon">Nombre Capacitación</div>
									<input type="text" class="form-control text-uppercase" name="nombreCapacitacion" id="nombreCapacitacion" >
								</div>

							</div>
							

						</div>
						<br>
						<br>
						<div class="form-group">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="input-group-addon">Entidad que la imparte</div>
		         <select name="entidad"  placeholder="Ingrese el nombre de la entidad" id="entidad" style="width: 100%;"  class="form-control"></select>
						
							</div>
							
						</div>
						<br>
						<br>
						<br>
						<br>
						<div class="form-group">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="input-group">
									<div class="input-group-addon">Instructor que la imparte</div>
									<input type="text" class="form-control text-uppercase" name="instructor" id="instructor" >
								</div>
							</div>
							
						</div>
						<br>
						<br>
						<div class="form-group">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="input-group">
									<div class="input-group-addon">Lugar donde se desarroll&oacute;</div>
									<textarea  type="text" class="form-control text-uppercase" name="lugar" id="lugar"></textarea>
								</div>
							</div>
							
						</div>
						<br>
						<br>
						<br>
						<div class="form-group">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="input-group">
									<div class="input-group-addon">Fecha Desde</div>
					 <input type="text" class="form-control datepicker date_masking" placeholder="yyyy-mm-dd" id="fechaDesde" name="fechaDesde">
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="input-group">
									<div class="input-group-addon">Fecha Hasta</div>
			   <input type="text" class="form-control datepicker date_masking" placeholder="yyyy-mm-dd" id="fechaHasta" name="fechaHasta" >
								</div>
							</div>
						</div>
						<br>
						<br>
						<div class="form-group">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="input-group">
									<div class="input-group-addon">Evaluación de Desempeño</div>
									<select name="idEvaluacion" id="idEvaluacion" class="form-control">
										
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="button" id="btnSend" class="btn btn-primary">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
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
            <form role="form" id="search-form" >
               <div class="row">
                    <div class="form-group col-sm-5 col-xs-12 col-md-6 col-lg-6">
                        <label>Nombre evaluación</label>
	                    <input type="text" name="nombre" id="nombre" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-sm-5 col-xs-12 col-md-6 col-lg-6">
                        <label>Evaluación</label>
                          <select class="form-control" name="evaluacion" id="evaluacion" >
                            <option value="" selected>Seleccione una evaluacion...</option>
                            @foreach($eva as $e)
                            	<option value="{{$e->idEvaluacion}}">{{$e->nombre}}</option>
                            @endforeach
                            </select>
                    </div>
               </div>
               <div class="row">
                    
                    <div class="form-group col-sm-6 col-xs-12">
                        <label>Fecha Desde:</label>
                       <input type="text" name="fechai"  id="fechai" class="form-control datepicker date_masking" placeholder="yyyy-mm-dd" maxlength="10"  data-date-format="yyyy-mm-dd"  autocomplete="off">        
                    </div>
                      <div class="form-group col-sm-6 col-xs-12">
                        <label>Fecha Hasta:</label>
                       <input type="text" name="fechaf"  id="fechaf" class="form-control datepicker date_masking" placeholder="yyyy-mm-dd" maxlength="10"  data-date-format="yyyy-mm-dd"  autocomplete="off">        
                    </div>


                    
               </div>
                    
                <div class="modal-footer" >
                    <div align="center">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
                  <button type="submit"  class="btn btn-success btn-perspective"><i class="fa fa-search"></i> Buscar</button>
                           </div>
                        </div>
                    
                    
            </form>
            {{-- /.COLLAPSE CONTENT --}}
        </div><!-- /.panel-body -->
    </div><!-- /.collapse in -->

    
</div>
	<div class="panel panel-primary">

		<div class="panel-heading">
			<div class="right-content">
				<a class="btn btn-primary" data-toggle="modal" href='#modal-id'><i class="fa fa-plus"></i>Crear</a>			
			</div>
			<h3 class="panel-title">Capacitaciones</h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover" id="dt-capacitaciones">
					<thead>
						<tr>
							<th></th>
							<th>Nombre Capacitación</th>
							<th>Fecha Desde</th>
							<th>Fecha Hasta</th>
							<th>Evaluación</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
@section('js')
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
<script type="text/javascript">
	$(document).ready(function() {
		$('#fechaDesde').mask('0000-00-00');
		$('#fechaHasta').mask('0000-00-00');
		
	});

 var estName = $('#entidad').selectize({
							        valueField: 'idInstitucion',
							        labelField: 'nombreInstitucion',        
							        searchField: 'nombreInstitucion',
							        maxOptions: 10,
							        options: [],
							        create: false,
							        render: {
							            option: function(item, escape) {
							                return '<div>' +escape(item.nombreInstitucion) +' ('+escape(item.nombrePais) +')</div>';
							              }
							        },
							        load: function(query, callback) {
							                if (!query.length) return callback();
							                $.ajax({
							                    url: "{{route('data.institucionesBuscar.empleado')}}",
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


	var dtcapacitaciones =	$('#dt-capacitaciones').DataTable(
	{
			processing: true,
			serverSide: true,
			filter: false,
			ajax: {
				'url': "{{route('list.capacitaciones.rh')}}",
		         data: function (d) {
		                d.nombre= $('#nombre').val();
		                d.evaluacion= $('#evaluacion').val();
		                d.fechai= $('#fechai').val();
		                d.fechaf= $('#fechaf').val();
		            }
			},
			columns: [				
				{data: 'row', name: 'row'},
				{data: 'nombreCapacitacion', name: 'nombreCapacitacion'},
				{data: 'fechaDesde', name:'fechaDesde'},
				{data: 'fechaHasta', name:'fechaHasta'},
				{data: 'nombre', name:'nombre'},
				{data: 'editar', name: 'editar',searchable:false,orderable:false},
			],
		    language: {
		        "sProcessing": '<div class=\"dlgwait\"></div>',
		        "url": "{{ asset('plugins/datatable/lang/es.json') }}"
		        
		        
		    },
			"order": [[ 0, 'asc' ]]
			
	});
		  $('#search-form').on('submit', function(e) {

	        dtcapacitaciones.draw();
	        e.preventDefault();
	        $("#colp").attr("class", "block-collapse collapsed");
	        $("#collapse-filter").attr("class", "collapse");
	    });
		   dtcapacitaciones.rows().remove();

	$.get('{{route('edc.evaluaciones.rh')}}', function(data) {
		try
		{
			$('#idEvaluacion option').remove();
			$('#idEvaluacion').append('<option value="">-- Seleccionar --</option>');
			$.each(data, function(index, val) {
				$('#idEvaluacion').append('<option value="'+val.idEvaluacion+'">'+val.nombre+' - '+val.periodo+'</option>')				 
			});
		}	
		catch(e)
		{
			console.log(e);
		}	
	});

	$('#btnSend').on('click', function(event) {
		event.preventDefault();
		$('#frmCapacitacion :input').each(function(index, el) {
				$(this).parent().removeClass('has-error');
		});
		$.ajax({
			url: '{{route('new.capacitaciones.rh')}}',
			type: 'POST',
			dataType: 'JSON',
			data: $('#frmCapacitacion').serialize(),
		})
		.done(function(response) {
			try {
					
					if(response.status == 200)
					{
						alertify.alert('Mensaje del Sistema',response.message,function(){location.reload();});
						
					}
					else {
						alertify.alert('Mensaje del Sistema',response.message);
					}

			} catch(e) {
				// statements
				console.log(e);
			}
		})
		.fail(function(r) {
			if(r.status == 422)
			{
				var texto = '';
				$.each(r.responseJSON, function(index, val) {
					 texto += val[0]+'<br>';
					 $('#'+index).parent().addClass('has-error');
				});
				alertify.alert('Mensaje del Sistema',texto);
			}
			else
			{
				var mensajes = ''
				$.each(r, function(index, val) {
					mensajes += val+'<br>';					
				});				

				alertify.alert('Mensaje del Sistema',mensajes);
			}
		})
		.always(function() {
			console.log("complete");
		});
		
	});

</script>
@endsection
