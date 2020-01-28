	<div class="panel-body">
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<a onclick="nuevaAmonestacion();" style="" type="button" id="cancelar" class="btn btn-primary m-t-10"><i class="fa fa-plus" aria-hidden="true"></i>Nueva amonestación</a>
											</div>
											</div>
											<div class="the-box full no-border">
												

												<div class="table-responsive">
													<table class="table table-striped table-hover" id="dt-amonestaciones" width="100%" >
														<thead class="the-box dark full">
															<tr>
																<th>Tipo de amolestación</th>
																<th>Fecha</th>
																<th>Fecha prescripción</th>
																<th>Motivo</th>
																<th>Observaciones</th>
																<th>Editar</th>

																
															</tr>
														</thead>
														<tbody>
														@if(!empty($infoSanciones))
													@foreach($infoSanciones as $row)
														<tr>
														@if($row->tipoId==1)
														<td>Amonestación verbal</td>
														@elseif($row->tipoId==2)
														<td>Amonestación por escrito</td>
														@elseif($row->tipoId==3)
														<td>Suspensión</td>
													    @elseif($row->tipoId==4)
														<td>Terminación contrato</td>
														@else
														<td></td>
														@endif
														<td>{{ date('d-m-Y',strtotime($row->fecha))}}</td>
														<td>{{ date('d-m-Y',strtotime($row->fechaPrescripcion))}}</td>
														<td>{{ $row->motivo}}</td>
														<td>{{ $row->descripcion}}</td>
														<td>
															<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfoSanciones({{$row->id}});" ><i class="fa fa-pencil"></i></a>
															@if($row->pdfSancion)
																<a class="btn btn-xs btn-success" target="_blank" href="{{route('ver.pdfEstudio.empleado',[Crypt::encrypt($row->pdfSancion)])}}"><i class="fa-eye-slash"></i></a>
															@endif
															<a class="btn btn-xs btn-danger" onclick="deleteSancion({{$row->id}})"><i class="fa fa-trash-o"></i></a>
														</td>

															
															
														</tr>
													@endforeach
												@endif	
															
												
														</tbody>
													</table>
												</div><!-- /.table-responsive -->
											</div>
									</div><!-- /.panel-body -->
