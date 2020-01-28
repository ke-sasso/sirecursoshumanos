
@extends('master')
{{-- CSS ESPECIFICOS --}}
@section('css')
{!! Html::style('plugins/bootstrap-fileinput/css/fileinput.min.css') !!}


{{-- Bootstrap Modal --}}

<style>
.kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    text-align: center;
}
.kv-avatar .file-input {
    display: table-cell;
    max-width: 220px;
}
</style>
@endsection

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
{{-- MENSAJE DE EXITO --}}
@if(Session::has('msnExito'))
	<div class="alert alert-success square fade in alert-dismissable">
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<strong>Enhorabuena!</strong>
		{{ Session::get('msnExito') }}
	</div>
@endif
{{-- MENSAJE DE ERROR --}}
@if(Session::has('msnError'))
	<div class="alert alert-danger square fade in alert-dismissable">
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<strong>Auchh!</strong>
		Algo ha salido mal.	{{ Session::get('msnError') }}
	</div>
@endif
	<!-- BEGIN FORM WIZARD -->
					<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
								<label class="text-warning">Los campos con asterico (*) son requeridos</label>
								</div>
							</div>
						</div>
		    <form id="infoGeneral" method="post" enctype="multipart/form-data" action="{{route('post.nuevo.empleado')}}">
					<div class="panel with-nav-tabs panel-success">
					  <div class="panel-heading">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#wizard-1-step1" data-toggle="tab"><i class="fa  fa-sign-in"></i>Paso 1</a></li>
							<li><a href="#wizard-1-step2" data-toggle="tab"><i class="fa fa-sign-in"></i> Paso 2</a></li>
							<li><a href="#wizard-1-step3" data-toggle="tab"><i class="fa fa-check"></i> Paso 3</a></li>
						</ul>
					  </div>
						<div id="panel-collapse-1" class="collapse in">
							<div class="tab-content">
								<div class="tab-pane fade in active" id="wizard-1-step1">
									<div class="panel-body">
										<div class="row">
							<div class="col-md-3" align="center">
								<div class="kv-avatar center-block" style="width:200px">
							        <input id="fileAvatar" name="fileAvatar" type="file" accept="image/x-png,image/gif,image/jpeg" class="file-loading" > 
							    </div>
							</div>
							<div class="col-md-9">
							   	<div class="row">
												<div class="col-md-6">
											
													<label>* Código Empleado:</label>
													<input name="txtCodEmpleado" type="number" maxlength="11" class="form-control"  autocomplete="off" min="0">
												</div>
												<div class="col-md-6">
													<label>* Sexo:</label>
												{!! Form::select('cmbSexo', ['M' => 'Masculino', 'F' => 'Femenino'],'M',['class' => 'form-control','id' => 'cmbSexo']) !!}
													
												</div>

								</div>	
								<div class="row">
									<div class="col-md-6">
										<label>* Nombres:</label>
											<input name="txtNombres" placeholder="Nombres del empleado" type="text" class="form-control" autocomplete="off">
									</div>
									<div class="col-md-6">
										<label>* Apellidos :</label>
										<input name="txtApellidos" placeholder="Apellidos del empleado" type="text" class="form-control" autocomplete="off"> 
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>* Fecha Nacimiento:</label>
										<input type="text" name="txtFechaNacimiento"  id="txtFechaNacimiento"  class="form-control datepicker date_masking" placeholder="yyyy-mm-dd"  /> 
										
									</div>
									<div class="col-md-6">
										<label>* Correo Electrónico:</label>
										<input type="email" name="txtEmail" placeholder="Correo electrónico del empleado" type="text" class="form-control"  autocomplete="off"/>
									</div>

								</div>

								<div class="row">
									<div class="col-md-6">
										<label>Teléfono fijo:</label>
										<input name="txtTelFijo" type="text" class="form-control phone_sv_masking" placeholder="0000-0000" maxlength="9" autocomplete="off">
									</div>
									<div class="col-md-6">
										<label>Teléfono movil:</label>
										<input name="txtTelMovil" type="text" class="form-control phone_sv_masking" placeholder="0000-0000" maxlength="9" autocomplete="off">
									</div>
								</div>
								<div class="row">
								<div class="col-md-6">
										<label>* DUI:</label>
										 <input type="text" name="txtDUI" class="form-control dui_masking" placeholder="00000000-0" maxlength="10" autocomplete="off">
										
									</div>
									<div class="col-md-6">
										<label>* NIT:</label>
										<input type="text" name="txtNIT" class="form-control nit_sv_masking" placeholder="0000-000000-000-0" maxlength="17" autocomplete="off" >
										
									</div>
 									
								</div>
								<div class="row">
									            <div class="col-md-6">
													<label>ISSS:</label>
													<input type="text" name="txtISSS" placeholder="Número del ISSS" class="form-control" maxlength="45" autocomplete="off" >
												</div>

												<div class="col-md-6">
													<label>AFP:</label>
													<input type="text" name="txtAFP" placeholder="Número de AFP"  maxlength="20" class="form-control" autocomplete="off">
												</div>
								</div>
								</div>
								</div>
									</div><!-- /.panel-body -->
									<div class="panel-footer text-right">
									<a class="btn btn-warning NextStep">Siguiente <i class="fa fa-angle-right"></i></a>
									</div>
								</div>
								<div class="tab-pane fade" id="wizard-1-step2">
									<div class="panel-body">
										<div class="row">
									<div class="col-md-12">
										<label>* Dirección residencia:</label>
										<textarea name="txtDireccion" class="form-control" cols="2" placeholder="Dirección de residencia del empleado"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>* Departamento residencia:</label>
										 {{Form::select('txtDepartamento', $listaDept,1,['class' => 'form-control', 'id' => 'txtDepartamento'])}}
										
									</div>
									<div class="col-md-6">
										<label>* Municipio residencia:</label>
										{{Form::select('txtMunicipio', $listaMun,1,['class' => 'form-control', 'id' => 'txtMunicipio'])}}
										
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-12">
										<label>* Dirección residencia según DUI:</label>
										<textarea name="txtDireccionDUI" class="form-control" cols="2" placeholder="Dirección de residencia según DUI del empleado"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>* Departamento residencia según DUI:</label>
										 {{Form::select('txtDepartamentoDUI', $listaDept,1,['class' => 'form-control', 'id' => 'txtDepartamentoDUI'])}}
										
									</div>
									<div class="col-md-6">
										<label>* Municipio residencia según DUI:</label>
										{{Form::select('txtMunicipioDUI', $listaMun,1,['class' => 'form-control', 'id' => 'txtMunicipioDUI'])}}
										
									</div>
								</div>
								
									</div><!-- /.panel-body -->
									<div class="panel-footer">
										<div class="row">
											<div class="col-sm-6">
												<a class="btn btn-warning PrevStep"><i class="fa fa-angle-left"></i> Regresar</a>
											</div><!-- /.col-sm-6 -->
											<div class="col-sm-6 text-right">
												<a class="btn btn-warning NextStep">Siguiente <i class="fa fa-angle-right"></i></a>
											</div><!-- /.col-sm-6 -->
										</div><!-- /.row -->
									</div><!-- /.panel-footer -->
								</div>
								<div class="tab-pane fade" id="wizard-1-step3">
									<div class="panel-body">
										<div class="row">
												<div class="col-md-6">
													<label>* Plaza Funcional:</label>
                                        <select name="idPlazaFun" id="idPlazaFun" style="width:487px" class="form-control select_plaza js-states">
                                        <option></option>
                                         </select>
                                         <select class="js-source-states" style="visibility: hidden">
				                         @foreach($plazasFun as $fun)

	                                           <option value="{{$fun->idPlazaFuncional}}"> {{$fun->nombrePlaza}} - 
	                                           <?php echo substr($fun->fechaInicial, 0,4); ?></option>
                                           @endforeach
                        				</select>
												
												</div>
												<div class="col-md-6">
													<label>* Plaza Nominal:</label>
													 <select name="idPlazaNom" id="idPlazaNom" class="form-control select_plaza2 js-states2" style="width:487px">
													 <option></option>
													 </select>
                                        
			                                         <select class="js-source-states2" style="visibility: hidden">
			                                          @foreach($plazasNom as $nom)
				                                
				                                          <option value="{{$nom->idPlazaNominal}}"> {{$nom->nombrePlazaNominal}}</option>
			                                        @endforeach
			                                         </select>
												</div>
								</div>
							    <div class="row">
							           <div class="col-md-6">
													<label>Banco:</label>
													<?php
													array_add($bancos, 0, 'SELECCIONE UN BANCO...');
													?>
						 							{{Form::select('txtBanco', $bancos,0,['class' => 'form-control', 'id' => 'txtBanco'])}}  
												</div>
												<div class="col-md-6"> 

													<label>Cuenta Bancaria:</label>
                                         			<input name="txtCtaBancaria" placeholder="Número de cuenta bancaria" type="text"  class="form-control" placeholder=""  autocomplete="off">
												
												</div>
								  </div>
								  <div class="row">
								         <div class="col-md-6">
													<label>Pasaporte:</label>
                                         			<input name="txtPasaporte" type="text" max="45" class="form-control" placeholder=""  autocomplete="off">
												
												</div>
										<div class="col-md-6">
													<label>Salario:</label>
										<input type="number" min="0"  step="1" name="txtSalario" id="txtSalario" class="form-control" value="0">
												</div>
								  </div>
								    <div class="row">
									<div class="col-md-6">
										<label>Fecha inicio contrato:</label>
										<input type="text" name="inicioContrato"  id="inicioContraro"  class="form-control datepicker date_masking" placeholder="yyyy-mm-dd"  /> 
										
									</div>
									<div class="col-md-6">
										<label>Fecha fin contrato:</label>
										<input type="text" name="finContrato"  id="finContrato"  class="form-control datepicker date_masking" placeholder="yyyy-mm-dd"  /> 
									</div>

								  </div>
									<div class="row">
								  	<div class="col-md-6">
								  		<label>Clasificación Empleado:</label>
								  		<select id="cmbClasificacionEmpleado" name="cmbClasificacionEmpleado[]" class="" multiple>
								  		@foreach($clasificacionEmpleados as $ce)
								  			<option value="{{$ce->idClasificacion}}">{{$ce->nombreClasificacion}}</option>
								  		@endforeach

								  		</select>
								  	</div>
								  	<div class="col-md-6">
								  	<label>Estado Laboral:</label>
								  		<select id="cmbEstadoLaboral" name="cmbEstadoLaboral" class="form-control">
								  		<option value="0">Selecciona una opción</option>
								  		@foreach($estadosLaborales as $el)
								  			<option value="{{$el->idEstadoLabor}}">{{$el->descripcionLaboral}}</option>
								  		@endforeach

								  		</select>
								  	</div>
								  </div>
								  <div class="row">
								             <div class="col-md-4">
													<label>* Asegurado:</label>
											{!! Form::select('cmbAsegurado', [0 => 'NO', 1 => 'SI'],0,['class' => 'form-control','id' => 'cmbAsegurado']) !!}
												</div>
												<div class="col-md-4">
													<label>* Tipo contratación:</label>
													<select id="cmbTipoContrato" name="cmbTipoContrato" class="form-control" onchange="tipoDeContrato();">
														@foreach($tiposContratos as $tc)
														<option value="{{$tc->idTipoContrato}}">{{$tc->nombreTipoContrato}}</option>
														@endforeach
														
													</select>
												</div>
												<div class="col-md-4">
													<label>* Estado empleado:</label>
										{!! Form::select('cmbEstadoEmp', [1 => 'Activo', 2 => 'Inactivo' , 3 => 'Suspendido'],1,['class' => 'form-control','id' => 'cmbEstadoEmp']) !!}
											
												</div>
								  </div>
								  <div class="row" id="datosDePrueba" name="datosDePrueba">
									<div class="col-md-6">
										<label>Fecha inicio pruebas:</label>
										<input type="text" name="inicioPruebas"  id="inicioPruebas"  class="form-control datepicker date_masking" placeholder="yyyy-mm-dd"  /> 
										
									</div>
									<div class="col-md-6">
										<label>Fecha fin pruebas:</label>
										<input type="text" name="finPruebas"  id="finPruebas"  class="form-control datepicker date_masking" placeholder="yyyy-mm-dd"  /> 
									</div>

								  </div>
									</div><!-- /.panel-body -->
									<div class="panel-footer">
										<div class="row">
											<div class="col-sm-6">
												<a class="btn btn-warning PrevStep"><i class="fa fa-angle-left"></i> Regresar</a>
											</div><!-- /.col-sm-6 -->
											<div class="col-sm-6 text-right">
											 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                              <button type="submit" class="btn btn-warning">Guardar <i class="fa fa-check"></i></button>
												
											</div><!-- /.col-sm-6 -->
										</div><!-- /.row -->
									</div><!-- /.panel-footer -->
								</div>
							</div><!-- /.tab-content -->
						</div><!-- /.collapse in -->
					</div><!-- /.panel .panel-success -->
					</form>
					<!-- END FORM WIZARD -->
	<!--
		<form id="infoGeneral" method="post" enctype="multipart/form-data" action="{{route('post.nuevo.empleado')}}">
		<div class="tab-content">
			<div id="datos-personales">
				<div class="panel-body">
				
					<div id="kv-avatar-errors" class="center-block" style="width:800px;display:none"></div>
					
						
					
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
								<label class="text-warning">Los campos con asterico (*) son requeridos</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3" align="center">
								<div class="kv-avatar center-block" style="width:200px">
							        <input id="fileAvatar" name="fileAvatar" type="file" accept="image/x-png,image/gif,image/jpeg" class="file-loading" > 
							    </div>
							</div>
							<div class="col-md-9">
							   	<div class="row">
												<div class="col-md-6">
											
													<label>* Código Empleado:</label>
													<input name="txtCodEmpleado" type="number" maxlength="11" class="form-control"  autocomplete="off" min="0">
												</div>
												<div class="col-md-6">
													<label>* Sexo:</label>
												{!! Form::select('cmbSexo', ['M' => 'Masculino', 'F' => 'Femenino'],'M',['class' => 'form-control','id' => 'cmbSexo']) !!}
													
												</div>

								</div>	
								<div class="row">
									<div class="col-md-6">
										<label>* Nombres:</label>
											<input name="txtNombres" placeholder="Nombres del empleado" type="text" class="form-control" autocomplete="off">
									</div>
									<div class="col-md-6">
										<label>* Apellidos :</label>
										<input name="txtApellidos" placeholder="Apellidos del empleado" type="text" class="form-control" autocomplete="off"> 
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>* Fecha Nacimiento:</label>
										<input type="text" name="txtFechaNacimiento"  id="txtFechaNacimiento"  class="form-control datepicker date_masking" placeholder="yyyy-mm-dd"  /> 
										
									</div>
									<div class="col-md-6">
										<label>* Correo Electrónico:</label>
										<input type="email" name="txtEmail" placeholder="Correo electrónico del empleado" type="text" class="form-control"  autocomplete="off"/>
									</div>

								</div>

								<div class="row">
									<div class="col-md-6">
										<label>Teléfono fijo:</label>
										<input name="txtTelFijo" type="text" class="form-control phone_sv_masking" placeholder="0000-0000" maxlength="9" autocomplete="off">
									</div>
									<div class="col-md-6">
										<label>Teléfono movil:</label>
										<input name="txtTelMovil" type="text" class="form-control phone_sv_masking" placeholder="0000-0000" maxlength="9" autocomplete="off">
									</div>
								</div>


								<div class="row">
									<div class="col-md-12">
										<label>* Dirección residencia:</label>
										<textarea name="txtDireccion" class="form-control" cols="2" placeholder="Dirección de residencia del empleado"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>* Departamento residencia:</label>
										 {{Form::select('txtDepartamento', $listaDept,1,['class' => 'form-control', 'id' => 'txtDepartamento'])}}
										
									</div>
									<div class="col-md-6">
										<label>* Municipio residencia:</label>
										{{Form::select('txtMunicipio', $listaMun,1,['class' => 'form-control', 'id' => 'txtMunicipio'])}}
										
									</div>
								</div>
								<div class="row">
								<div class="col-md-6">
										<label>* DUI:</label>
										 <input type="text" name="txtDUI" class="form-control dui_masking" placeholder="00000000-0" maxlength="10" autocomplete="off">
										
									</div>
									<div class="col-md-6">
										<label>* NIT:</label>
										<input type="text" name="txtNIT" class="form-control nit_sv_masking" placeholder="0000-000000-000-0" maxlength="17" autocomplete="off" >
										
									</div>
 									
								</div>
								<div class="row">
									            <div class="col-md-6">
													<label>* ISSS:</label>
													<input type="text" name="txtISSS" placeholder="Número del ISSS" class="form-control" maxlength="45" autocomplete="off" >
												</div>

												<div class="col-md-6">
													<label>* AFP:</label>
													<input type="text" name="txtAFP" placeholder="Número de AFP"  maxlength="20" class="form-control" autocomplete="off">
												</div>
								</div>
							
							    <div class="row">
							           <div class="col-md-6">
													<label>Banco:</label>
													<?php
													array_add($bancos, 0, 'SELECCIONE UN BANCO...');
													?>
						 							{{Form::select('txtBanco', $bancos,0,['class' => 'form-control', 'id' => 'txtBanco'])}}  
												</div>
												<div class="col-md-6"> 

													<label>Cuenta Bancaria:</label>
                                         			<input name="txtCtaBancaria" placeholder="Número de cuenta bancaria" type="text"  class="form-control" placeholder=""  autocomplete="off">
												
												</div>
								  </div>
								  <div class="row">
								         <div class="col-md-6">
													<label>Pasaporte:</label>
                                         			<input name="txtPasaporte" type="text" max="45" class="form-control" placeholder=""  autocomplete="off">
												
												</div>
										<div class="col-md-6">
													<label>Salario:</label>
										<input type="number" min="0"  step="1" name="txtSalario" id="txtSalario" class="form-control" value="0">
												</div>
								  </div>
								    <div class="row">
									<div class="col-md-6">
										<label>Fecha inicio contrato:</label>
										<input type="text" name="inicioContrato"  id="inicioContraro"  class="form-control datepicker date_masking" placeholder="yyyy-mm-dd"  /> 
										
									</div>
									<div class="col-md-6">
										<label>Fecha fin contrato:</label>
										<input type="text" name="finContrato"  id="finContrato"  class="form-control datepicker date_masking" placeholder="yyyy-mm-dd"  /> 
									</div>

								  </div>
							
								  <div class="row">
								             <div class="col-md-4">
													<label>* Asegurado:</label>
											{!! Form::select('cmbAsegurado', [0 => 'NO', 1 => 'SI'],0,['class' => 'form-control','id' => 'cmbAsegurado']) !!}
												</div>
												<div class="col-md-4">
													<label>* Tipo contratación:</label>
											{!! Form::select('cmbTipoContrato', [1 => 'Permanente', 2 => 'Temporal', 3 => 'Interino'],1,['class' => 'form-control','id' => 'cmbTipoContrato']) !!}
												</div>
												<div class="col-md-4">
													<label>* Estado empleado:</label>
										{!! Form::select('cmbEstadoEmp', [1 => 'Activo', 2 => 'Inactivo' , 3 => 'Suspendido'],1,['class' => 'form-control','id' => 'cmbEstadoEmp']) !!}
											
												</div>
								  </div>
								
								
						
							</div>
						</div>
					
				</div> 
				<div class="panel-footer text-center">
				 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <button type="submit" class="btn btn-primary btn-perspective">GUARDAR <i class="fa fa-check"></i></button>
				</div>
			</div>
			</form>
-->

	
	
@endsection

{{-- JS ESPECIFICOS --}}
@section('js')
<script src="assets/plugins/validator/example.js"></script>
{!! Html::script('plugins/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js') !!}
{!! Html::script('plugins/bootstrap-fileinput/js/fileinput.min.js') !!}
{!! Html::script('plugins/bootstrap-fileinput/js/fileinput_locale_es.js') !!}
 {!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!} 

{{-- Bootstrap Modal --}}

<script>
function tipoDeContrato(){
	var tipoContrato = $('#cmbTipoContrato option:selected').val();

	if(tipoContrato==4){//Contrato Tipo Pruebas

		$('#datosDePrueba').show();
	}else{

		$('#datosDePrueba').hide();
	}
}
$(document).ready(function(){
	$('#cmbClasificacionEmpleado').selectize({
		create: false
	});

	//inicialmente estan ocultas las fechas de pruebas
		$('#datosDePrueba').hide();

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

       $("#txtDepartamento").on('change',function(){
    	$.ajax({
    		data: {_token:'{{ csrf_token() }}',deparamento:this.value},
    		url: "{{ url('/urh/getMunicipiosEmpleado') }}",
    		type: 'post',
    		beforeSend: function() {
				$("#txtMunicipio").prop("disabled",true);
			},
            success:  function (response){
            	$("#txtMunicipio").html(response);
            	$("#txtMunicipio").prop("disabled",false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            	$("#txtMunicipio").prop("disabled",false);
              	console.log("Error en peticion AJAX!");  
            }
    	});
   	    });

		 $("#txtDepartamentoDUI").on('change',function(){
    	$.ajax({
    		data: {_token:'{{ csrf_token() }}',deparamento:this.value},
    		url: "{{ url('/urh/getMunicipiosEmpleado') }}",
    		type: 'post',
    		beforeSend: function() {
				$("#txtMunicipioDUI").prop("disabled",true);
			},
            success:  function (response){
            	$("#txtMunicipioDUI").html(response);
            	$("#txtMunicipioDUI").prop("disabled",false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            	$("#txtMunicipioDUI").prop("disabled",false);
              	console.log("Error en peticion AJAX!");  
            }
    	});
   	    });

	$("#fileAvatar").fileinput({
		language: "es",
	    overwriteInitial: true,
	    maxFileSize: 1500,
	    showClose: false,
	    showCaption: false,
	    browseLabel: '',
	    removeLabel: '',
	    browseIcon: '<i class="fa fa-folder-open"></i>',
	    removeIcon: '<i class="fa fa-times"></i>',
	    removeTitle: 'Cancelar o resetear cambios',
	    elErrorContainer: '#kv-avatar-errors',
	    msgErrorClass: 'alert alert-block alert-danger',
	    defaultPreviewContent: '<img src="{{ asset('img/avatar/default_avatar_male.jpg') }}" alt="Imagen por defecto" style="width:160px">',
	    layoutTemplates: {main2: '{preview} {remove} {browse}'},
	    allowedFileExtensions: ["jpg", "png", "gif"]
	});
	 var $states = $(".js-source-states");
                    var statesOptions = $states.html();
                    $states.remove();
                    $(".js-states").append(statesOptions);
                    $(".select_plaza").select2({
                        placeholder: "Seleccione una plaza funcional...",
                        allowClear: true
                    });
      var $states = $(".js-source-states2");
                    var statesOptions = $states.html();
                    $states.remove();
                    $(".js-states2").append(statesOptions);
                    $(".select_plaza2").select2({
                        placeholder: "Seleccione una plaza nominal...",
                        allowClear: true
                    });
	

    
    
    $('#infoGeneral').submit(function(e){
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
	        		alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Información general registrada de forma exitosa!</p></strong>",function(){
	        			var obj =  JSON.parse(response);
	        			   window.location.href =  "{{ url('urh/verExpediente') }}/"+obj.id;
	        			 
	        		});
	        	}else{
	        		alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
	        	}
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
				$('body').modalmanager('loading');
				alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la información general de esta persona!</p></strong>");
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
