@extends('master')
{{-- CSS ESPECIFICOS --}}
@section('css')
{!! Html::style('plugins/full-calendar/css/fullcalendar.min.css') !!} 
{!! Html::style('plugins/bootstrap-fileinput/css/fileinput.min.css') !!}
{!! Html::style('plugins/selectize-js/dist/css/selectize.bootstrap3.css') !!} 
<style>
.kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover{
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    text-align: center;
}
.kv-avatar .file-input {
    display: table-cell;
    max-width: 220px;
}

div.polaroid {
  width: 110%;
  background-color: white;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  margin-bottom: 25px;
}

div.containerb {
  text-align: center;
  padding: 10px 10px;
}



</style>
	
@endsection

{{-- CONTENIDO PRINCIPAL --}}
@section('contenido')
{{-- ERRORES DE VALIDACIÓN --}}
@if($errors->any())
	<div class="alert alert-warning square fade in alert-dismissable">
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<strong>Oops!</strong>
		Debes corregir los siguientes errores para poder continuar		
		<ul class="inline-popups">
			@foreach ($errors->all() as $error)
				<li  class="alert-link">{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif
{{-- MENSAJE DE EXITO --}}
@if(Session::has('msnExito'))
	<div class="alert alert-success square fade in alert-dismissable">
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<strong>Enhorabuena!</strong>
		{{ Session::get('msnExito') }}
	</div>
@endif
{{-- MENSAJE DE ERROR --}}
@if(Session::has('msnError'))
	<div class="alert alert-danger square fade in alert-dismissable">
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<strong>Auchh!</strong>
		Algo ha salido mal.	{{ Session::get('msnError') }}
	</div>
@endif
	<!-- BEGIN FORM WIZARD -->
	

	
		<div  class="collapse in">
			<div class="tab-content">
				<div class="tab-pane fade in active" id="info-pro">
					<div class="panel-body">
						<!--
								SECCION INFO
						-->
						<div class="panel with-nav-tabs panel-success">

					  <div class="panel-heading">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#emp-infogeneral">Información General</a></li>
							<li><a data-toggle="tab" href="#emp-dui">DUI</a></li>
							<li><a data-toggle="tab" href="#emp-nit">NIT</a></li>
							<li><a data-toggle="tab" href="#emp-isss">ISSS</a></li>
							<li><a data-toggle="tab" href="#emp-afp">AFP</a></li>
							<li><a data-toggle="tab" href="#emp-contacto">Contacto</a></li>
							<li><a data-toggle="tab" href="#emp-estudios">Estudios</a></li>
							<li><a data-toggle="tab" href="#emp-medica">Información Medica</a></li>
							<li><a data-toggle="tab" href="#emp-laboral">Información Laboral</a></li>
							<li><a data-toggle="tab" href="#emp-amonestaciones">Amonestaciones</a></li>
							<li><a data-toggle="tab" href="#emp-marcaciones">Marcaciones</a></li>
							<li><a data-toggle="tab" href="#emp-permisos">Permisos</a></li>
							<li><a data-toggle="tab" href="#emp-evaluacion">Evaluación de Desempeño</a></li>

						</ul>
					  </div>
						<div class="collapse in" id="panel-collapse-1">
							  <div class="tab-content">
								<div id="emp-infogeneral" class="tab-pane fade in active">
								     @include('empleados.paneles.infoGeneral')
								</div>
								<div id="emp-dui" class="tab-pane fade">
									 @include('empleados.paneles.dataDUI')
								</div>
								<div id="emp-nit" class="tab-pane fade">
									 @include('empleados.paneles.dataNIT')
								</div>
								<div id="emp-isss" class="tab-pane fade">
									 @include('empleados.paneles.dataISSS')
								</div>
								<div id="emp-afp" class="tab-pane fade">
									 @include('empleados.paneles.dataAFP')
								</div>
								<div id="emp-contacto" class="tab-pane fade">
									 @include('empleados.paneles.dataContactos')
								</div>
								<div id="emp-estudios" class="tab-pane fade">
								     @include('empleados.paneles.dataEstudios')
								</div>
								<div id="emp-medica" class="tab-pane fade">
							          @include('empleados.paneles.dataInfoMedica')
								</div>
								<div id="emp-laboral" class="tab-pane fade">
									  @include('empleados.paneles.dataInfoLaboral')
								</div>
								<div id="emp-amonestaciones" class="tab-pane fade">
								      @include('empleados.paneles.dataAmonestaciones')
								</div>
	                            <div id="emp-marcaciones" class="tab-pane fade">
									<div class="panel-body">
									@include('empleados.paneles.calendar')
									</div><!-- /.panel-body -->
								</div>
								<div id="emp-permisos" class="tab-pane fade">
									@include('empleados.paneles.dataPermisos')
								</div>
								<div id="emp-evaluacion" class="tab-pane fade">
									@include('empleados.paneles.dataEvaluaciones')
								</div>
							</div><!-- /.tab-content -->
						</div><!-- /.collapse in -->
					</div>
					</div>

				</div>
			</div><!-- /.tab-content -->
		</div><!-- /.collapse in -->
	</div><!-- /.panel .panel-success -->
	<!-- END FORM WIZARD -->

<!-- Modal -->
@include('empleados.paneles.contactos')
@include('empleados.paneles.estudios')
@include('empleados.paneles.sanciones')
@include('empleados.paneles.foto')
@include('empleados.paneles.nuevoContacto')
@include('empleados.paneles.nuevoEstudio')
@include('empleados.paneles.nuevaSancion')
@include('empleados.paneles.nuevaInfomacionLaboral')
@include('empleados.paneles.editarInformacionLaboral')
@include('empleados.paneles.nuevoDocumento')
@endsection


{{-- JS ESPECIFICOS --}}
@section('js')
 {!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!} 
 
{!!Html::script('plugins/full-calendar/js/jquery-ui.min.js')!!}
{!! Html::script('plugins/full-calendar/js/moment.min.js') !!}
{!! Html::script('plugins/full-calendar/js/fullcalendar.min.js') !!}
{!! Html::script('plugins/full-calendar/lang/es.js') !!}

{!! Html::script('plugins/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js') !!}
{!! Html::script('plugins/bootstrap-fileinput/js/fileinput.min.js') !!}
{!! Html::script('plugins/bootstrap-fileinput/js/fileinput_locale_es.js') !!}
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
<script>



$(document).ready(function(){

  $('#cmbClasificacionEmpleado').selectize({create: false});
  $('#cmbClasificacionEmpleado')[0].selectize.setValue({!! $detalleClasificacionEmpleados !!});
	//inicialmente estan ocultas las fechas de pruebas si no es tipo de empleado Pruebas
	if($('#cmbTipoContrato option:selected').val()==4){
		$('#datosDePrueba').show();
	}else{
		$('#datosDePrueba').hide();
	}
	
	    $('#idPadre').chosen({
                      'width':'100%'
         });

	   $('.date_masking2').mask('0000-00-00');

	        var $states = $(".js-source-states");
                    var statesOptions = $states.html();
                    $states.remove();
                    $(".js-states").append(statesOptions);
                    $(".select_plaza").select2({
                        placeholder: "Seleccionar...",
                        allowClear: true
                    });



	   $("#txtDepartamento").on('change',function(){
    	$.ajax({
    		data: {_token:'{{ csrf_token() }}',deparamento:this.value},
    		url: "{{ url('/urh/getMunicipiosEmpleado') }}",
    		type: 'post',
    		beforeSend: function() {
				$("#txtMunicipio").prop("disabled",true);
			},
            success:  function (response){
            	$("#txtMunicipio").html(response);
            	$("#txtMunicipio").prop("disabled",false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            	$("#txtMunicipio").prop("disabled",false);
              	console.log("Error en peticion AJAX!");  
            }
    	});
   	    });
		
		 $("#txtDepartamentoDUI").on('change',function(){
    	$.ajax({
    		data: {_token:'{{ csrf_token() }}',deparamento:this.value},
    		url: "{{ url('/urh/getMunicipiosEmpleado') }}",
    		type: 'post',
    		beforeSend: function() {
				$("#txtMunicipioDUI").prop("disabled",true);
			},
            success:  function (response){
            	$("#txtMunicipioDUI").html(response);
            	$("#txtMunicipioDUI").prop("disabled",false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            	$("#txtMunicipioDUI").prop("disabled",false);
              	console.log("Error en peticion AJAX!");  
            }
    	});
   	    });
	 $("#file").fileinput({
		language: "es",
		 overwriteInitial: true,
	    maxFileSize: 1500,
	    showClose: false,
	    showCaption: false,
        showPreview: true,
         maxFileSize: 1500,
        allowedFileExtensions: ["jpg", "png", "gif"],
        elErrorContainer: "#errorBlock",
        showUpload: false,
        layoutTemplates: {main2: '{preview} {remove} {browse}'},
        browseLabel: '',
	    removeLabel: '',
	     browseIcon: '<i class="fa fa-cloud-upload"></i>',
	    removeIcon: '<i class="fa fa-ban"></i>',
	    removeTitle: 'Cancelar o resetear cambios'
    });

	$("#fileEstudio").fileinput({
		language: "es",
        showPreview: false,
        allowedFileExtensions: ["pdf"],
        elErrorContainer: "#errorBlockPdf",
        showUpload: false
    });

    $("#fileDocumentoEmple").fileinput({
		language: "es",
        showPreview: false,
        allowedFileExtensions: ["pdf"],
        elErrorContainer: "#errorBlockDocumento",
        showUpload: false
    });

    	$("#fileEstudiosNew").fileinput({
		language: "es",
        showPreview: false,
        allowedFileExtensions: ["pdf"],
        elErrorContainer: "#errorBlockNew",
        showUpload: false
    });

	$('#calendar').fullCalendar({
	    header: {
	        left: 'prev,next today',
	        center: 'title',
	        right: 'month' // buttons for switching between views
	    }, 
	    defaultView:'month',
	    navLinks: true, // can click day/week names to navigate views
		businessHours: true, // display business hours
		displayEventTime : false,
		events: {
			url: '{{route('get.marcaciones',['idEmpleado'=>$persona->idEmpleado])}}',
            type: 'get',
            error: function() {
                alert('Problemas al cargas los eventos del calendario');
            }
		}
   		});

             

    $('#dt-estudios').DataTable({
    	"language": {
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
        },
           "columnDefs": [ {
            "searchable": false,
            "orderable": false,        
          
        } ],

      "order": [[ 4, 'desc' ]]

    });
     $('#dt-contacto').DataTable({
    	"language": {
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
        },
    	"ordering": true
    });
      $('#dt-dui').DataTable({
    	"language": {
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
        },
    	"ordering": true
    });

    $('#dt-amonestaciones').DataTable({
    	"language": {
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
        },
    	"ordering": true
    });
     $('#dt-isss').DataTable({
    	"language": {
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
        },
    	"ordering": true
    });
     $('#dt-nit').DataTable({
    	"language": {
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
        },
    	"ordering": true
    });
      $('#dt-afp').DataTable({
    	"language": {
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
        },
    	"ordering": true
    });

      $('#dt-laboral').DataTable({
    	"language": {
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
        },
    	"ordering": true,
    	"columnDefs": [ {
            "width": "10%",
            "searchable": false,
            "orderable": true
        }],
        "order": [[ 2, 'desc' ]]
    });

         $('#dt-permisos').DataTable({
    	"language": {
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
        },
    	"ordering": true
    });

/*-------------ACTUALIZAR DATOS---------------------*/
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $('#infoMedica').submit(function(e){
        var formObj = $(this);
        var formURL = formObj.attr("action");
      var formData = new FormData(this);
    $.ajax({
      data: formData,
      url: formURL,
      type: 'post',
      mimeType:"multipart/form-data",
        contentType: false,
          cache: false,
          processData:false,
      beforeSend: function() {
        $('body').modalmanager('loading');
      },
      success:  function (response){
            $('body').modalmanager('loading');
            if(isJson(response)){
              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n actualizada de forma exitosa!</p></strong>",function(){
                var obj =  JSON.parse(response);
               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
              });
              
            }else{
              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
        $('body').modalmanager('loading');
        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
              console.log("Error en peticion AJAX!");  
          }
    });
    e.preventDefault(); //Prevent Default action. 

    });


    $('#infoGeneral').submit(function(e){
        var formObj = $(this);
        var formURL = formObj.attr("action");
      var formData = new FormData(this);
    $.ajax({
      data: formData,
      url: formURL,
      type: 'post',
      mimeType:"multipart/form-data",
        contentType: false,
          cache: false,
          processData:false,
      beforeSend: function() {
        $('body').modalmanager('loading');
      },
      success:  function (response){
            $('body').modalmanager('loading');
            if(isJson(response)){
              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n se actualizo de forma exitosa!</p></strong>",function(){
                var obj =  JSON.parse(response);
                window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
              });
              
            }else{
              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
        $('body').modalmanager('loading');
        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
              console.log("Error en peticion AJAX!");  
          }
    });
    e.preventDefault(); //Prevent Default action. 

    });

    $('#nuevaInfoMedica').submit(function(e){
					        var formObj = $(this);
					        var formURL = formObj.attr("action");
					      var formData = new FormData(this);
					    $.ajax({
					      data: formData,
					      url: formURL,
					      type: 'post',
					      mimeType:"multipart/form-data",
					        contentType: false,
					          cache: false,
					          processData:false,
					      beforeSend: function() {
					        $('body').modalmanager('loading');
					      },
					      success:  function (response){
					            $('body').modalmanager('loading');
					            if(isJson(response)){
					              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n actualizada de forma exitosa!</p></strong>",function(){
					                var obj =  JSON.parse(response);
					               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
					              });
					              
					            }else{
					              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
					            }
					          },
					          error: function(jqXHR, textStatus, errorThrown) {
					        $('body').modalmanager('loading');
					        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
					              console.log("Error en peticion AJAX!");  
					          }
					    });
					    e.preventDefault(); //Prevent Default action. 

					    });
  
  });

 function eliminarInfoLaboral(id){
    alertify.confirm('Mensaje de sistema','¿Esta seguro que desea elimiar la información laboral?',function(){
      $.ajax({
        data : {_token:'{{ csrf_token() }}', idInfoLaboral: id},
        url: "{{ route('urh.infoLaboral.borrar') }}",
        type: "post",
        cache: false,
        mimeType:"multipart/form-data",
         beforeSend: function() {
                  $('body').modalmanager('loading');
                },
            success:  function (response){
              $('body').modalmanager('loading');
                      if(isJson(response)){
                        alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Registro eliminado exitosamente!</p></strong>",function(){
                          var obj =  JSON.parse(response);
                         window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
                        });
                        
                      }else{
                        alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
                      }
                    },
            error: function(jqXHR, textStatus, errorThrown) {
          alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo eliminar la información!</p></strong>");
                console.log("Error en peticion AJAX!");  
            }
      });
        },null).set('labels', {ok:'SI', cancel:'NO'}); 
  }

    function editarInfoLaboral(id){

               $.get("{{route('data.infoLaboral.getData')}}?param="+id, function(data) {
                    try{
                      $("#idInfoLaboralEditar").val(data.id);
                      $("#idUnidadEditar").val(data.unidad);
                      $("#idPadreEditar").val(data.plaza);
                      $("#fechaInicioEditar").val(data.fechaInicio);
                      $("#fechaFinEditar").val(data.fechaFin);
                      $("#fechaFinEditar").val(data.fechaFin);
                      $("#observacionEditar").val(data.observacion);
                    }
                    catch(e)
                    {
                      console.log(e);
                    }
                    
                  });

              $('#editarInfoLaboral').modal("toggle");
              $('#formEditarInfoLaboral').submit(function(e){
              var formObj = $(this);
              var formURL = formObj.attr("action");
              var formData = new FormData(this);
              $.ajax({
                data: formData,
                url: formURL,
                type: 'post',
                mimeType:"multipart/form-data",
                  contentType: false,
                    cache: false,
                    processData:false,
                beforeSend: function() {
                  $('body').modalmanager('loading');
                },
                success:  function (response){
                      $('body').modalmanager('loading');
                      if(isJson(response)){
                        alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n registrada de forma exitosa!</p></strong>",function(){
                          var obj =  JSON.parse(response);
                         window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
                        });
                        
                      }else{
                        alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
                      }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                  $('body').modalmanager('loading');
                  alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
                        console.log("Error en peticion AJAX!");  
                    }
              });
              e.preventDefault(); //Prevent Default action. 

              });
}

	function nuevaInfoLaboral(){
 							$('#nuevaInfoLaboral').modal("toggle");

                              	$('#formNuevaInfoLaboral').submit(function(e){
					        var formObj = $(this);
					        var formURL = formObj.attr("action");
					      var formData = new FormData(this);
					    $.ajax({
					      data: formData,
					      url: formURL,
					      type: 'post',
					      mimeType:"multipart/form-data",
					        contentType: false,
					          cache: false,
					          processData:false,
					      beforeSend: function() {
					        $('body').modalmanager('loading');
					      },
					      success:  function (response){
					            $('body').modalmanager('loading');
					            if(isJson(response)){
					              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n registrada de forma exitosa!</p></strong>",function(){
					                var obj =  JSON.parse(response);
					               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
					              });
					              
					            }else{
					              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
					            }
					          },
					          error: function(jqXHR, textStatus, errorThrown) {
					        $('body').modalmanager('loading');
					        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
					              console.log("Error en peticion AJAX!");  
					          }
					    });
					    e.preventDefault(); //Prevent Default action. 

					    });
}

		function nuevaAmonestacion(){
 							$('#nuevaSanciones').modal("toggle");
 							$('#formNuevaSanciones').submit(function(e){
					        var formObj = $(this);
					        var formURL = formObj.attr("action");
					      var formData = new FormData(this);
					    $.ajax({
					      data: formData,
					      url: formURL,
					      type: 'post',
					      mimeType:"multipart/form-data",
					        contentType: false,
					          cache: false,
					          processData:false,
					      beforeSend: function() {
					        $('body').modalmanager('loading');
					      },
					      success:  function (response){
					            $('body').modalmanager('loading');
					            if(isJson(response)){
					              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n registrada de forma exitosa!</p></strong>",function(){
					                var obj =  JSON.parse(response);
					               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
					              });
					              
					            }else{
					              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
					            }
					          },
					          error: function(jqXHR, textStatus, errorThrown) {
					        $('body').modalmanager('loading');
					        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
					              console.log("Error en peticion AJAX!");  
					          }
					    });
					    e.preventDefault(); //Prevent Default action. 

					    });
}

				function nuevoEstudio(){
						 $.get("{{route('data.tipoEstudio.empleado')}}", function(data){
                               $.each(data, function(i, value) {
                              $('#idTipoNuevo').append('<option value="'+value.idTipo+'">'+value.nombreTipo+'</option>');
                                });
          			
                          });

                         /* $.get("{{route('data.institucionEstudio.empleado')}}", function(data){
                               $('#idInstitucionNuevo').append('<select class="js-source-states" style="visibility: hidden">');

                               $.each(data, function(i, value) { 
                              $('#idInstitucionNuevo').append('<option value="'+value.idInstitucion+'">'+value.nombreInstitucion+'</option>');
                                });
                                $('#idInstitucionNuevo').append('</select>');
                          });*/
					var estName = $('#idInstitucionNuevo').selectize({
							        valueField: 'idInstitucion',
							        labelField: 'nombreInstitucion',        
							        searchField: 'nombreInstitucion',
							        maxOptions: 10,
							        options: [],
							        create: false,
							        render: {
							            option: function(item, escape) {
							                return '<div>' +escape(item.nombreInstitucion) +' ('+escape(item.nombrePais) +')</div>';
							              }
							        },
							        load: function(query, callback) {
							                if (!query.length) return callback();
							                $.ajax({
							                    url: "{{route('data.institucionesBuscar.empleado')}}",
							                    type: 'GET',
							                    dataType: 'json',
							                    data: {
							                        q: query
							                    },
							                    error: function() {
							                        callback();
							                    },
							                    success: function(res) {
							                        callback(res.data);
							                    }
							                });
							        }
							  }); /*fin del selectize*/
                          $('#nuevoEstudio').modal("toggle");
					      $('#formNuevoEstudio').submit(function(e){
					        var formObj = $(this);
					        var formURL = formObj.attr("action");
					      var formData = new FormData(this);
					    $.ajax({
					      data: formData,
					      url: formURL,
					      type: 'post',
					      mimeType:"multipart/form-data",
					        contentType: false,
					          cache: false,
					          processData:false,
					      beforeSend: function() {
					        $('body').modalmanager('loading');
					      },
					      success:  function (response){
					            $('body').modalmanager('loading');
					            if(isJson(response)){
					              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n actualizada de forma exitosa!</p></strong>",function(){
					                var obj =  JSON.parse(response);
					               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
					              });
					              
					            }else{
					              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
					            }
					          },
					          error: function(jqXHR, textStatus, errorThrown) {
					        $('body').modalmanager('loading');
					        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
					              console.log("Error en peticion AJAX!");  
					          }
					    });
					    e.preventDefault(); //Prevent Default action. 

					    });
					     

}
			function nuevoContacto(){
	   				    $.get("{{route('data.parentesco.empleado')}}", function(data){
                               $.each(data, function(i, value) {                                 
                              $('#idParentescoNuevo').append('<option value="'+value.idParentesco+'">'+value.nombreParentesco+'</option>');
                                });
          
                          });
				$('#nuevoFormContacto').modal("toggle");
				$('#formNuevoContacto').submit(function(e){
			        var formObj = $(this);
			        var formURL = formObj.attr("action");
			      var formData = new FormData(this);
			    $.ajax({
			      data: formData,
			      url: formURL,
			      type: 'post',
			      mimeType:"multipart/form-data",
			        contentType: false,
			          cache: false,
			          processData:false,
			      beforeSend: function() {
			        $('body').modalmanager('loading');
			      },
			      success:  function (response){
            $('body').modalmanager('loading');
            if(isJson(response)){
              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n actualizada de forma exitosa!</p></strong>",function(){
                var obj =  JSON.parse(response);
               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
              });
              
            }else{
              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
            }
		          },
		          error: function(jqXHR, textStatus, errorThrown) {
		        $('body').modalmanager('loading');
		        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
		              console.log("Error en peticion AJAX!");  
		          }
		    });
		    e.preventDefault(); //Prevent Default action. 

		    });
}

			function editarInfoContactos(id){

   				   $.get("{{route('data.contactos.empleado')}}?param="+id, function(data) {
                    try{
                      $('#nombre').val(""); 
                      $('#idContacto').val("");
                      $('#telMovil').val("");
                      $('#telFijo').val("");
                      $('#direccion').val("");
                       document.getElementById("idParentesco").length=0;


                      $('#nombre').val(data.nombre); 
                      $('#idContacto').val(data.id);
                      $('#telMovil').val(data.celular);
                      $('#telFijo').val(data.telefonoFijo);
                      $('#direccion').val(data.direccion);
                      var idParentesco = data.parentesco;

                          $.get("{{route('data.parentesco.empleado')}}", function(data){
                               $.each(data, function(i, value) {
                                     if(idParentesco==value.idParentesco){
                              $('#idParentesco').append('<option selected value="'+value.idParentesco+'">'+value.nombreParentesco+'</option>');
                            }else{
                              $('#idParentesco').append('<option value="'+value.idParentesco+'">'+value.nombreParentesco+'</option>');
                            }
                               
                                });
          
                          });
                    }
                    catch(e)
                    {
                      console.log(e);
                    }
                    
                  });
				        
				    $('#infoContactos').modal('toggle');
				    $('#formContactos').submit(function(e){
				        var formObj = $(this);
				        var formURL = formObj.attr("action");
				      var formData = new FormData(this);
				    $.ajax({
				      data: formData,
				      url: formURL,
				      type: 'post',
				      mimeType:"multipart/form-data",
				        contentType: false,
				          cache: false,
				          processData:false,
				      beforeSend: function() {
				        $('body').modalmanager('loading');
				      },
				      success:  function (response){
				            $('body').modalmanager('loading');
				            if(isJson(response)){
				              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n actualizada de forma exitosa!</p></strong>",function(){
				                var obj =  JSON.parse(response);
				               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
				              });
				              
				            }else{
				              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
				            }
				          },
				          error: function(jqXHR, textStatus, errorThrown) {
				        $('body').modalmanager('loading');
				        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
				              console.log("Error en peticion AJAX!");  
				          }
				    });
				    e.preventDefault(); //Prevent Default action. 

				    });
}
		function mostrarFoto(){
				$('#foto').modal('toggle');

		}

				function editarInfoEstudios(id){

   				    $.get("{{route('data.estudio.empleado')}}?param="+id, function(data) {
                    try{
                      $('#titulo').val(""); 
                      $('#idEstudio').val("");
                      $('#anno').val("");
                      document.getElementById("idTipo").length=0;
                      document.getElementById("idInstitucion").length=0;
                       $('#lugar').val("");
                      

                      $('#titulo').val(data.titulo); 
                      $('#idEstudio').val(data.id);
                      $('#anno').val(data.annio);
                      $('#lugar').val(data.lugar);
                      var idTipo = data.tipoEstudio;
                      var idInstitucion = data.institucionIdestudio;
                      var b1 =1;


                          $.get("{{route('data.tipoEstudio.empleado')}}", function(data){
                               $.each(data, function(i, value) {
                                     if(idTipo==value.idTipo){
                              $('#idTipo').append('<option selected value="'+value.idTipo+'">'+value.nombreTipo+'</option>');
                            }else{
                              $('#idTipo').append('<option value="'+value.idTipo+'">'+value.nombreTipo+'</option>');
                            }
                               
                                });
          			
                          });

                          $.get("{{route('data.institucionEstudio.empleado')}}", function(data){
                              
                          		 
                               $.each(data, function(i, value) {
                                     if(idInstitucion==value.idInstitucion){
                              $('#idInstitucion').append('<option selected value="'+value.idInstitucion+'">'+value.nombreInstitucion+' ('+value.nombrePais+')</option>');
                              b1= b1+1;
                            }else{
                              $('#idInstitucion').append('<option value="'+value.idInstitucion+'">'+value.nombreInstitucion+'  ('+value.nombrePais+')</option>');
                            }
                               
                                });
                             if(b1==1){
                                $('#idInstitucion').append('<option selected value="NULL">Seleccione la una institución de estudio...</option>');
                              }


          
                          });
                    }
                    catch(e)
                    {
                      console.log(e);
                    }
                    
                  });
        
				    $('#infoEstudios').modal('toggle');
				    $('#formEstudios').submit(function(e){
				        var formObj = $(this);
				        var formURL = formObj.attr("action");
				      var formData = new FormData(this);
				    $.ajax({
				      data: formData,
				      url: formURL,
				      type: 'post',
				      mimeType:"multipart/form-data",
				        contentType: false,
				          cache: false,
				          processData:false,
				      beforeSend: function() {
				        $('body').modalmanager('loading');
				      },
				      success:  function (response){
				            $('body').modalmanager('loading');
				            if(isJson(response)){
				              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n actualizada de forma exitosa!</p></strong>",function(){
				                var obj =  JSON.parse(response);
				               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
				              });
				              
				            }else{
				              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
				            }
				          },
				          error: function(jqXHR, textStatus, errorThrown) {
				        $('body').modalmanager('loading');
				        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
				              console.log("Error en peticion AJAX!");  
				          }
				    });
				    e.preventDefault(); //Prevent Default action. 

				    });
}

 		function editarInfoSanciones(id){

    					$.get("{{route('data.sanciones.empleado')}}?param="+id, function(data) {
                    try{
                      $('#fecha').val(""); 
                      $('#idSancion').val("");
                      $('#fechaPrescripcion').val("");
                      //document.getElementById("txtTipoSancion").length=0;
                       $('#motivo').val("");
                       $('#descripcion').val("");
                      

                      $('#fecha').val(data.fecha.substr(0,10)); 
                      $('#idSancion').val(data.id);
                      $('#fechaPrescripcion').val(data.fechaPrescripcion.substr(0,10));
                      $('#motivo').val(data.motivo);
                      $('#descripcion').val(data.descripcion);
                      var idTipo = data.tipoId; 
                      if(idTipo==1){
                      	$('#idTipoSancion').append('<option selected value="1">Amonestación verbal</option><option value="2">Amonestación por escrito</option><option value="3">Suspensión</option><option value="4">Terminación contrato</option>')
                      }
                      if(idTipo==2){
                      	$('#idTipoSancion').append('<option  value="1">Amonestación verbal</option><option selected value="2">Amonestación por escrito</option><option value="3">Suspensión</option><option value="4">Terminación contrato</option>')
                      }
                      if(idTipo==3){
                      	$('#idTipoSancion').append('<option value="1">Amonestación verbal</option><option value="2">Amonestación por escrito</option><option value="3" selected>Suspensión</option><option value="4">Terminación contrato</option>')
                      }
                       if(idTipo==4){
                      	$('#idTipoSancion').append('<option  value="1">Amonestación verbal</option><option  value="2">Amonestación por escrito</option><option value="3">Suspensión</option><option selected value="4">Terminación contrato</option>')
                      }



  
                    }
                    catch(e)
                    {
                      console.log(e);
                    }
                    
                  });
				        
				    $('#infoSanciones').modal('toggle');
				    $('#formSanciones').submit(function(e){
				        var formObj = $(this);
				        var formURL = formObj.attr("action");
				      var formData = new FormData(this);
				    $.ajax({
				      data: formData,
				      url: formURL,
				      type: 'post',
				      mimeType:"multipart/form-data",
				        contentType: false,
				          cache: false,
				          processData:false,
				      beforeSend: function() {
				        $('body').modalmanager('loading');
				      },
				      success:  function (response){
				            $('body').modalmanager('loading');
				            if(isJson(response)){
				              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n actualizada de forma exitosa!</p></strong>",function(){
				                var obj =  JSON.parse(response);
				               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
				              });
				              
				            }else{
				              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
				            }
				          },
				          error: function(jqXHR, textStatus, errorThrown) {
				        $('body').modalmanager('loading');
				        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
				              console.log("Error en peticion AJAX!");  
				          }
				    });
				    e.preventDefault(); //Prevent Default action. 

				    });
}
        function deleteSancion(id){
            alertify.confirm('Esta segur@ que desea eliminar este registro?',function(e){
                $.ajax({
                   data:  {_token:'{{ csrf_token() }}',idSancion: id},
                    url: "{{route('post.eliminar.sancion')}}",
                    type: "post",
                    cache: false,
                    beforeSend: function()
                    {
                        $('body').modalmanager('loading');
                    },
                    success: function (response) {
                        $('body').modalmanager('loading');
                        var obj =  JSON.parse(response);
                        console.log(response);
                        if(isJson(response)){
                            alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Registro eliminado exitosamente!</p></strong>",function(){
                                var obj =  JSON.parse(response);
                                window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
                            });

                        }else{
                            alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
                        }
                    }
                });
            });
        }
function eliminarInfoContactos(id){
	alertify.confirm('Mensaje de sistema','¿Esta seguro que desea elimiar el contacto?',function(){
		$.ajax({
			data : {_token:'{{ csrf_token() }}',txtIdContacto: id},
			url: "{{ route('urh.infoContacto.borrar') }}",
			type: "post",
			cache: false,
			mimeType:"multipart/form-data",
			 beforeSend: function() {
				        $('body').modalmanager('loading');
				      },
	        success:  function (response){
	        	$('body').modalmanager('loading');
				            if(isJson(response)){
				              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Registro eliminado exitosamente!</p></strong>",function(){
				                var obj =  JSON.parse(response);
				               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
				              });
				              
				            }else{
				              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
				            }
				          },
	        error: function(jqXHR, textStatus, errorThrown) {
				alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo eliminar el contacto!</p></strong>");
	          	console.log("Error en peticion AJAX!");  
	        }
		});
	    },null).set('labels', {ok:'SI', cancel:'NO'}); 
}
function eliminarInfoEstudios(id){
	alertify.confirm('Mensaje de sistema','¿Esta seguro que desea elimiar la información de estudio?',function(){
		$.ajax({
			data : {_token:'{{ csrf_token() }}',txtIdEstudio: id},
			url: "{{ route('urh.infoEstudios.borrar') }}",
			type: "post",
			cache: false,
			mimeType:"multipart/form-data",
			 beforeSend: function() {
				        $('body').modalmanager('loading');
				      },
	        success:  function (response){
	        	$('body').modalmanager('loading');
				            if(isJson(response)){
				              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Registro eliminado exitosamente!</p></strong>",function(){
				                var obj =  JSON.parse(response);
				               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
				              });
				              
				            }else{
				              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
				            }
				          },
	        error: function(jqXHR, textStatus, errorThrown) {
				alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo eliminar el contacto!</p></strong>");
	          	console.log("Error en peticion AJAX!");  
	        }
		});
	    },null).set('labels', {ok:'SI', cancel:'NO'}); 
}

function nuevoDocumento(idTipo){
 							$('#nuevoFormDocumento').modal("toggle");
 							$('#idTipoDoc').val(idTipo);

 					     $('#formDocumentoEmpleado').submit(function(e){
					      var formObj = $(this);
					      var formURL = formObj.attr("action");
					      var formData = new FormData(this);
					    $.ajax({
					      data: formData,
					      url: formURL,
					      type: 'post',
					      mimeType:"multipart/form-data",
					      contentType: false,
					      cache: false,
					      processData:false,
					      beforeSend: function() {
					        $('body').modalmanager('loading');
					      },
					      success:  function (response){
					            $('body').modalmanager('loading');
					            if(isJson(response)){
					              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Informaci&oacute;n registrada de forma exitosa!</p></strong>",function(){
					                var obj =  JSON.parse(response);
					               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
					              });
					              
					            }else{
					              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
					            }
					          },
					          error: function(jqXHR, textStatus, errorThrown) {
					        $('body').modalmanager('loading');
					        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la informaci&oacute;n!</p></strong>");
					              console.log("Error en peticion AJAX!");  
					          }
					    });
					    e.preventDefault(); //Prevent Default action. 

					    });
}
function eliminarDocPersonal(id){
	alertify.confirm('Mensaje de sistema','¿Esta seguro que desea elimiar el documento?',function(){
		$.ajax({
			data : {_token:'{{ csrf_token() }}',idDocumento: id},
			url: "{{ route('urh.documentopersonal.borrar') }}",
			type: "post",
			cache: false,
			mimeType:"multipart/form-data",
			 beforeSend: function() {
				        $('body').modalmanager('loading');
				      },
	        success:  function (response){
	        	$('body').modalmanager('loading');
				            if(isJson(response)){
				              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Registro eliminado exitosamente!</p></strong>",function(){
				                var obj =  JSON.parse(response);
				               window.location.href = "{{route('ver.expediente.empleado',['idEmpleado'=>Crypt::encrypt($persona->idEmpleado) ])}}"
				              });
				              
				            }else{
				              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>")
				            }
				          },
	        error: function(jqXHR, textStatus, errorThrown) {
				alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo eliminar el contacto!</p></strong>");
	          	console.log("Error en peticion AJAX!");  
	        }
		});
	    },null).set('labels', {ok:'SI', cancel:'NO'}); 
}

 function isJson(str) {
      try {
          JSON.parse(str);
      } catch (e) {
          return false;
      }
      return true;
  }

function tipoDeContrato(){
	var tipoContrato = $('#cmbTipoContrato option:selected').val();

	if(tipoContrato==4){//Contrato Tipo Pruebas

		$('#datosDePrueba').show();
	}else{

		$('#datosDePrueba').hide();
	}
}

</script>
@endsection
