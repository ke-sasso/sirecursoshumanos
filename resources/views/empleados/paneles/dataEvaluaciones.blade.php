	<div class="panel-body">
									
											<div class="the-box full no-border">
												

												<div class="table-responsive">
													<table class="table table-striped table-hover" id="dt-laboral" width="100%">
														<thead class="the-box dark full">
															<tr>
																
																<th>Evaluación</th>
																<th>Período</th>
																<th>Código</th>
																<th>Unidad</th>						
																<th>Calificación</th>
																<th>-</th>
																
															</tr>
														</thead>
														<tbody>
														@if(!empty($evaluacion))
													@foreach($evaluacion as $eva)
														<tr>
														<td>{{$eva->nombre}}</td>
														<td>{{$eva->periodo}}</td>
														<td>{{$eva->idEmpleado}}</td>
														<td>{{$eva->nombreUnidad}}</td>					
														@if($eva->CP== null)
															<td><span  class="label label-danger">0.00</span></td>
														@else
															<td><span  class="label label-info">{{$eva->CP}}</span></td>
														@endif
														<td><a href="{{route('edc.empleado.vistaprevia',['idEvaluacion'=>Crypt::encrypt($eva->idEvaluacion),'idEmpleado' =>Crypt::encrypt($eva->idEmpleado)])}}" class="btn btn-xs btn-success btn-perspective" target="_blank" ><i class="fa fa-file-text-o"></i></a></td>
															
															
														</tr>
													@endforeach
												@endif	
															
												          
														</tbody>
													</table>
												</div><!-- /.table-responsive -->
											</div>
				</div><!-- /.panel-body -->