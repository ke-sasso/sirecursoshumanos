 @if(!empty($infoMedica))
                                    <form role="form" method="post" action="{{route('post.editar.infoMedica')}}" autocomplete="off" id="infoMedica">
									<div class="panel-body">
											<div class="the-box full no-border">

													<div class="row">
														<div class="col-md-6">
															<label>* Grupo Sanguineo:</label>
										    {{Form::select('txtGrupo', $grupoSangre, $infoMedica[0]->tipoSangre,['class' => 'form-control', 'id' => 'txtGrupo'])}}
														</div>										
													</div>
													<div class="row">
														<div class="col-md-6">
															<label>* Alergias:</label>
															<textarea name="txtMedicaAlergias" id="txtMedicaAlergias" class="form-control" rows="2">{{$infoMedica[0]->alergias}}</textarea>
														</div>
														<div class="col-md-6">
															<label>* Medicamento permanente:</label>
															<textarea name="txtMedicaMedPerma" id="txtMedicaMedPerma" class="form-control" rows="2">{{$infoMedica[0]->medi}}</textarea>
														</div>
													</div>
													<input type="hidden" name="idGrupo" id="idGrupo" value="{{$infoMedica[0]->id}}">
											</div>
									</div><!-- /.panel-body -->
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
@else
							<form role="form" method="post" action="{{route('post.nueva.infoMedica')}}" autocomplete="off" id="nuevaInfoMedica">
									<div class="panel-body">
											<div class="the-box full no-border">

													<div class="row">
														<div class="col-md-6">
															<label>* Grupo Sanguineo:</label>
										    {{Form::select('txtGrupo', $grupoSangre, 1,['class' => 'form-control', 'id' => 'txtGrupo'])}}
														</div>										
													</div>
													<div class="row">
														<div class="col-md-6">
															<label>* Alergias:</label>
															<textarea name="txtMedicaAlergias" id="txtMedicaAlergias" class="form-control" rows="2"></textarea>
														</div>
														<div class="col-md-6">
															<label>* Medicamento permanente:</label>
															<textarea name="txtMedicaMedPerma" id="txtMedicaMedPerma" class="form-control" rows="2"></textarea>
														</div>
													</div>
													<input type="hidden" name="duiEmpleadoM" id="duiEmpleadoM" value="{{$persona->dui}}">
											</div>
									</div><!-- /.panel-body -->
										<div class="panel-footer">
										<div class="row">
											<div class="col-sm-3">
											</div>
											<div class="col-sm-6" align="center">
												     <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                     <button type="submit" class="btn btn-primary btn-perspective">Guardar Informaci&oacute;n <i class="fa fa-check"></i></button>
											</div><!-- /.col-sm-6 -->
											<div class="col-sm-3">
											</div>
											
										</div><!-- /.row -->
									</div><!-- /.panel-footer -->
									</form>

@endif
								