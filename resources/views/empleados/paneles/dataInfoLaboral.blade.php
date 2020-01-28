<div class="panel-body">
									<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<a onclick="nuevaInfoLaboral();" style="" type="button" id="cancelar" class="btn btn-primary m-t-10"><i class="fa fa-plus" aria-hidden="true"></i>Agregar Información</a>
											</div>
											</div>
											<div class="the-box full no-border">
												

												<div class="table-responsive">
													<table class="table table-striped table-hover" id="dt-laboral" width="100%">
														<thead class="the-box dark full">
															<tr>
																
																<th>Unidad</th>
																<th>Plaza</th>
																<th>Fecha Inicio</th>
																<th>Fecha Fin</th>
																<th>Observación</th>
																<th>Editar/Eliminar</th>
															</tr>
														</thead>
														<tbody>
														@if(!empty($infoLaboral))
													@foreach($infoLaboral as $row)
														<tr>
														<td width="210px">{{ $row->nombreUnidad}}</td>
														<td>{{ $row->nombrePlaza}}</td>
														<td width="100px">@if($row->fechaInicio=='1900-01-01') - @else {{ $row->fechaInicio}}@endif</td>
														<td width="100px">@if($row->fechaFin=='1900-01-01') - @else {{ $row->fechaFin}}@endif</td>
														<td>{!! $row->observacion !!}</td>
														<td style="text-align: center;">
															<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfoLaboral({{ $row->id}});"><i class="fa fa-pencil"></i></a>
															<a class="btn btn-xs btn-danger btn-perspective" onclick="eliminarInfoLaboral({{ $row->id}});"><i class="fa fa-times"></i></a></td>
														</tr>
													@endforeach
												@endif	
															
												          
														</tbody>
													</table>
												</div><!-- /.table-responsive -->
											</div>
									</div><!-- /.panel-body -->