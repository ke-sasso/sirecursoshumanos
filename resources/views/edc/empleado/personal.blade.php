@extends('master')

@section('css')
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
<div class="alert alert-info square fade in alert-dismissable">
    <strong>{{ $eva->nombre }} </strong><br>
</div>

<div class="row">
	<div class="col-sm-4">
		<div class="the-box">
           	<h4 class="small-title">DATOS PERSONALES</h4>
           	<div class="row">
			    <div class="form-group col-sm-12 col-xs-12">
			        <label>Nombre Completo</label>
			        <input type="text" class="form-control" disabled value="{{ $emp->getNombreCompleto() }}">
			    </div>
			</div>
			<div class="row">
			    <div class="form-group col-sm-6 col-xs-12">
			        <label>Género</label>
			        <input type="text" class="form-control" disabled value="{{$emp->getTextoGenero()}}">
			    </div>
			</div>
			<div class="row">
			    <div class="form-group col-sm-12 col-xs-12">
			        <label>Unidad</label>
			        <input type="text" class="form-control" disabled value="{{ $emp->getTextoNombreUnidad() }}">
			    </div>
			</div>
			<div class="row">
			    <div class="form-group col-sm-12 col-xs-12">
			        <label>Plaza Funcional</label>
			        <input type="text" class="form-control" disabled value="{{ $emp->getTextoNombrePlazaFuncional() }}">
			    </div>
			</div>
        </div>
        @if(!empty($resultado))
            <div class="the-box">
                <div class="row">
                    <div class="form-group col-sm-12 col-xs-12">
                        <label class="control-label"> Comentarios</label>
                        <textarea class="form-control" name="txtComentarios" rows="6" disabled="true">{{ $resultado->comentarios}}</textarea>
                        <p class="help-block">Comentario persona evaluada</p>
                    </div>
                </div>
            </div>
        @endif
	</div>
	<div class="col-sm-8">
        @if(empty($resultado) || $resultado->finalizada == 0)
            <div class="the-box full no-border">
                <div class="alert alert-warning alert-block fade in alert-dismissable">
                    <blockquote>
                    <b><p>EVALUACION DE DESEMPEÑO NO HA SIDO ENVIADO POR LA JEFATURA CORRESPONDIENTE</p>
                    </b>
                    </blockquote>
                </div>
            </div>
        @else
             <div class="the-box">
                <h4 class="small-title">RESUMEN DE RESULTADO OBTENIDO</h4>
                <div class="row">
                    <div class="form-group col-sm-6 col-xs-12 {{ $resultado->estado->claseInput }}">
                        <label class="control-label"> CP</label>
                        <input type="text" class="form-control" value="{{ $resultado->CP }} %" disabled="true">
                        <p class="help-block">Competencia en la plaza de Trabajo (%)</p>
                    </div>         
                    <div class="form-group col-sm-6 col-xs-12 {{ $resultado->estado->claseInput }}">
                        <label class="control-label"> Resultado</label>
                        <input type="text" class="form-control" value="{{ $resultado->estado->nombreEstado }}" disabled="true">
                        <p class="help-block">Resultado obtenido</p>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-th-block table-primary">
                            <thead>
                                <tr><th style="width: 15%;"></th><th style="width: 75%;">FUNCION</th><th colspan="2" style="width: 10%;">RESULTADO</th></tr>
                            </thead>
                            <tbody>
                                @foreach($resultado->funciones()->orderBy('literal','asc')->get() as $f)
                                    <tr style="background-color:#0780E8;">
                                        <td><font color="#fff">Función {{ $f->literal }}</font></td>
                                        <td colspan="2"><font color="#fff">{{ $f->nombreFuncion }}</font></td>
                                        <td><font color="#fff">{{ (empty($f->CF) || ($f->finalizada == 0))?'NE':$f->CF.'%' }}</font></td>
                                    </tr>
                                    @foreach($f->tareas()->orderBy('numero','asc')->get() as $t)
                                        <tr style="background-color:#C9DFE8">
                                            <td colspan="2">{{ $t->numero.'. - '.$t->nombreTarea }}</td>
                                            <td>{{ (empty($t->CT))?'NE':$t->CT.'%' }} </td>
                                            <td>                                                
                                                <a href="{{route('empleado.temp.mostrar.tarea',['idRes' => Crypt::encrypt($resultado->idResultado), 'idTar' => Crypt::encrypt($t->idTarea) ])}}" class="btn btn-xs btn-info btn-perspective"><i class="fa fa-eye"></i> Mostrar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        @endif
    </div>
</div>

@endsection