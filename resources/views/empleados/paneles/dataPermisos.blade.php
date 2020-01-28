<div class="panel-body">
											<div class="the-box full no-border">
												

												<div class="table-responsive">
													<table class="table table-striped table-hover" id="dt-permisos" width="100%">
														<thead class="the-box dark full">
															<tr>
																<th>Motivo</th>
																<th>Estado</th>
																<th>Fecha desde</th>
																<th>Fecha hasta</th>
																<th>Fecha denegación o aprobación</th>
															</tr>
														</thead>
														<tbody>
														@if(!empty($permisos))
													@foreach($permisos as $row)
													<tr>
														<td>{{ $row->motivo}} </td>
														<td><span class="label label-info">{{ $row->nombreEstado}}</span></td>
														<td>{{ $row->fechaDesde}}</td>
														<td>{{ $row->fechaHasta}}</td>
														<td>{{ $row->fechaApruebaDenegar }}</td>
															
															
														</tr>
													@endforeach
												@endif	
															
												
														</tbody>
													</table>
												</div><!-- /.table-responsive -->
											</div>
</div><!-- /.panel-body -->