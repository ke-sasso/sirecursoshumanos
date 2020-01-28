<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title> </title>
    <style type="text/css">

      body{
        font-size: {{$texto}}px;
        font-family: "Times New Roman" !important;
      }
      table {
         border-collapse: collapse;
         max-width: 350px;
         min-width: 350px;
         margin-top: 120px;
         text-align: justify;
         font-family: "Times New Roman" !important;
      }
      td,th {
        border: 1px black solid;
         padding: 1px;
         font-family: "Times New Roman" !important;
      }




    </style>
  </head>
  <body>



            <div >
                   <main>
                            <table align="center">
                                <tr style="text-align: center;">
                                    <td colspan="1">{{$plaza->fechaInicial}}</td>
                                    <td colspan="6"><b>MATRIZ DACUM</b></td>

                                </tr>
                                <tr style="text-align: center;">
                                    <td><b>Puesto:</b><br/>{{$plaza->nombrePlaza}}</td>
                                    <td><b>Area:</b><br/>@if(!empty($plaza->plazanominal)){{$plaza->plazanominal->nombrePlazaNominal}}@endif</td>
                                    <td colspan="3"><b>Dirección/Gerencia/Unidad:</b><br/>{{$plaza->unidad->nombreUnidad}}</td>
                                    <td><b>Jefatura a la que reporta:</b><br/>{{$plaza->plazaPadre->nombrePlaza}}</td>
                                    <td><b>Categoría(s):</b><br/>@if(!empty($plaza->plazanominal)){{$plaza->plazanominal->nombrePlazaNominal}}@endif</td>

                                </tr>
                                <tr style="text-align: center;">
                                    <td colspan="1"><b>FUNCIONES<br> (Unidades de Competencia)</b></td>
                                    <td colspan="6"><b>TAREAS (Elementos de Competencia)</b></td>
                                </tr>


        @if(!empty($plaza->funciones))
        @foreach($plaza->funciones as $funcion)
                  @if(!empty($funcion->tareas->where('activo',1)))
                           @if(count($funcion->tareas->where('activo',1))<7)
                                          <tr>
                                            <td>{{$funcion->literal}}.{{$funcion->nombreFuncion}}</td>
                                            @foreach($funcion->tareas->where('activo',1) as $tarea)
                                            <td>{{$funcion->literal}}. <b>{{$tarea->numero}}</b> {{$tarea->nombreTarea}}</td>
                                            @endforeach
                                             @if(count($funcion->tareas->where('activo',1))==1)
                                              <td></td>  <td></td>  <td></td>  <td></td> <td></td>
                                             @elseif(count($funcion->tareas->where('activo',1))==2)
                                              <td></td>  <td></td>  <td></td>  <td></td>
                                             @elseif(count($funcion->tareas->where('activo',1))==3)
                                              <td></td>  <td></td>  <td></td>
                                             @elseif(count($funcion->tareas->where('activo',1))==4)
                                              <td></td>  <td></td>
                                             @elseif(count($funcion->tareas->where('activo',1))==5)
                                              <td></td>
                                             @endif

                                          </tr>
                        @else
                                <tr>
                                      <td rowspan="2">{{$funcion->literal}}.{{$funcion->nombreFuncion}}</td>
                                       @foreach($funcion->tareas->where('activo',1)->whereIn('numero',[1,2,3,4,5,6]) as $tarea)
                                            <td>{{$funcion->literal}}. <b>{{$tarea->numero}}</b>  {{$tarea->nombreTarea}}</td>
                                      @endforeach

                                </tr>
                                <tr>
                                       @foreach($funcion->tareas->where('activo',1)->where('numero','>',6) as $tarea)
                                            <td>{{$funcion->literal}}. <b>{{$tarea->numero}}</b>  {{$tarea->nombreTarea}}</td>
                                      @endforeach
                                          @if(count($funcion->tareas->where('activo',1)->where('numero','>',6) )==1)
                                              <td></td>  <td></td>  <td></td>  <td></td>  <td></td>
                                          @elseif(count($funcion->tareas->where('activo',1)->where('numero','>',6) )==2)
                                             <td>1</td>  <td></td>  <td></td>  <td></td>
                                          @elseif(count($funcion->tareas->where('activo',1)->where('numero','>',6) )==3)
                                              <td></td>  <td></td>  <td></td>
                                          @elseif(count($funcion->tareas->where('activo',1)->where('numero','>',6) )==4)
                                              <td></td>  <td></td>
                                          @elseif(count($funcion->tareas->where('activo',1)->where('numero','>',6) )==5)
                                              <td></td>
                                          @endif

                                </tr>
                       @endif
                  @endif
            @endforeach
            @endif
                            </table>
                   </main>
              </div>


    <footer id="footer">
    </footer>

  </body>

</html>