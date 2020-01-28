<?php
Route::group(['prefix' => 'training', 'middleware' => ['auth' , 'verifypermissions']], function() {

	Route::get('/admin',[
		'as' => 'rh.capacitaciones.admin',
		'permissions' => [458,498], 
		'uses' => 'CapacitacionesController@show']);

	Route::get('/getEvaluaciones', [
		'as' => 'edc.evaluaciones.rh',
		'permissions' => [458,498],
		'uses' => 'CapacitacionesController@getEvaluaciones']);

	Route::post('/nuevaCapacitacion', [
		'as' => 'new.capacitaciones.rh',
		'permissions' => [458,498],
		'uses'=>'CapacitacionesController@crearNueva']);

	Route::get('/listCapacitaciones',
		[
		'as' => 'list.capacitaciones.rh',
		'permissions' => [458,498],
		'uses'=>'CapacitacionesController@listCapacitaciones']);

	Route::get('/detalleCapacitacion/{id}', [
		'as' => 'det.capacitaciones.rh',
		'permissions' => [458,498],
		'uses' => 'CapacitacionesController@getDetalleCapacitacion']);

	Route::get('/vwDetalleCapacitacion/{id}', [
		'as' => 'vw.capacitaciones.rh',
		'permissions' => [458,498],
		'uses' => 'CapacitacionesController@vwDetalleCapacitacion']);
});



//---------------------------------------ANALISIS DE RESULTADO-------------------------------
Route::group(['prefix' => 'training/plan', 'middleware' => ['auth' , 'verifypermissions']], function() {

	/*
	 *		INDEX
	 */

	Route::get('/',[
		'as' => 'rh.capacitaciones.plan',
		'permissions' => [458,498], 
		'uses' => 'CapacitacionesController@index']);
	
	/*
	 *		RUTAS PARA DESEMPEÑOS
	 */
    
    Route::group(['prefix' => 'desempenios'], function(){
    	Route::get('/',[
			'as' => 'rh.capacitaciones.desempenios',
			'permissions' => [458,498],
			'uses' => 'ResultadoEvaluacionesController@indexDesemp']);

		Route::get('/dt-row-data',[
			'as' => 'dt.row.data.rh.capacitaciones.desempenios',
			'permissions' => [458,498],
			'uses' => 'ResultadoEvaluacionesController@getDataRowsDesemp']);	

		Route::get('export/excel',[
			'as' => 'rh.capacitaciones.desempenios.expExcel',
			'permissions' => [458,498],
			'uses' => 'ResultadoEvaluacionesController@exportToExcelDesemp']);
    });

    /*
	 *		RUTAS PARA PRODUCTOS
	 */

	Route::group(['prefix' => 'productos'], function(){
		Route::get('/',[
			'as' => 'rh.capacitaciones.productos',
			'permissions' => [458,498], 
			'uses' => 'ResultadoEvaluacionesController@indexProductos']);

		Route::get('/dt-row-data',[
			'as' => 'dt.row.data.rh.capacitaciones.productos',
			'permissions' => [458,498],
			'uses' => 'ResultadoEvaluacionesController@getDataRowsProductos']);

		Route::get('export/excel',[
			'as' => 'rh.capacitaciones.productos.expExcel',
			'permissions' => [458,498],
			'uses' => 'ResultadoEvaluacionesController@exportToExcelProductos']);
	});

	/*
	 *		RUTAS PARA CONOCIMIENTOS
	 */

	Route::group(['prefix' => 'conocimientos'], function(){
		Route::get('/',[
			'as' => 'rh.capacitaciones.conocimientos',
			'permissions' => [458,498], 
			'uses' => 'ResultadoEvaluacionesController@indexConocimientos']);

		Route::get('/dt-row-data',[
			'as' => 'dt.row.data.rh.capacitaciones.conocimientos',
			'permissions' => [458,498],
			'uses' => 'ResultadoEvaluacionesController@getDataRowsConocimientos']);

		Route::get('export/excel',[
			'as' => 'rh.capacitaciones.conocimientos.expExcel',
			'permissions' => [458,498],
			'uses' => 'ResultadoEvaluacionesController@exportToExcelConocimientos']);
	});

	/*
	 *		RUTAS PARA CONOCIMIENTOS
	 */

	Route::group(['prefix' => 'actitudes'], function(){
		Route::get('/',[
			'as' => 'rh.capacitaciones.actitudes',
			'permissions' => [458,498], 
			'uses' => 'ResultadoEvaluacionesController@indexActitudes']);

		Route::get('/dt-row-data',[
			'as' => 'dt.row.data.rh.capacitaciones.actitudes',
			'permissions' => [458,498],
			'uses' => 'ResultadoEvaluacionesController@getDataRowsActitudes']);

		Route::get('export/excel',[
			'as' => 'rh.capacitaciones.actitudes.expExcel',
			'permissions' => [458,498],
			'uses' => 'ResultadoEvaluacionesController@exportToExcelActitudes']);
	});

	/*
	 *		RUTAS PARA GUARDAR DETALLES SELECCIONADOS
	 */

	Route::group(['prefix' => 'items'], function(){
		Route::post('/guardar',[
			'as' => 'rh.capacitaciones.items.guardar',
			'permissions' => [458,498], 
			'uses' => 'CapacitacionesController@addDetCapacitaciones']);
	});
});






 ?>
