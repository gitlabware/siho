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
    return view('welcome');
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

