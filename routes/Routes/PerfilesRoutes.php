<?php
Route::group(['prefix' => 'perfiles', 'middleware' => ['auth' , 'verifypermissions']], function() {
	Route::get('/plaza',[
		'as' => 'perfiles.puesto',
		'permissions' => [458,498], 
		'uses' => 'PerfilesController@showPerfilesPuesto']);

	Route::get('/getEmpleadosPP',[
		'as' => 'dt.empleados.perfilesp',
		'permissions' => [458,498], 
		'uses' => 'PerfilesController@getDataRowsPerfilesP']);

	Route::get('/mostrar/emp/{idEmp}',[
		'as' => 'perfiles.puesto.emp',
		'permissions' => [458,498], 
		'uses' => 'PerfilesController@showEmpPerfilPuesto']);

	Route::get('/mostrar/emptar/{idEmp}/{idTar}',[
		'as' => 'perfiles.puesto.emp.showTar',
		'permissions' => [458,498], 
		'uses' => 'PerfilesController@mostrarTarea']);
});

?>