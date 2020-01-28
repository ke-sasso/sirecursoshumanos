<?php
/*
	This method include all Routes archives from Routes Directory
	By Kevin Alvarez
*/
foreach (new DirectoryIterator(__DIR__.'/Routes') as $file)
{
    if (!$file->isDot() && !$file->isDir() && $file->getFilename() != '.gitignore')
    {
        require_once __DIR__.'/Routes/'.$file->getFilename();
        //require_once __DIR__.'/Routes/'.$file->getFilename();
    }
}


Route::get('/', ['as' => 'doLogin', 'uses' => 'CustomAuthController@getLogin']);
Route::post('/login', ['as' => 'login', 'uses' =>'CustomAuthController@postLogin']); 
Route::get('/login', ['uses'=>'InicioController@index']); 
Route::get('/logout', 'CustomAuthController@getLogout'); 
Route::get('cfg/menu', 'InicioController@cfgHideMenu');

Route::group(['middleware' => ['auth' , 'verifypermissions'],
	'permissions' => [458]], function() {

	Route::get('/inicio',[
	'as' => 'doInicio', 
	'uses' => 'InicioController@index']);    


});


//MOSTRAR LAS SOLICITUDES DEL SEGURO

/*Route::get('/seguros',[
			'as' => 'seguros',
			'permissions' => [454],
			'uses' => 'SeguroController@getSeguros'
	 	]);	*/

	 	/*Route::get('/todas',[
		 		'as' => 'all.seguros',
				'permissions' => [458],
				'uses' => 'SeguroController@getSeguros'
		 	]);	

		Route::get('/dt-row-data-seguros',[
	 		'as' => 'dt.row.data.seguros',
			'permissions' => [458],
			'uses' => 'SeguroController@getDataRowsSeguros'
	 	]);
		 	
*/





   
