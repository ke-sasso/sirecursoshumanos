<?php

Route::group(['prefix' => 'solicitudes' , 'middleware' => ['auth' , 'verifypermissions']], function(){

			
	 Route::get('/seguros',[
		 		'as' => 'all.seguros',
				'permissions' => [458,498],
				'uses' => 'PermisosController@getSeguros'
		 	]);	
	   Route::post('/NoProcesar',[
		 		'as' => 'noprocesar.solicitud',
		 		'permissions' => [458,498],
				'uses' => 'PermisosController@procesarRrhh'
		 	]);
		 	

	 	Route::get('/licencias',[
			'as' => 'all.licencias',
			'permissions' => [458,498],
			'uses' => 'PermisosController@getLicencias'
	 	]);	

		Route::get('/dt-row-data-seguros',[
	 		'as' => 'dt.row.data.seguros',
			'permissions' => [458,498],
			'uses' => 'PermisosController@getDataRowsSeguros'
	 	]);

	 	Route::get('/dt-row-data-soli-dnm',[
	 		'as' => 'dt.row.data.permisos.dnm',
			'permissions' => [458,498],
			'uses' => 'PermisosController@getDataRowsLicencias'
	 	]);


	 	Route::get('/mostrarSeguro/{idSolSeguro}',[
			'as' => 'ver.seguro',
			'permissions' => [458,498],
			'uses' => 'PermisosController@mostrarSeguro'
	 	]);

	 	Route::get('/procesar/{idTipo}/{idSolicitud}',[
		 		'as' => 'procesar.solicitud.licencia',
		 		'permissions' => [458,498],
				'uses' => 'PermisosController@procesarLicencia'
		 	]);	

	 Route::get('/showLicencia/{idTipo}/{idSolicitud}',[
		 		'as' => 'ver.solicitud.Licencia',
		 		'permissions' => [458,498],
				'uses' => 'PermisosController@mostrarLicencia'
		 	]);
		
	  Route::post('/get-enfermedades',[
		 		'as' => 'get.enfermedades',
		 		'permissions' => [458,498],
				'uses' => 'PermisosController@getEnfermedades'
		 	]);

	   Route::get('/verDocumento/{urlDocumento}',[
		 		'as' => 'ver.documento',
		 		'permissions' => [458,498],
				'uses' => 'PermisosController@download'
		 	]);	
			


	Route::get('/todas/unidad',[
			'as' => 'all.permisos.unidad',
			'permissions' => [458,498],
			'uses' => 'PermisosController@getSolicitudesByUnidad'
	 	]);

		Route::get('/dt-row-data-soli-unidad',[
	 		'as' => 'dt.row.data.permisos.unidad',
			'permissions' => [458,498],
			'uses' => 'PermisosController@getDataRowsSolicitudesByUnidad'
	 	]);

	 		Route::post('/autorizacion',[
		 		'as' => 'autorizar.permiso',
		 		'permissions' => [458,498],
				'uses' => 'PermisosController@autorizacion'
		 	]);

		 	Route::post('/autorizacion/superior',[
		 		'as' => 'autorizar.superior',
		 		'permissions' => [458,498],
				'uses' => 'PermisosController@autorizacionSuperior'
		 	]);

		 	Route::get('/licencias/autorizar',[
			'as' => 'all.licencias.director',
			'permissions' => [458,498],
			'uses' => 'PermisosController@solicitudesLicenciaDirector'
	 	]);

		 	Route::get('/dt-row-data-licencia-aut',[
	 		'as' => 'dt.row.data.licencia.autorizar',
			'permissions' => [458,498],
			'uses' => 'PermisosController@getDataRowsLicenciaDirector'
	 	]);

		Route::post('/denegar',[
		 		'as' => 'denegar.solicitud',
		 		'permissions' => [458,498],
				'uses' => 'PermisosController@denegar'
		 	]);


});

