@extends('master')

@section('css')
{!! Html::style('plugins/selectize-js/dist/css/selectize.bootstrap3.css') !!} 
<style type="text/css">
    td.details-control {
        background: url("{{ asset('/plugins/datatable/images/details_open.png') }}") no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url("{{ asset('/plugins/datatable/images/details_close.png') }}") no-repeat center center;
    }
</style>
@endsection

@section('contenido')
{{-- MENSAJE DE EXITO --}}
@if(Session::has('msnExito'))
  <div class="alert alert-success square fade in alert-dismissable">
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
    <strong>Enhorabuena!</strong>
    {{ Session::get('msnExito') }}
  </div>
@endif
{{-- MENSAJE DE ERROR --}}
@if(Session::has('msnError'))
  <div class="alert alert-danger square fade in alert-dismissable">
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
    <strong>Algo ha salido mal.!</strong>
      {{ Session::get('msnError') }}
  </div>
@endif
<?php 
  $checked = "";
  if($cap[0]->evaluar == '1')
  {
    $checked = 'checked="checked"';
  }


?>
<style type="text/css" media="screen">
  .icheckbox_minimal-grey
  {
    margin-left: 0;
    margin-right: 0;
  }
</style>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"></h3>
  </div>
  <div class="panel-body">
    <form id="frmCapacitacion">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />          
          <input type="hidden" name="idCapacitacion" value="{{ $cap[0]->idCapacitacion }}">
          <div class="modal-body">
            <div class="form-group">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <div class="input-group-addon">Nombre Capacitación</div>
                  <input type="text" class="form-control text-uppercase" name="nombreCapacitacion" id="nombreCapacitacion" value="{{ $cap[0]->nombreCapacitacion }}" >
                </div>
              </div>
             
            </div>
            <br>
            <br>
              <div class="form-group">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                
                  <div class="input-group-addon">Entidad que la imparte</div>

                  <select name="entidad" id="entidad" class="form-control">
                    <option></option>}
                    option
                    @foreach($institucion as $in)
                       @if($cap[0]->entidad == $in->idInstitucion)
                       <option value="{{$in->idInstitucion}}" selected>{{$in->nombreInstitucion}} </option>
                      @else
                    <option value="{{$in->idInstitucion}}">{{$in->nombreInstitucion}} </option>
                      @endif
                    @endforeach

                  </select>
            
                
              </div>
              
            </div>
            <br>
            <br>
            <br>
            <div class="form-group">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <div class="input-group-addon">Instructor que la imparte</div>
                  <input type="text" class="form-control text-uppercase"  value="{{ $cap[0]->instructor}}" name="instructor" id="instructor" >
                </div>
              </div>
              
            </div>
            <br>
            <br>
            <div class="form-group">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <div class="input-group-addon">Lugar donde se desarroll&oacute;</div>
                  <textarea  type="text" class="form-control text-uppercase" name="lugar" id="lugar">{{$cap[0]->lugar}}</textarea>
                </div>
              </div>
              
            </div>
            <br>
            <br>
            <br>
            <div class="form-group">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="input-group">
                  <div class="input-group-addon">Fecha Desde</div>
                  <input type="text" class="form-control datepicker" placeholder="yyyy-mm-dd" id="fechaDesde" name="fechaDesde" value="{{ \Carbon\Carbon::parse($cap[0]->fechaDesde)->format('Y-m-d') }}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="input-group">
                  <div class="input-group-addon">Fecha Hasta</div>
                  <input type="text" class="form-control datepicker" placeholder="yyyy-mm-dd" id="fechaHasta" name="fechaHasta" value="{{ \Carbon\Carbon::parse($cap[0]->fechaHasta)->format('Y-m-d') }}" >
                </div>
              </div>
            </div>
            <br>
            <br>
            <div class="form-group">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <div class="input-group-addon">Evaluación de Desempeño</div>
                  <select name="idEvaluacion" id="idEvaluacion" class="form-control">
                    
                  </select>
                </div>
              </div>
            </div>
          </div>
          <fieldset class="panel-footer">              
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="input-group">
                  <div class="input-group-addon"><input type="checkbox" class="i-grey" id="evaluar" name="evaluar" value="1" <?php echo $checked; ?>></div>
                  <div class="input-group-addon" >Habilitar Evaluación</div>
                  <input type="text" class="form-control datepicker" id="fechaHastaEvaluacion" name="fechaHastaEvaluacion" value="{{ \Carbon\Carbon::parse($cap[0]->fechaHastaEvaluacion)->format('Y-m-d') }}">
                </div>
              </div>
          </fieldset>

          <div class="modal-footer"> 
          <div align="center">           
            <button type="button" id="btnSend" class="btn btn-primary"><i class="fa fa-check"></i>Editar</button>
              <a href="{{ route('rh.capacitaciones.admin')}}" class="btn btn-warning"><i class="fa fa-reply"></i> Regresar</a>
              </div>
          </div>
    </form>
  </div>
</div>
<form id="form" method="post" action="{{ route('rh.capacitaciones.items.guardar') }}">

</form>
<!-- BEGIN DATA TABLE -->
<div class="the-box">
    <div class="table-responsive">
    <table class="table table-striped table-hover" id="dt-capacitaciones-items" style="font-size:13px;" width="100%">
        <thead class="the-box dark full">
            <tr>
                <th>Id Empleado</th>
                <th width="30%">Nombre Empleado</th>
                <th>Plaza</th>
                <th>Unidad</th>       
                <th width="50%">Descripción</th>
                <th width="5%"></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    </div><!-- /.table-responsive -->
</div><!-- /.the-box .default -->
<!-- END DATA TABLE -->


@endsection

@section('js')
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
<script>
$(document).ready(function() {
$('#fechaDesde').mask('0000-00-00');
    $('#fechaHasta').mask('0000-00-00');
  $.get('{{route('edc.evaluaciones.rh')}}', function(data) {
    try
    {
      $('#idEvaluacion option').remove();
      
      $.each(data, function(index, val) {
        if(val.idEvaluacion == {{ $cap[0]->idEvaluacion }})
        {
          $('#idEvaluacion').append('<option selected="selected" value="'+val.idEvaluacion+'">'+val.nombre+' - '+val.periodo+'</option>');
        }
        else
        {
          $('#idEvaluacion').append('<option value="'+val.idEvaluacion+'">'+val.nombre+' - '+val.periodo+'</option>');        
        }
        
      });
    } 
    catch(e)
    {
      console.log(e);
    } 
  });

  var searchCount = 0;
   var estName = $('#entidad').selectize({
                      valueField: 'idInstitucion',
                      labelField: 'nombreInstitucion',        
                      searchField: 'nombreInstitucion',
                      maxOptions: 10,
                      options: [],
                      create: false,
                      render: {
                          option: function(item, escape) {
                              return '<div>' +escape(item.nombreInstitucion) +'</div>';
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
                });

  var table = $('#dt-capacitaciones-items').DataTable({
      serverSide: true,
      processing: true,
      searching: false,
      ajax: {
        url: "{{ url('/training/detalleCapacitacion/') }}"+"/{{ $cap[0]->idCapacitacion}}",
        data: function(d){
          d.searchCount = searchCount;  
          d.unidad = $('#unidad').val();
          d.plazaFuncional = $('#plazaFuncional').val();
          d.estado = $('#estado').val();
          d.evaluacion =  $('#evaluacion').val();
        },
      },
      columns: [          
          {data: 'idEmpleado', name: 'idEmpleado'},
          {data: 'nombreEmpleado', name: 'nombreEmpleado'},
          {data: 'nombrePlaza', name: 'nombrePlaza'},
          {data: 'nombreUnidad', name: 'nombreUnidad'},      
          {data: 'descripcion', name: 'descripcion', orderable: false, searchable: false},
          {data: 'add', name: 'add', orderable: false, searchable: false} 
      ],
      language: {
          "url": "{{ asset('plugins/datatable/lang/es.json') }}"
      },
      order: [[0, 'asc']],
      scrollY: "400px",
      scrollCollapse: true,
      paging: false
  });


  $('#dt-capacitaciones-items tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table.row(tr);

      if ( row.child.isShown() ) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
      }
      else {
          // Open this row
          row.child( format(row.data()) ).show();
          tr.addClass('shown');
      }
  });

  

});


$('#btnSend').on('click', function(event) {
    event.preventDefault();
    $('#frmCapacitacion :input').each(function(index, el) {
        $(this).parent().removeClass('has-error');
    });
    $.ajax({
      url: '{{route('new.capacitaciones.rh')}}',
      type: 'POST',
      dataType: 'JSON',
      data: $('#frmCapacitacion').serialize(),
    })
    .done(function(response) {
      try {
          
          if(response.status == 200)
          {
            alertify.alert('Mensaje del Sistema',response.message,function(){location.reload();});
            
          }
          else {
            alertify.alert('Mensaje del Sistema',response.message);
          }

      } catch(e) {
        // statements
        console.log(e);
      }
    })
    .fail(function(r) {
      if(r.status == 422)
      {
        var texto = '';
        $.each(r.responseJSON, function(index, val) {
           texto += val[0]+'<br>';
           $('#'+index).parent().addClass('has-error');
        });
        alertify.alert('Mensaje del Sistema',texto);
      }
      else
      {
        var mensajes = ''
        $.each(r, function(index, val) {
          mensajes += val+'<br>';         
        });       

        alertify.alert('Mensaje del Sistema',mensajes);
      }
    })
    .always(function() {
      console.log("complete");
    });
    
  });

</script>
@include('capacitaciones.auxs.add-capa-js')
@endsection
