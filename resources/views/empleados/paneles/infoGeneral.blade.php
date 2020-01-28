<form role="form" method="post" action="{{route('post.editar.empleado')}}" autocomplete="off" id="infoGeneral">
<div class="panel-body">
			<div class="panel with-nav-tabs panel-success">
					  <div class="panel-heading">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#wizard-1-step1" data-toggle="tab"><i class="fa   fa-user"></i> Datos personales</a></li>
							<li><a href="#wizard-1-step2" data-toggle="tab"><i class="fa  fa-map-marker"></i> Direcciones </a></li>
							<li><a href="#wizard-1-step3" data-toggle="tab"><i class="fa fa-briefcase"></i> Plaza </a></li>
						</ul>
					  </div>
						<div id="panel-collapse-1" class="collapse in">
							<div class="tab-content">
								<div class="tab-pane fade in active" id="wizard-1-step1">
									<div class="panel-body">
										<div class="row">
							<div class="col-md-3">
							<center><h4><span aling="center" class="label label-success"> Código Empleado: {{$persona->idEmpleado }} </span></h4></center>
							<input type="hidden" name="txtCodEmpleado" id="txtCodEmpleado" value="{{$persona->idEmpleado}}">
							<br>
													<div class="kv-avatar center-block" style="width:200px">
							       				 @if($img_e=='')
							       				 <div align="center">
 														<img src="{{ asset('img/avatar/default_avatar_male.jpg') }}" class="img-circle" alt="Imagen por defecto" style="width:160px">
 														</div>
 												@else
 												 <div class="polaroid">
													  <img onclick="mostrarFoto();" title="VER FOTOGRAFÍA" src="data:{{$persona->tipoImagen}};base64,{{$img_e}}"  alt="" width="220" height="200">
													  <div class="containerb">
													    <p>{{$persona->nombresEmpleado}} {{$persona->apellidosEmpleado}}</p>
													  </div>
													</div>
													 														
 												@endif		
 												 <div align="center">
												 <input type="file" id="file" name="file" accept="image/x-png,image/gif,image/jpeg" class="form-control file-loading" />
										         <div id="errorBlock" class="help-block"></div>
										         </div>
							    </div>
							</div>
							<div class="col-md-9">	
								<div class="row">
									<div class="col-md-6">
										<label>* Nombres:</label>
											<input name="txtNombres" type="text" class="form-control" autocomplete="off" value="{{$persona->nombresEmpleado}}" >
									</div>
									<div class="col-md-6">
										<label>* Apellidos :</label>
										<input name="txtApellidos" type="text" class="form-control" autocomplete="off" value="{{$persona->apellidosEmpleado}}"> 
									</div>
								</div>
								<div class="row">
												<div class="col-md-6">
													<label>* Nombres según ISSS:</label>
													<input name="txtNombresISSS" type="text" class="form-control" autocomplete="off" value="{{$persona->nombresISSS}}">
												</div>
												<div class="col-md-6">
													<label>* Apellidos según ISSS:</label>
													<input name="txtApellidosISSS" type="text" maxlength="45" class="form-control" autocomplete="off" value="{{$persona->apellidosISSS}}"> 
												</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>* Fecha Nacimiento:</label>
										<input type="date" name="txtFechaNacimiento"  id="txtFechaNacimiento"  class="form-control" placeholder="yyyy-mm-dd"  data-date-format="yyyy-mm-dd" value="{{$persona->fechaNacimiento}}"/> 
										
									</div>
									<div class="col-md-6">
										<label>* Correo Electrónico:</label>
										<input type="email" name="txtEmail" type="text" class="form-control"  autocomplete="off" value="{{$persona->email}}"/>
									</div>

								</div>

								<div class="row">
									<div class="col-md-6">
										<label>Teléfono fijo:</label>
										<input name="txtTelFijo" type="text" class="form-control phone_sv_masking" placeholder="0000-0000" maxlength="9" autocomplete="off" value="{{$persona->telefonoCasa}}">
									</div>
									<div class="col-md-6">
										<label>Teléfono movil:</label>
										<input name="txtTelMovil" type="text" class="form-control phone_sv_masking" placeholder="0000-0000" maxlength="9" autocomplete="off" value="{{$persona->celular}}">
									</div>
								</div>
								<div class="row">
								 <div class="col-md-6">
													<label>Pasaporte:</label>
                                         			<input name="txtPasaporte" type="text" max="45" class="form-control" placeholder=""  autocomplete="off" value="{{$persona->pasaporte}}">
												
												</div>
												<div class="col-md-6">
													<label>* Genero:</label>
												{!! Form::select('cmbSexo', ['M' => 'Masculino', 'F' => 'Femenino'],$persona->sexo,['class' => 'form-control','id' => 'cmbSexo']) !!}
													
												</div>
								</div>
								<div class="row">
								<div class="col-md-6">
										<label>* DUI:</label>
										 <input type="text" name="txtDUI" class="form-control dui_masking" placeholder="00000000-0" maxlength="10" autocomplete="off" value="{{$persona->dui}}" readonly>
										
									</div>
									<div class="col-md-6">
										<label>* NIT:</label>
										<input type="text" name="txtNIT" class="form-control nit_sv_masking" placeholder="0000-000000-000-0" minlength="17" autocomplete="off" value="{{$persona->nit}}" >
										
									</div>
 									
								</div>
								<div class="row">
									            <div class="col-md-6">
													<label>* ISSS:</label>
													<input type="text" name="txtISSS" class="form-control" maxlength="45" autocomplete="off" value="{{$persona->isss}}" >
												</div>

												<div class="col-md-6">
													<label>* AFP:</label>
												<input type="text" name="txtAFP"  maxlength="20" class="form-control" autocomplete="off" value="{{$persona->afp}}">
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
										<textarea name="txtDireccion" class="form-control" cols="2">{{$persona->direccionActual}}</textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>* Departamento residencia:</label>
										  {{Form::select('txtDepartamento', $listaDept, $persona->direccionDepartamentoid,['class' => 'form-control', 'id' => 'txtDepartamento'])}}
										
									</div>
									<div class="col-md-6">
										<label>* Municipio residencia:</label>
										 {{Form::select('txtMunicipio', $listaMun,$persona->direccionMunicipioid,['class' => 'form-control', 'id' => 'txtMunicipio'])}}
										
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label>* Dirección residencia DUI:</label>
										<textarea name="txtDireccionDUI" class="form-control" cols="2">{{$persona->direccionDUI}}</textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>* Departamento residencia DUI:</label>
										  {{Form::select('txtDepartamentoDUI', $listaDept, $persona->departamentoDUI,['class' => 'form-control', 'id' => 'txtDepartamentoDUI'])}}
										
									</div>
									<div class="col-md-6">
										<label>* Municipio residencia DUI:</label>
										 {{Form::select('txtMunicipioDUI', $listaMunDUI,$persona->municipioDUI,['class' => 'form-control', 'id' => 'txtMunicipioDUI'])}}
										
										
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
                                        <select name="idPlazaFun" id="idPlazaFun" class="form-control select_plaza js-states" style="width: 100%;">
                                        @if(is_null($persona->idPlazaFuncional))
                                         <option value="NULL" selected>SELECCIONE UNA PLAZA FUNCIONAL</option>
                                        	@foreach($plazasFun as $fun)
	                                           <option value="{{$fun->idPlazaFuncional}}"> {{$fun->nombrePlaza}}</option>
                                        @endforeach
                                        @else
                                        @foreach($plazasFun as $fun)
	                                            @if($persona->idPlazaFuncional == $fun->idPlazaFuncional)
	                                          <option value="{{$fun->idPlazaFuncional}}" selected> {{$fun->nombrePlaza}}</option>
	                                          @else
	                                           <option value="{{$fun->idPlazaFuncional}}"> {{$fun->nombrePlaza}}</option>
	                                          @endif
                                        @endforeach
                                        @endif
                                        	
                                        </select>
											<select class="js-source-states" style="visibility: hidden">
				                                    @foreach($plazasFun as $fun)
	                                           <option value="{{$fun->idPlazaFuncional}}"> {{$fun->nombrePlaza}}</option>
                                        @endforeach
				                         </select>
												</div>
												<div class="col-md-6">
													<label>* Plaza Nominal:</label>
													 <select name="idPlazaNom" id="idPlazaNom" class="form-control select_plaza js-states" style="width: 100%;">
									@if(is_null($persona->idPlazaNominal))
                                       <option value="NULL" selected>SELECCIONE UNA PLAZA FUNCIONAL</option>
                                        @foreach($plazasNom as $nom)
	                                
	                                          <option value="{{$nom->idPlazaNominal}}"> {{$nom->nombrePlazaNominal}}</option>
                                        @endforeach
                                     @else
                                     @foreach($plazasNom as $nom)
	                                            @if($persona->idPlazaNominal == $nom->idPlazaNominal)
	                                          <option value="{{$nom->idPlazaNominal}}" selected> {{$nom->nombrePlazaNominal}}</option>
	                                          @else
	                                          <option value="{{$nom->idPlazaNominal}}"> {{$nom->nombrePlazaNominal}}</option>
	                                          @endif
                                        @endforeach

                                     @endif
                                        	
                                        </select>
                                        <select class="js-source-states" style="visibility: hidden">
				                            @foreach($plazasNom as $nom)
	                                          <option value="{{$nom->idPlazaNominal}}"> {{$nom->nombrePlazaNominal}}</option>
                                        	@endforeach
				                         </select>
												</div>
								</div>
							    <div class="row">
							           <div class="col-md-6">
													<label>Banco:</label>
													@if($persona->idBanco==0)
 													<?php
													array_add($bancos, 0, 'SELECCIONE UN BANCO...');
													?>
														     {{Form::select('txtBanco', $bancos, $persona->idBanco,['class' => 'form-control', 'id' => 'txtBanco'])}}

													@else
														     {{Form::select('txtBanco', $bancos, $persona->idBanco,['class' => 'form-control', 'id' => 'txtBanco'])}}
													@endif 
												</div>
												<div class="col-md-6"> 

													<label>Cuenta Bancaria:</label>
                                         			<input name="txtCtaBancaria" type="text"  class="form-control" placeholder=""  autocomplete="off" value="{{$persona->cuentaBancaria}}">
												
												</div>
								  </div>
								  <div class="row">
								          <div class="col-md-6">
													<label>* Asegurado:</label>
											{!! Form::select('cmbAsegurado', [0 => 'NO', 1 => 'SI'],$persona->asegurado,['class' => 'form-control','id' => 'cmbAsegurado']) !!}
												</div>
										<div class="col-md-6">
													<label>Salario:</label>
										<input type="number" min="0"  step="1" name="txtSalario" id="txtSalario" class="form-control"  value="{{$persona->salario}}">
												</div>
								  </div>
								    <div class="row">
									<div class="col-md-6">
										<label>Fecha inicio contrato:</label>
										<input name="inicioContrato"  id="inicioContraro"  type="date" class="form-control" placeholder="yyyy-mm-dd"  data-date-format="yyyy-mm-dd" value="{{$persona->fechaInicioContrato}}"  /> 
										
									</div>
									<div class="col-md-6">
										<label>Fecha fin contrato:</label>
										<input name="finContrato"  id="finContrato" type="date" class="form-control" placeholder="yyyy-mm-dd"  data-date-format="yyyy-mm-dd" value="{{$persona->fechaFinContrato}}"  /> 
									</div>

								  </div>
								  <div class="row">
								            
												<div class="col-md-6">
													<label>* Tipo contratación:</label>
													<select id="cmbTipoContrato" name="cmbTipoContrato" class="form-control" onchange="tipoDeContrato();">
														@foreach($tiposContratos as $tc)
														<option value="{{$tc->idTipoContrato}}" @if($persona->contratoId==$tc->idTipoContrato) selected @endif>{{$tc->nombreTipoContrato}}</option>
														@endforeach
														
													</select>
												</div>
												<div class="col-md-6">
													<label>* Estado empleado:</label>
										{!! Form::select('cmbEstadoEmp', [1 => 'Activo', 2 => 'Inactivo' , 3 => 'Suspendido'],$persona->estadoId,['class' => 'form-control','id' => 'cmbEstadoEmp']) !!}
											
												</div>
								  </div>
								  <div class="row" id="datosDePrueba" name="datosDePrueba">
								  	<div class="col-md-6">
										<label>Fecha inicio pruebas:</label>
										<input name="inicioPruebas"  id="inicioPruebas"  type="date" class="form-control" placeholder="yyyy-mm-dd"  data-date-format="yyyy-mm-dd" value="{{$persona->fechaInicioPruebas}}"  /> 
										
									</div>
									<div class="col-md-6">
										<label>Fecha fin pruebas:</label>
										<input name="finPruebas"  id="finPruebas" type="date" class="form-control" placeholder="yyyy-mm-dd"  data-date-format="yyyy-mm-dd" value="{{$persona->fechaFinPruebas}}"  /> 
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
								  		@foreach($estadosLaborales as $ce)
								  			<option value="{{$ce->idEstadoLabor}}" @if($persona->idEstadoLaboral == $ce->idEstadoLabor) selected @endif>{{$ce->descripcionLaboral}}</option>
								  		@endforeach

								  		</select>
								  	</div>
								  </div>

									</div><!-- /.panel-body -->
									<div class="panel-footer">
										<div class="row">
											<div class="col-sm-6">
												<a class="btn btn-warning PrevStep"><i class="fa fa-angle-left"></i> Regresar</a>
											</div><!-- /.col-sm-6 -->
											<div class="col-sm-6 text-right">
											 
												
											</div><!-- /.col-sm-6 -->
										</div><!-- /.row -->
									</div><!-- /.panel-footer -->
								</div>
							</div><!-- /.tab-content -->
						</div><!-- /.collapse in -->
					</div><!-- /.panel .panel-success -->
	</div>
	<div class="panel-footer">
										<div class="row">
											<div class="col-sm-3">
											</div>
											<div class="col-sm-6" align="center">
												     <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                     <button type="submit" class="btn btn-primary btn-perspective">Actualizar <i class="fa fa-check"></i></button>
											</div><!-- /.col-sm-6 -->
											<div class="col-sm-3">
											</div>
											
										</div><!-- /.row -->
    </div><!-- /.panel-footer -->
</form>