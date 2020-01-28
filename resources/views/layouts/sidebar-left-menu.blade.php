{{-- */
	$permisos = App\UserOptions::getAutUserOptions();
/*--}}
<!-- BEGIN SIDEBAR LEFT -->
<div class="sidebar-left sidebar-nicescroller {{ (Session::get('cfgHideMenu',false))?'toggle':'' }}">
	<ul class="sidebar-menu">
		<li class="{{ (Request::is('inicio') || Request::is('/')) ? 'active selected' : '' }}">
			<a href="{{ url('/inicio') }}"><i class="fa fa-dashboard icon-sidebar"></i>Inicio</a>
		</li>

    	<li>
		   	
		</li>

	   <li class="{{ Request::is('urh/empleados*') ? 'active selected' : '' }}">
	      <a href="#fakelink">
	        <i class="fa fa-user icon-sidebar"></i>
		    <i class="fa fa-angle-right chevron-icon-sidebar"></i>
	        Expediente laboral
	      </a>
	      <ul class="submenu {{ (Request::is('urh/empleados*')) ? 'visible' : '' }}">
			<li>
				<a href="{{ route('index.empleados') }}">Expediente</a>
			</li> 
		    <li>
				<a href="{{ route('index.nuevo.empleados') }}">Nuevo Empleado</a>
			</li>     				
	      </ul>
	    </li>

		<li class="{{ Request::is('evaluacion*') ? 'active selected' : '' }}">
	      <a href="#fakelink">
	        <i class="fa fa-pencil-square-o icon-sidebar" aria-hidden="true"></i> 
	        <i class="fa fa-angle-right chevron-icon-sidebar"></i>
	        Evaluaciones de desempeño
	      </a>
	      <ul class="submenu {{ (Request::is('evaluacion')) ? 'visible' : '' }}">
			<li>
			<a href="{{ route('evaluacion.listar') }}">Evaluaciones</a>
				
			</li>
			<li>
			<a href="{{ route('evaluacionPersonalTemp.listar') }}">Personal En Pruebas</a>
				
			</li>     				
	      </ul>

	     
	    </li>



	   
 
	    <li class="{{ Request::is('solicitudes*') ? 'active selected' : '' }}">
	      <a href="#fakelink">
	        <i class="fa fa-folder-open-o icon-sidebar"></i> 
	        <i class="fa fa-angle-right chevron-icon-sidebar"></i>
	        Solicitudes Administrativas
	      </a>
	      <ul class="submenu {{ (Request::is('solicitudes*')) ? 'visible' : '' }}">
			<li>
				<a href="{{ route('all.seguros') }}">Solicitudes de seguros</a>
			</li>   
			<li>
				<a href="{{route('all.licencias')}}">Solicitudes de Licencia Autorizadas</a>
			</li>    				
	      </ul>

	     
	    </li>


	    <li class="{{ Request::is('cat/unidad*') ? 'active selected' : '' }}">

	            
				<a href="#fakelink">
			        <i class="fa fa-info icon-sidebar"></i>
				    <i class="fa fa-angle-right chevron-icon-sidebar"></i>
			       Cat&aacute;logo Recursos Humanos
			     </a>  
                <ul class="submenu {{ (Request::is('cat/*')) ? 'visible' : '' }}">
				<li class="{{ (Request::is('cat/unidad*')) ? 'visible' : '' }}">
						<a href="{{ route('unidad.listar') }}">Unidades</a>
				</li>  
				<li>
						<a href="{{ route('tipoEst.listar') }}">Tipo de estudio</a>
				</li>  
				<li>
						<a href="{{ route('institucion.listar') }}">Instituciones Educativas</a>
				</li>
				<li>
						<a href="{{ route('parentesco.listar') }}">Parentesco</a>
				</li>   
				<li>
						<a href="{{ route('grupoSang.listar') }}">Grupo Sanguineo</a>
				</li> 
				<li>
						<a href="{{ route('motivos.listar') }}">Motivos de permisos</a>
				</li> 
				<li>
						<a href="{{ route('plazaFunc.listar') }}">Plazas Funcionales</a>
				</li> 
				<li>
						<a href="{{ route('plazaNom.listar') }}">Plazas Nominales</a>
				</li>
				<li>
						<a href="{{ route('perfiles.puesto') }}">Perfiles de plaza</a>
				</li>
				<li>
						<a href="{{ route('banco.listar') }}">Bancos</a>
				</li> 
				<li>
						<a href="{{ route('tipoActitud.listar') }}">Tipos de actitudes</a>
				</li>
				<li>
						<a href="{{ route('estadoLaboral.listar') }}">Estados Laborales</a>
				</li>
				<li>
						<a href="{{ route('clasificacionEmpleado.listar') }}">Clasificaciones de Empleados</a>
				</li> 

				</ul>

	    </li>
	    
	
	     <li class="{{ Request::is('training*') ? 'active selected' : '' }}">
			<a href="#fakelink">
				<i class="glyphicon glyphicon-pushpin icon-sidebar"></i>
				<i class="fa fa-angle-right chevron-icon-sidebar"></i>
				Plan de Capacitaciones
				</a>
				<ul class="submenu {{ Request::is('training*') ? 'visible' : '' }}">
					
					<li class="{{ Request::is('training/admin*') ? 'active selected' : '' }}">
						<a href="{{route('rh.capacitaciones.admin')}}">Administrador Capacitaciones</a>
					</li>

					<li class="{{ Request::is('training/plan*') ? 'active selected' : '' }}">
						<a href="{{route('rh.capacitaciones.plan')}}">Análisis resultados EDC</a>
					</li>
				</ul>
		</li>
		
	</ul>
</div><!-- /.sidebar-left -->
<!-- END SIDEBAR LEFT -->
