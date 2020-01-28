<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> </title>
    <style type="text/css">

      body{
        font-size: {{$texto}}'px';
       text-align: justify;
      }

      div#header{
        width: 74%;
        display: inline-block;
        margin: 0 auto;
        border:1px solid black;
      }
      div#header img#escudo{
        height: 60px;
        width: auto;
        max-width: 20%;
        display: inline-block;
        margin: 0.5em;
      }
      div#header img#logo{
        height: 40px;
        width: auto;
        max-width: 20%;
        display: inline-block;
        margin: 0.5em;
      }
      div#header div#mainTitle{
        width: 65%;
        display: inline-block;
        margin: 0.5em;
        margin-right: 1em;
        text-align: center;
      }

      div#subTitle{
        width: 300px;
        height: 50px;
        margin: 0 auto;
        bottom: 200px;
        border: 2px solid black;
      }


      div#evidencias{
        width: auto;
        min-width: 90%;
        max-width: 90%;
        margin: 0 auto;

      }
       div#info{
        width: auto;
        min-width: 100%;
        max-width: 100%;
        margin: 0 auto;
      }
      @font-face {
            font-family: 'Arial Narrow';
            src: url({{ storage_path('fonts/ARIALN.TTF') }}) format('truetype');
       }
    @font-face {
        font-family: 'Arial Narrow';
        src: url({{ storage_path('fonts/ARIALNB.TTF') }}) format('truetype');
        font-weight: bold;
    }

      *{
        font-family: 'Arial Narrow' !important;
      }
      td.bold{
        font-family: 'Arial Narrow' !important;
        font-weight: 600;
      }

     @page {
       margin-top: 130px;
      }

    </style>
  </head>
  <body>
         @php
           // First letter uppercase
          if ( !function_exists('mb_ucfirst') ) {
            function mb_ucfirst($str, $to_lower = false, $charset = 'utf-8')
            {
              $first = mb_strtoupper(mb_substr($str, 0, 1, $charset), $charset);
              $end = mb_substr($str, 1, mb_strlen($str, $charset), $charset);
              // Convert them all to lowercase (if specified)
              if ( $to_lower ) {
                $end = mb_strtolower($end, $charset);
              }
              return $first . $end;
            }
          }
          @endphp
         <div id="info">
               <p><b>Habilidades generales:</b><br>{!!$plaza->habilidades!!}</p>
               <p><b>Conocimientos generales requeridos (Nivel Académico):</b><br>{!!$plaza->conocimientos!!}</p>
               <p><b>Actitudes y conductas generales: </b><br> @if(!empty($plaza->dataconocimientos))
                                      @foreach($plaza->dataconocimientos as $cono)
                                          {{$loop->iteration}}. <?php echo mb_ucfirst(mb_strtolower($cono->actitud->nombreTipoActitud)); ?><br>
                                      @endforeach
                                  @endif</p>
               <p><b>Máquinas, equipos y materiales utilizados:</b><br>{!!$plaza->equipoMateriales!!}</p>
              </div>
            <div style="page-break-after:always;"></div>
      @foreach($plaza->funciones->where('activo',1)->sortBy('literal')  as $funcion)
            @foreach($funcion->tareas->where('activo',1)->sortBy('numero')  as $tarea)
            
            <div id="info">
                   <main>
                      <center><p><b>ESTÁNDARES DE COMPETENCIA</b></p></center>
                      <table  style="width:100%;" border="0">
                        <tbody>
                          <tr>
                              <td><b>I. PUESTO:</b></td>
                              <td>{{$plaza->nombrePlaza}}</td>
                          </tr>
                           <tr>
                              <td><b>II. MISIÓN DEL PUESTO:</b></td>
                              <td>{{$plaza->mision}}</td>
                          </tr>
                          <tr>
                              <td><b>III. FUNCIÓN:</b></td>
                              <td>{{$funcion->literal}}. {{$funcion->nombreFuncion}}</td>
                          </tr>
                          <tr>
                              <td><b>IV. TAREA:</b></td>
                              <td>[{{$tarea->numero}} DE {{$loop->count}}]. {{$funcion->literal}} {{$tarea->numero}} {{$tarea->nombreTarea}}</td>
                          </tr>

                        </tbody>
                      </table>
                   </main>
              </div>

               <div id="evidencias">
                   <main>
                      <p>
                      <b>EVIDENCIAS</b><br/>
                       <b><u>Criterios de Desempeño</u></b><br>
                       La persona es competente cuando demuestra los siguientes <b>DESEMPEÑOS</b>:<br/>
                       @foreach($tarea->desempenios->where('activo',1) as $desemp)
                        {{ $loop->iteration }}.- {{$desemp->nombreDesempenio}}<br/>

                       @endforeach
                   </main>
              </div><br/>
              <div id="evidencias">
                   <main>
                       La persona es competente cuando obtiene los siguientes <b>PRODUCTOS</b>:<br/>
                       @foreach($tarea->productos->where('activo',1) as $pro)
                        {{ $loop->iteration }}.- {{$pro->nombreProducto}}<br/>

                       @endforeach
                   </main>
              </div><br/>
               <div id="evidencias">
               <main>
                       La persona es competente cuando posee los siguientes <b>CONOCIMIENTOS</b>:<br/>
                       <table border="0" style="width:700px;">
                        <tr><td></td><td><b>NIVEL</b></td></tr>
                       @foreach($tarea->conocimientos->where('activo',1) as $conoci)
                       <tr>
                        <td>{{ $loop->iteration }}.-  <?php echo mb_ucfirst(mb_strtolower($conoci->nombreConocimiento,'UTF-8'));; ?></td><td> {{$conoci->nivel->nombreNivel}}</td>
                      </tr>
                       @endforeach
                      </table>
                   </main>
              </div><br/>
              <div id="evidencias">
               <main>
                       La persona es competente cuando posee las siguientes <b>ACTITUDES / HÁBITOS / VALORES:</b><br/>
                       @foreach($tarea->actitudes->where('activo',1) as $actitud)
                        {{ $loop->iteration }}.- <?php echo mb_ucfirst(mb_strtolower($actitud->nombreActitud,'UTF-8')); ?><br/>
                       @endforeach
                      </table>
                   </main>
              </div>
              <div style="page-break-after:always;"></div>
             @endforeach
       @endforeach
    <footer id="footer">
    </footer>

  </body>

</html>