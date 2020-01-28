<div class="panel-body">
																				<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<a onclick="nuevoEstudio();" style="" type="button" id="cancelar" class="btn btn-primary m-t-10"><i class="fa fa-plus" aria-hidden="true"></i>Nuevo estudio</a>
											</div>
											</div>
										

										<div class="table-responsive">
											<table class="table table-striped table-hover" id="dt-estudios" width="100%">
												<thead class="the-box dark full">
													<tr>
														<th>T&iacute;tulo</th>
														<th>Institución</th>
														<th>Lugar</th>
														<th>Tipo</th>
														<th>Año</th>
														<th>Acciones</th>
														
													</tr>
												</thead>
												<tbody>
												@if(!empty($infoEstudio))
													@foreach($infoEstudio as $row)
														<tr>
															<td>{{ $row->titulo }}</td>
															<td>{{ $row->institucion }}</td>
															<td>{{$row->lugar}}</td>
															<td>{{ $row->nombreTipo }}</td>
															@if($row->annio_mostrar=='0')
															<td>ACTUALMENTE</td>
															@else
															<td>{{ $row->annio_mostrar }}</td>
															@endif
															<td>
																<div class="btn-group">
								 <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-cog"></i><span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu success" role="menu">
								  @if($row->urlDocumento!=NULL || $row->urlDocumento!='')
								  <li><a href="{{route('ver.pdfEstudio.empleado',['urlDocumento' => Crypt::encrypt($row->urlDocumento)])}}" target="_blank"><i class="fa fa-file-text"></i>&nbsp;VER PDF</a></li>
									@endif
									<li><a onclick="editarInfoEstudios({{$row->id}});"><i class="fa fa-pencil"></i>&nbsp;EDITAR</a></li>
									<li></i><a onclick="eliminarInfoEstudios({{$row->id}});"><i class="fa  fa-trash-o"></i>&nbsp;ELIMINAR</a></li>
									
								  </ul>
								</div>
														
														</tr>
													@endforeach
												@endif	
												</tbody>
											</table>
										</div><!-- /.table-responsive -->		
</div><!-- /.panel-body -->