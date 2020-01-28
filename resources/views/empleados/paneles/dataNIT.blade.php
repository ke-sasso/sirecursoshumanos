	<div class="panel-body">
											<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<a onclick="nuevoDocumento(2);" style="" type="button" id="cancelar" class="btn btn-primary m-t-10"><i class="fa fa-plus" aria-hidden="true"></i>Nuevo NIT</a>
											</div>
											</div>
											<div class="the-box full no-border">
												<div class="table-responsive">
													<table class="table table-striped table-hover" id="dt-nit" width="100%">
														<thead class="the-box dark full">
															<tr>
														
																<th>Descripción</th>
																<th>Editar</th>
															</tr>
														</thead>
														<tbody>
													     	@if(!empty($docPersona))
															@foreach($docPersona as $docdui)
																	@if($docdui->idTipo==2)
																	<tr>
			
																	    <td>{{$docdui->descripcion}}</td>
																	    <td><a class="btn btn-xs btn-danger btn-perspective" onclick="eliminarDocPersonal({{$docdui->idDoc}});" ><i class="fa fa-trash-o"></i></a>
																	     <a class="btn btn-xs btn-success btn-perspective" href="{{route('ver.pdfEstudio.empleado',['urlDocumento' => Crypt::encrypt($docdui->urlDocumento)])}}" target="_blank"><i class="fa fa-file-text"></i>&nbsp;VER</a>
																	    </td>
		   															</tr>
		   															@endif
															@endforeach
															@endif
														</tbody>
													</table>
												</div><!-- /.table-responsive -->
											</div>
	</div><!-- /.panel-body -->