@extends('master')
<!-- CSS ESPECIFICOS -->
@section('css')
{{-- Bootstrap Modal --}}
{!! Html::style('plugins/bootstrap-modal/css/bootstrap-modal.css') !!}

@endsection

<!-- CONTENIDO PRINCIPAL -->
@section('contenido')
	<!-- BEGIN DATA TABLE -->
	<div class="the-box">
		<form role="form"  id="search-form">

				<legend>Búsqueda de Empleados</legend>
				<div class="row">
					<div class="form-group col-sm-6">
						<div class="form-group">
							<label class="col-lg-3 	control-label">Nombres</label>
							<div class="col-lg-9">
								<input type="text" id="txtNomEmp" name="txtNomEmp" class="form-control" autocomplete="off" />
							</div>

						</div>
					</div>
					<div class="form-group col-sm-6">
						<div class="form-group">
							<label class="col-lg-3 control-label">Apellidos</label>
							<div class="col-lg-9">
								<input type="text" id="txtApeEmp" name="txtApeEmp" class="form-control" autocomplete="off" />
							</div>
						</div>
					</div>
                    </div>
                    <div class="row">
                    <div class="form-group col-sm-6">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Cód. Empleado</label>
                            <div class="col-lg-9">

                                <input type="number" id="txtCod" name="txtCod" class="form-control" min="1" max="20000" autocomplete="off">
                            </div>
                        </div>
                    </div>
					<div class="form-group col-sm-6">
						<div class="form-group">
							<label class="col-lg-3 control-label">DUI</label>
							<div class="col-lg-9">

								<input type="text" id="txtDUI" name="txtDUI" class="form-control dui_masking" placeholder="00000000-0" maxlength="10" autocomplete="off">
							</div>
						</div>
					</div>
                    </div>

				<div class="row">
					<div class="form-group col-sm-6">
						<div class="form-group">
							<label class="col-lg-3 	control-label">Unidad</label>
							<div class="col-lg-9">
						<select class="form-control select_plaza2 js-states2" name="unidad" id="unidad" >
                            <option></option>
                            @foreach($unidades as $uni)
                                <option value="{{$uni->idUnidad}}">
                                  {{$uni->nombreUnidad}}
                                </option>
                            @endforeach

                         </select>
                         <select class="js-source-states2" style="visibility: hidden">
                                    @foreach($unidades as $uni)
                                <option value="{{$uni->idUnidad}}">
                                  {{$uni->nombreUnidad}}
                                </option>
                            @endforeach
                         </select>
							</div>

						</div>
					</div>
                    <div class="form-group col-sm-6">
                        <div class="form-group">
                            <label class="col-lg-3  control-label">Estado</label>
                            <div class="col-lg-9">
                             <select name="estado" id="estado" class="form-control"
                             style="width: 100%;" >
                              <option value="" selected>Seleccione un estado..</option>
                              <option value="1">ACTIVO</option>
                              <option value="2">INACTIVO</option>
                            </select>
                            </div>

                        </div>
                    </div>


				</div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <div class="form-group">
                            <label class="col-lg-3  control-label">Tipo contrato</label>
                            <div class="col-lg-9">
                        <select class="form-control select_plaza3 js-states3" name="tipo" id="tipo" >
                            <option></option>
                            @foreach($tipo as $tip)
                                <option value="{{$tip->idTipoContrato}}">{{$tip->nombreTipoContrato}}</option>
                            @endforeach

                         </select>

                            </div>

                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="form-group">
                            <label class="col-lg-3  control-label">Plaza nominal</label>
                            <div class="col-lg-9">
                             <select name="nominal" id="nominal" class="form-control select_plaza4 js-states4"
                             style="width: 100%;" >
                              <option></option>
                            </select>
                                <select class="js-source-states4" style="visibility: hidden">
                        @foreach($nominales as $nom)
                            <option value="{{ $nom->idPlazaNominal}}">{{  $nom->nombrePlazaNominal }}</option>
                        @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                  <div class="row">
                        <div class="form-group col-sm-9">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Plaza</label>
                            <div class="col-lg-10">
                             <select name="plaza" id="plaza" class="form-control select_plaza5 js-states5"
                             style="width: 100%;" >
                              <option></option>
                             </select>
                             <select class="js-source-states5" style="visibility: hidden">
                              @foreach($plazas as $pla)
                            <option value="{{ $pla->idPlazaFuncional}}">{{  $pla->nombrePlaza }}</option>
                              @endforeach
                             </select>
                            </div>

                        </div>
                    </div>

                </div>




			      <div class="modal-footer" >
                    <div align="center">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" class="btn btn-primary btn-perspective"/>
                  <button type="submit"  id="btnConsultar" class="btn btn-success btn-perspective"><i class="fa fa-search"></i> Consultar</button>
                  <button class="btn btn-warning btn-perspective" id="btnLimpiar" type="button" onclick="limpiarFormulario()"><i class="fa fa-eraser"></i> Limpiar</button>
                           </div>
                  </div>
</div>
		</form>
	</div>

	<div class="the-box" id="tabla-Empleados" style='display:none;'>
		<div class="table-responsive">
		<table class="table table-striped table-hover" id="tr-empleados">
			<thead class="the-box dark full">
				<tr>
                    <th>C&oacute;digo</th>
					<th>DUI</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Unidad</th>
					<th>Plaza</th>
					<th>Opciones</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div><!-- /.table-responsive -->
</div><!-- /.the-box .default -->
@endsection

<!-- JS ESPECIFICOS -->
@section('js')
{{-- Bootstrap Modal --}}
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
<script src="{{url('/js/select2.full.min.js')}}"></script>

<script type="text/javascript">



function getTableData(){

    var table = $('#tr-empleados').DataTable({
    	retrieve: true,
        filter:false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dt.row.data.empleados.urh') }}",
            data: function (d) {
                d.unidad= $('#unidad').val();
                d.nombre= $('#txtNomEmp').val();
                d.dui= $('#txtDUI').val();
                d.apellido= $('#txtApeEmp').val();
                d.plaza= $('#plaza').val();
                d.codigo= $('#txtCod').val();
                d.nominal= $('#nominal').val();
                d.tipo= $('#tipo').val();
                d.estado= $('#estado').val();
              }
        },
        columns: [
            {data: 'idEmpleado', name: 'emple.idEmpleado'},
            {data: 'dui', name: 'emple.dui'},
            {data: 'nombresEmpleado', name: 'emple.nombresEmpleado'},
            {data: 'apellidosEmpleado', name: 'emple.apellidosEmpleado'},
            {data: 'nombreUnidad', name: 'uni.nombreUnidad'},
            {data: 'nombrePlaza', name: 'plaza.nombrePlaza'},
            {data: 'detalle', name: 'detalle',ordenable:false,searchable:false},

        ],
        language: {
            "sProcessing": '<div class=\"dlgwait\"></div>',
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"


        },
           "columnDefs": [ {
            "searchable": false,
            "orderable": false,
             "targets": [6],
        } ],

      "order": [[ 1, 'asc' ]]

    } );

    $('#search-form').on('submit', function(e) {

        table.draw();
        e.preventDefault();
        $("#colp").attr("class", "block-collapse collapsed");
        $("#collapse-filter").attr("class", "collapse");
    });

    table.rows().remove();
}
$(document).ready(function(){
$('.dui_masking').mask('00000000-0');

 var $states5 = $(".js-source-states5");
            var statesOptions5 = $states5.html();
            $states5.remove();
            $(".js-states5").append(statesOptions5);
            $(".select_plaza5").select2({
                placeholder: "Seleccione la plaza...",
                allowClear: true
            });
 var $states2 = $(".js-source-states2");
            var statesOptions2 = $states2.html();
            $states2.remove();
            $(".js-states2").append(statesOptions2);
            $(".select_plaza2").select2({
                placeholder: "Seleccione la unidad...",
                allowClear: true
            });

             var $states3 = $(".js-source-states3");
            var statesOptions3 = $states3.html();
            $states3.remove();
            $(".js-states3").append(statesOptions3);
            $(".select_plaza3").select2({
                placeholder: "Seleccione tipo de contrato...",
                allowClear: true
            });

                   var $states4 = $(".js-source-states4");
            var statesOptions4 = $states4.html();
            $states4.remove();
            $(".js-states4").append(statesOptions4);
            $(".select_plaza4").select2({
                placeholder: "Seleccione la plaza...",
                allowClear: true
            });




$("#btnConsultar").on("click",function(){
	                var nombre=document.getElementById("txtNomEmp").value;
                    var apellido=document.getElementById("txtApeEmp").value;
                    var dui=document.getElementById("txtDUI").value;
                    var unidad=document.getElementById("unidad").value;
                    var plaza=document.getElementById("plaza").value;
                    var codigo=document.getElementById("txtCod").value;
                    var tipo=document.getElementById("tipo").value;
                    var nominal=document.getElementById("nominal").value;
                     var estado=document.getElementById("estado").value;
         if(nombre.length==0 && apellido.length==0 && dui.length==0 && unidad.length==0 && plaza.length==0 && codigo.length==0 &&
            tipo.length==0 && nominal.length==0 && estado.length==0 ){
                        alertify.alert("Debes ingresar un campo para realizar la b&uacute;squeda.", function(){
                                    alertify.success('¡Vuelve a intentar!');
                                  });
                                return false;
                    }
			getTableData();
            $('#tabla-Empleados').show();

	});

	})

	function limpiarFormulario(){
		window.location = "{{ url('urh/empleados') }}";

	}

</script>
@endsection
