<?php
use Illuminate\Support\Facades\Auth;
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

/*Route::get('/', function () {
    //return view('welcome');
    return view('auth.login');
});*/

Route::get('/', 'UserController@direcciona');

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
Route::get('pisosHotel/{idHotel}', 'PisosController@pisosHotel')->name('pisosHotel');
Route::get('piso/{idHotel}/{idPiso?}', 'PisosController@piso')->name('piso');
Route::get('pisos/{idHotel}', 'PisosController@pisos')->name('pisos');
Route::post('guarda_piso/{idPiso?}', 'PisosController@guarda_piso')->name('guarda_piso');
Route::get('nuevaHabitacion/{idHotel}', 'HabitacionesController@nuevahabitacion');
Route::get('ingresaPrecio/{idHabitacion}', 'PrecioshabitacionesController@ingresaPrecio');
Route::get('asignahabitacion', 'ClientesController@asignahabitacion');
Route::get('asignahabitacion2/{tipo}/{idCliente}/{num_reg?}', 'ClientesController@asignahabitacion2')->name('asignahabitacion2');
/*Route::controller('datatables', 'PisosController', [
    'anyData'  => 'datatables.data',
    'muestraPisos' => 'datatables',
]);*/

Route::resource('clientes', 'ClientesController');
Route::controller('datatables', 'ClientesController', [
    'anyData'  => 'datatables.data',
    'getIndex' => 'datatables',
]);


Route::resource('pisos', 'PisosController');

Route::resource('precioshabitaciones', 'PrecioshabitacionesController');

Route::resource('estudiantes', 'EstudiantesController');

//`Route::auth();

Route::resource('cajas', 'CajaController');

Route::resource('flujos', 'FlujoController');

Route::get('caja/flujos/{idCaja}', 'CajaController@flujos')->name('flujos');

Route::get('caja/ingreso/{idCaja}', 'CajaController@ingreso');
Route::post('caja/guarda_ingreso', 'CajaController@guarda_ingreso');

Route::get('caja/egreso/{idCaja}', 'CajaController@egreso');
Route::post('caja/guarda_egreso', 'CajaController@guarda_egreso');
Route::post('caja/eliminar_flujo/{idFlujo}', 'CajaController@eliminar_flujo');

Route::get('caja/eliminaflujo/{idFlujo}', 'CajaController@eliminaflujo')->name('eliminaflujo');

Route::resource('registros', 'RegistroController');
Route::get('registros/nuevo/{tipo}/{idCliGru}/{idHabitacion}/{idRegistro?}', 'RegistroController@nuevo')->name('nuevoregistro');
Route::get('registros_calendario', 'RegistroController@calendario')->name('calendario');
Route::post('registros/guarda_registro/{idRegistro?}', 'RegistroController@guarda_registro')->name('guarda_registro');
//Route::post('registros/nuevos/{idCliente}/{num_reg?}', 'RegistroController@nuevos')->name('nuevos');
Route::post('registros/guarda_registros/{num_reg?}', 'RegistroController@guarda_registros')->name('guarda_registros');
Route::get('registros_cliente/{idCliente}', 'RegistroController@registros_cliente')->name('registros_cliente');
Route::post('registrar_pago', 'RegistroController@registrar_pago')->name('registrar_pago');


Route::match(['get', 'post'], 'registros/nuevos/{idCliente}/{num_reg?}', 'RegistroController@nuevos')->name('nuevos');

Route::get('get_num_reg', 'RegistroController@get_num_reg');


Route::get('usuarios/', 'UserController@index')->name('usuarios');
Route::get('usuarios/usuario/{idUsuario?}', 'UserController@usuario')->name('usuario');
Route::post('usuarios/guarda_usuario/{idUsuario?}', 'UserController@guarda_usuario')->name('guarda_usuario');
Route::get('usuarios/eliminar/{idUsuario}', 'UserController@eliminar')->name('eliminar');


Route::get('vhabitaciones', 'HabitacionesController@vhabitaciones')->name('vhabitaciones');
Route::get('informacion_habitacion/{idHabitacion}', 'HabitacionesController@informacion_habitacion')->name('informacion_habitacion');


Route::resource('categorias', 'CategoriaController');

Route::resource('facturas', 'FacturaController');

Route::get('facturar/{idFlujo}', 'FacturaController@facturar')->name('facturar');
Route::post('generar_factura', 'FacturaController@generar_factura')->name('generar_factura');
Route::get('factura/{idFactura}', 'FacturaController@factura')->name('factura');

//Route::get('reporte_pagos', 'ReporteController@reporte_pagos')->name('reporte_pagos');

Route::match(['get', 'post'], 'reporte_pagos', 'ReporteController@reporte_pagos')->name('reporte_pagos');
Route::match(['get', 'post'], 'repo_pago_regis', 'ReporteController@repo_pago_regis')->name('repo_pago_regis');

Route::get('cliente/{idCliente?}', 'ClientesController@cliente')->name('cliente');
Route::post('guarda_cliente/{idCliente?}', 'ClientesController@guarda_cliente')->name('guarda_cliente');
Route::get('elimina_adjunto/{idAdjunto}', 'ClientesController@elimina_adjunto')->name('elimina_adjunto');

Route::get('quitarhuesped/{idHospedante}', 'RegistroController@quitarhuesped')->name('quitarhuesped');

Route::get('msalidahuesped/{idHospedante}', 'RegistroController@msalidahuesped')->name('msalidahuesped');

Route::get('grupos', 'GrupoController@index')->name('grupos');
Route::get('registrosgrupos/{idGrupo}', 'GrupoController@registrosgrupos')->name('registrosgrupos');
Route::get('grupo/{idGrupo?}', 'GrupoController@grupo')->name('grupo');
Route::get('eliminargrupo/{idGrupo}', 'GrupoController@eliminargrupo')->name('eliminargrupo');
Route::post('registrapagosg', 'GrupoController@registrapagosg')->name('registrapagosg');


Route::get('marcasalida/{idRegistro}', 'GrupoController@marcasalida')->name('marcasalida');
Route::get('cancelaregistro/{idRegistro}', 'GrupoController@cancelaregistro')->name('cancelaregistro');
Route::get('generadeudasgrupos/{idGrupo}', 'GrupoController@generadeudasgrupos')->name('generadeudasgrupos');

Route::get('grupo/{idGrupo}', 'GrupoController@grupo')->name('grupo');
Route::post('guarda_grupo/{idGrupo}', 'GrupoController@guarda_grupo')->name('guarda_grupo');
Route::get('addpagoextra/{idRegistro}', 'GrupoController@addpagoextra')->name('addpagoextra');
Route::post('guarda_pagoextra', 'GrupoController@guarda_pagoextra')->name('guarda_pagoextra');

Route::match(['get', 'post'], 'pasajeros_reporte', 'ReporteController@pasajeros_reporte')->name('pasajeros_reporte');
Route::match(['get', 'post'], 'reporte_registros', 'ReporteController@reporte_registros')->name('reporte_registros');

Route::resource('actividads', 'ActividadController');
Route::get('actividad/{idCliente}/{idActividad?}', 'ActividadController@actividad')->name('actividad');
Route::post('guarda_actividad/{idActividad?}', 'ActividadController@guarda_actividad')->name('guarda_actividad');
Route::get('grupos/eliminapago/{idPago}', 'GrupoController@eliminapago')->name('eliminapago');
Route::post('grupos/eliminar_pago/{idPago}', 'GrupoController@eliminar_pago');
Route::get('crono_genera_pagos', 'GrupoController@crono_genera_pagos');

Route::post('opcioneshab', 'PisosController@opcioneshab')->name('opcioneshab');