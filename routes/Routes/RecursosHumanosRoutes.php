<?php

Route::group(['prefix' => 'urh' , 'middleware' => ['auth' , 'verifypermissions']], function(){



             Route::get('/empleados',[
		 		'as' => 'index.empleados',
				'permissions' => [458,498],
				'uses' => 'RecursosHumanosController@index'
		 	]);	
            Route::get('/tablaEmpleados',[
		 		'as' => 'dt.row.data.empleados.urh',
				'permissions' => [458,498],
				'uses' => 'RecursosHumanosController@rowEmpleados'
		 	]);	
      Route::get('/verExpediente/{idEmpleado}',[
      'as' => 'ver.expediente.empleado',
      'permissions' => [458,498],
      'uses' => 'EmpleadosController@verExpedienteEmpleado'
    ]);
       Route::get('/verPdf/{urlDocumento}',[
      'as' => 'ver.pdfEstudio.empleado',
      'permissions' => [458,498],
      'uses' => 'EmpleadosController@downloadPdf'
    ]);

    

          
          Route::get('/getMarcaciones/{idEmpleado}',[
      			'as' => 'get.marcaciones',
      			'permissions' => [458,498],
    			'uses' => 'EmpleadosController@getMarcaciones'
   	 	]);	
          Route::get('/getPermisosEm/{idEmpleado}',[
      			'as' => 'get.permisos.empleado',
      			'permissions' => [458,498],
    			'uses' => 'RecursosHumanosController@getPermisos'
   	 	]);	

           Route::post('/getMunicipiosEmpleado',[
            'as' => 'get.listMunicipio.empleado',
            'permissions' => [458,498],
          'uses' => 'EmpleadosController@getComboboxMunicipiosAJAX'
      ]);


      Route::group(['prefix' => 'catEmpleado'], function(){
           
         Route::get('/nuevo',[
        'as' => 'index.nuevo.empleados',
        'permissions' => [458,498],
        'uses' => 'EmpleadosController@nuevoEmpleado'
         ]); 

          Route::post('/editarEmpleado/exp',[
          'as' => 'post.editar.empleado',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@editarEmpleado'
        ]); 

          Route::post('/guardarEmpleado/exp',[
          'as' => 'post.nuevo.empleado',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@storeEmpleado'
        ]); 

        Route::get('/contactosEmpleado/exp',[
          'as' => 'data.contactos.empleado',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@getContactosEmpleado'
        ]); 

        Route::get('/parentesco/exp',[
          'as' => 'data.parentesco.empleado',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@getParentescoEmpleado'
        ]);

         Route::post('/editarContacto/exp',[
          'as' => 'post.editar.contactoEmp',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@editarContactoEmp'
        ]); 


       Route::get('/infoEstudio/exp',[
          'as' => 'data.estudio.empleado',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@getInfoEstudio'
        ]); 
          Route::get('/tipoEstudio/exp',[
          'as' => 'data.tipoEstudio.empleado',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@getTipoEstudio'
        ]);
          
           Route::get('/instituciones/exp',[
          'as' => 'data.institucionEstudio.empleado',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@getInstitucionesEstudio'
        ]);
        Route::post('/editarEstudios/exp',[
          'as' => 'post.editar.estudiosEmp',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@editarEstudiosEmp'
        ]); 
       Route::post('/editarMedica/exp',[
          'as' => 'post.editar.infoMedica',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@editarMedicaEmp'
        ]); 

         Route::get('/infoSancion/exp',[
          'as' => 'data.sanciones.empleado',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@getInfoSanciones'
        ]); 
         Route::post('/editarSancion/exp',[
          'as' => 'post.editar.sancionEmp',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@editarSancionEmp'
        ]);
         Route::post('/eliminarSancion',[
             'as' => 'post.eliminar.sancion',
             'permissions' => [458,498],
             'uses' => 'EmpleadosController@deleteSancion'
         ]);
         Route::post('/nuevoContacto/exp',[
          'as' => 'post.nuevo.contactoEmp',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@nuevoContactoEmp'
        ]); 
    Route::get('/insti/exp',[
          'as' => 'data.institucionesBuscar.empleado',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@getInsti'
        ]); 
        Route::post('/nuevoEstudio/exp',[
          'as' => 'post.nuevo.estudioEmp',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@nuevoEstudioEmp'
        ]); 

          Route::post('/nuevaAmonestacion/exp',[
          'as' => 'post.nueva.sancionEmp',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@nuevaSancionEmp'
        ]); 

          Route::post('/borrarInfoLaboral/exp',[
          'as' => 'urh.infoLaboral.borrar',
          'permissions' => [498],
          'uses' => 'EmpleadosController@eliminarInfoLaboral'
        ]); 

          Route::post('/editarInfoLaboral/exp',[
          'as' => 'data.infoLaboral.editar',
          'permissions' => [498],
          'uses' => 'EmpleadosController@editarInfoLaboral'
        ]); 

          Route::get('/getInfoLaboral/exp',[
          'as' => 'data.infoLaboral.getData',
          'permissions' => [498],
          'uses' => 'EmpleadosController@getInfoLaboral'
        ]); 

          Route::post('/nuevaInfoLaboral/exp',[
          'as' => 'post.nueva.infolaboral',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@nuevaInfoLaboral'
        ]); 

           Route::post('/nuevaInfoMedica/exp',[
          'as' => 'post.nueva.infoMedica',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@nuevaInfoMedica'
        ]); 

               Route::post('/eliminarContacto/exp',[
          'as' => 'urh.infoContacto.borrar',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@destroyContacto'
        ]); 
     Route::post('/eliminarEstudio/exp',[
          'as' => 'urh.infoEstudios.borrar',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@destroyEstudio'
        ]); 

        Route::post('/nuevoDocumento/exp',[
          'as' => 'post.nuevo.documeno',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@storeDocumentoExp'
        ]); 
          Route::post('/eliminarDocumentoPersonal/exp',[
          'as' => 'urh.documentopersonal.borrar',
          'permissions' => [458,498],
          'uses' => 'EmpleadosController@destroyDocumentoPersonal'
        ]); 

      
      });


});
