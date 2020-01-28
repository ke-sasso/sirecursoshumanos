	<div class="panel-body">

											<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<a onclick="nuevoContacto();" style="" type="button" id="cancelar" class="btn btn-primary m-t-10"><i class="fa fa-plus" aria-hidden="true"></i>Nuevo contacto</a>
											</div>
											</div>
											<div class="the-box full no-border">
											


												<div class="table-responsive">
													<table class="table table-striped table-hover" id="dt-contacto" width="100%">
														<thead class="the-box dark full">
															<tr>
																<th>Nombre completo</th>
																<th>Parentesco</th>
																<th>Celular</th>
																<th>Teléfono Fijo</th>
																<th>Dirección</th>
																<th>Editar</th>
															
															</tr>
														
														</thead>
														<tbody>
															@if(!empty($infoContacto))
															@foreach($infoContacto as $cont)
															<tr>
															    <td>{{$cont->nombre}}</td>
															    <td>{{$cont->nombreParentesco}}</td>
															    <td>{{$cont->celular}}</td>
															    <td>{{$cont->telefonoFijo}}</td>
															    <td>{{$cont->direccion}}</td>
															    <td><a class="btn btn-xs btn-success btn-perspective" onclick="editarInfoContactos({{$cont->id}});" ><i class="fa fa-pencil"></i></a>&nbsp;<a class="btn btn-xs btn-danger btn-perspective" onclick="eliminarInfoContactos({{$cont->id}});" ><i class="fa fa-trash-o"></i></a></td>
   															</tr>
															@endforeach
															@endif
															
												
														</tbody>
													</table>
												</div><!-- /.table-responsive -->
											</div>
	</div><!-- /.panel-body -->