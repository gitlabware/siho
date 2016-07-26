<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    //return view('welcome');
    return view('auth.login');
});


/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api', 'namespace' => 'API'], function () {
    Route::group(['prefix' => 'v1'], function () {
        require config('infyom.laravel_generator.path.api_routes');
    });
});


Route::resource('hotels', 'HotelController');

Route::resource('posts', 'PostController');

Route::resource('habitaciones', 'HabitacionesController');

Route::get('muestraHabitaciones/{idHotel}', 'HotelController@muestraHabitaciones');
//Route::get('muestraPisos/{idHotel}', 'PisosController@muestraPisos');
Route::get('pisosHotel/{idHotel}', 'PisosController@pisosHotel');
Route::get('nuevaHabitacion/{idHotel}', 'HabitacionesController@nuevahabitacion');
Route::get('ingresaPrecio/{idHabitacion}', 'PrecioshabitacionesController@ingresaPrecio');
Route::get('asignahabitacion', 'ClientesController@asignahabitacion');
Route::get('asignahabitacion2/{idCliente}', 'ClientesController@asignahabitacion2')->name('asignahabitacion2');
/*Route::controller('datatables', 'PisosController', [
    'anyData'  => 'datatables.data',
    'muestraPisos' => 'datatables',
]);*/

Route::resource('clientes', 'ClientesController');

Route::resource('pisos', 'PisosController');

Route::resource('precioshabitaciones', 'PrecioshabitacionesController');

Route::resource('estudiantes', 'EstudiantesController');

//`Route::auth();

Route::resource('cajas', 'CajaController');

Route::resource('flujos', 'FlujoController');

Route::get('caja/flujos/{idCaja}', 'CajaController@flujos');

Route::get('caja/ingreso/{idCaja}', 'CajaController@ingreso');

Route::post('caja/guarda_ingreso', 'CajaController@guarda_ingreso');

Route::resource('registros', 'RegistroController');
Route::get('registros/nuevo/{idCliente}/{idHabitacion}/{idRegistro?}', 'RegistroController@nuevo')->name('nuevoregistro');
Route::post('registros/guarda_registro/{idRegistro?}', 'RegistroController@guarda_registro')->name('guarda_registro');

Route::get('usuarios/', 'UserController@index')->name('usuarios');
Route::get('usuarios/usuario/{idUsuario?}', 'UserController@usuario')->name('usuario');
Route::post('usuarios/guarda_usuario/{idUsuario?}', 'UserController@guarda_usuario')->name('guarda_usuario');
Route::get('usuarios/eliminar/{idUsuario}', 'UserController@eliminar')->name('eliminar');

