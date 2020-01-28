@extends('master')

@section('css')



</style>
@endsection

@section('contenido')

@if(isset($jefatura))
    @if( $jefatura == 0)
        <div class="row">
          <a href="{{route('index.empleados')}}">      
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">

                                <i class="fa fa-user fa-4x"></i>
                            </div>
                            <div class="col-xs-9 text-right">              
                                <div style="color:#F5FFFA;"> EXPEDIENTE LABORAL</div>
                                <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            </div><!-- /.progress-bar .progress-bar-info -->
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

         <a href="{{route('evaluacion.listar')}}">     
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">

                            <i class="fa fa-pencil-square-o fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">    
                                  
                            <div style="color:#F5FFFA;">EVALUACIONES</div>
                       <div class="progress no-rounded progress-xs">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        </div><!-- /.progress-bar .progress-bar-info -->
                    </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </a>
        <a href="{{route('all.seguros')}}">  
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">

                            <i class="fa fa-folder-open-o fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">                  
                            <div style="color:#F5FFFA;">SOLICITUDES</div>
                        <div class="progress no-rounded progress-xs">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        </div><!-- /.progress-bar .progress-bar-info -->
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         </a>


        <a href="{{route('unidad.listar')}}">   
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">

                            <i class="fa fa-info fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">                 
                            <div style="color:#F5FFFA;">CATÁLOGO R.H</div>
                            <div class="progress no-rounded progress-xs">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        </div><!-- /.progress-bar .progress-bar-info -->
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
         </a>
        <div class="row">

         <a href="{{route('rh.capacitaciones.admin')}}">     
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">

                            <i class="glyphicon glyphicon-pushpin fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">    
                                 
                            <div style="color:#F5FFFA;">PLAN DE CAPACITACIONES</div>

                            <div class="progress no-rounded progress-xs">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        </div><!-- /.progress-bar .progress-bar-info -->
                    </div>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
         </a>

        </div>
    @else
        <div class="row">

         <a href="{{route('plazaFunc.listar')}}">     
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">

                            <i class="glyphicon glyphicon-pushpin fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">    
                                 
                            <div style="color:#F5FFFA;">CATÁLOGO PLAZAS FUNCIONALES</div>

                            <div class="progress no-rounded progress-xs">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        </div><!-- /.progress-bar .progress-bar-info -->
                    </div>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
         </a>

        </div>
    @endif
@else
    <script type="text/javascript">
        window.location.href = '{{url('login')}}'
    </script>
@endif
@endsection

@section('js')


@endsection