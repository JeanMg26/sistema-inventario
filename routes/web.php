<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
// Route::get('/', function () {
//    return view('welcome');
// });


Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/inicio', 'MainController@index')->name('inicio');

Route::group(['middleware' => ['auth']], function () {

   // Route::get('/', 'MainController@index');
   Route::resource('/', 'InicioController');
   Route::get('cruces-data-inicio', 'InicioController@datatables')->name('cruces.datainicio');
   Route::get('chart-line-ajax', 'InicioController@chartLineAjax');


   // ************************* ROLES ************************************
   Route::resource('roles', 'RoleController');
   Route::get('roles-data', 'RoleController@datatables')->name('roles.data');
   Route::get('roles/destroy/{id}', 'RoleController@destroy');
   // Cambiar estado
   Route::get('cambiar-estadorol', 'RoleController@cambiarEstadoRol')->name('cambiar.estadorol');
   // ************************ PERMISOS ***********************************
   Route::resource('permisos', 'PermisoController');
   Route::post('permisos/update', 'PermisoController@update')->name('permisos.update');
   Route::get('permisos-data', 'PermisoController@datatables')->name('permisos.data');
   Route::get('permisos/destroy/{id}', 'PermisoController@destroy');
   // Cambiar estado
   Route::get('cambiar-estadopermiso', 'PermisoController@cambiarEstadoPermiso')->name('cambiar.estadopermiso');
   // ************************** USUARIOS **************************************
   Route::resource('usuarios', 'UserController');
   Route::get('usuarios/destroy/{id}', 'UserController@destroy');
   Route::get('usuarios-data', 'UserController@datatables')->name('usuarios.data');
   // Cambiar estado
   Route::get('cambiar-estadousuario', 'UserController@cambiarEstadoUsuario')->name('cambiar.estadousuario');
   // Reset password
   Route::get('reset-password', 'UserController@resetPassword')->name('reset.password');
   // Editar Perfil Usuario - Modal
   Route::get('usuarios/{id}/editar_perfil', 'UserController@editarPerfilUsuario')->name('editar_perfil.usuario');
   Route::post('usuarios/actualizar_perfil', 'UserController@actualizarPerfilUsuario')->name('actualizar_perfil.usuario');



   // **************************** EQUIPOS **************************************
   Route::resource('equipos', 'EquipoController');
   Route::post('equipos/update', 'EquipoController@update')->name('equipos.update');
   Route::get('equipos/destroy/{id}', 'EquipoController@destroy');
   Route::get('equipos-data', 'EquipoController@datatables')->name('equipos.data');
   // Cambiar estado
   Route::get('cambiar-estadoequipo', 'EquipoController@cambiarEstadoEquipo')->name('cambiar.estadoequipo');
   // ****************************** EMPLEADOS **********************************
   Route::resource('empleados', 'EmpleadoController');
   Route::get('empleados/destroy/{id}', 'EmpleadoController@destroy');
   Route::get('empleados-data', 'EmpleadoController@datatables')->name('empleados.data');
   // Cambiar estado
   Route::get('cambiar-estadoempleado', 'EmpleadoController@cambiarEstadoEmpleado')->name('cambiar.estadoempleado');
   // ****************** LOCALES **********************************
   Route::resource('locales', 'LocalController');
   Route::post('locales/update', 'LocalController@update')->name('locales.update');
   Route::get('locales/destroy/{id}', 'LocalController@destroy');
   Route::get('locales-data', 'LocalController@datatables')->name('locales.data');
   // Cambiar estado
   Route::get('cambiar-estadolocal', 'LocalController@cambiarEstadoLocal')->name('cambiar.estadolocal');
   // ****************** AREAS **********************************
   Route::resource('areas', 'AreaController');
   Route::post('areas/update', 'AreaController@update')->name('areas.update');
   Route::get('areas/destroy/{id}', 'AreaController@destroy');
   Route::get('areas-data', 'AreaController@datatables')->name('areas.data');
   // Cambiar estado
   Route::get('cambiar-estadoarea', 'AreaController@cambiarEstadoArea')->name('cambiar.estadoarea');
   // ****************** OFICINAS **********************************
   Route::resource('oficinas', 'OficinaController');  
   Route::post('oficinas/update', 'OficinaController@update')->name('oficinas.update');
   Route::get('oficinas/destroy/{id}', 'OficinaController@destroy');
   Route::get('oficinas-data', 'OficinaController@datatables')->name('oficinas.data');
   // Rutas para obtener el area
   Route::get('/sareas.data', 'OficinaController@areas')->name('sareas.data');
   // Cambiar estado
   Route::get('cambiar-estadoficina', 'OficinaController@cambiarEstadOficina')->name('cambiar.estadoficina');
   // ****************** COORDINACIONES **********************************
   Route::resource('coordinaciones', 'CoordinacionController');
   Route::get('coordinaciones/destroy/{id}', 'CoordinacionController@destroy');
   Route::get('coordinaciones-data', 'CoordinacionController@datatables')->name('coordinaciones.data');
   // Cargar datos de otras tablas
   Route::get('/datosempleado', 'CoordinacionController@equipo_empleado')->name('datosempleado.data');
   Route::get('/coordinacion_areas.data', 'CoordinacionController@coordinacion_areas')->name('coordinacion_areas.data');
   Route::get('/coordinacion_oficinas.data', 'CoordinacionController@coordinacion_oficinas')->name('coordinacion_oficinas.data');
   // ****************** SUPERVISIONES **********************************
   Route::resource('supervisiones', 'SupervisionController');
   Route::post('supervisiones/update', 'SupervisionController@update')->name('supervisiones.update');
   Route::get('supervisiones/destroy/{id}', 'SupervisionController@destroy');
   Route::get('supervisiones-data', 'SupervisionController@datatables')->name('supervisiones.data');
   // *********** GRAFICOS CON GOOGLE CHARTS Y AJAX ******************
   Route::resource('graficos', 'GraficoController');
   Route::post('graficos-total', 'GraficoController@graficoTotal')->name('graficos.total');
   Route::post('graficos-equipos', 'GraficoController@graficoEquipos')->name('graficos.equipos');
   Route::post('graficos-equipos1', 'GraficoController@graficoEquipos1')->name('graficos.equipos1');
   // *********** BIENES - MUEBLES ******************
   Route::resource('bienes', 'BienController');
   Route::post('bienes/update', 'BienController@update')->name('bienes.update');
   Route::get('bienes-data', 'BienController@datatables')->name('bienes.data');
   Route::get('/cruce_areas.data', 'BienController@cruce_areas')->name('cruce_areas.data');
   Route::get('/cruce_oficinas.data', 'BienController@cruce_oficinas')->name('cruce_oficinas.data');
   // Exportar e Importar Bienes en Excel
   Route::get('bienes/excel/importar', 'BienController@excel')->name('bienes.excel');
   Route::post('bienes-excel-import', 'BienController@importExcel')->name('bienes.import.excel');
   // Vaciar Tabla Bienes para Importar
   Route::post('bienes-truncate', 'BienController@truncateBienes')->name('truncate.bienes');
   // *********** CRUCE DE BIENES - MUEBLES ******************
   Route::resource('cruces', 'CruceController');
   Route::get('cruces-data', 'CruceController@datatables')->name('cruces.data');
   // Cruzar Bien
   Route::get('cruzar-bien', 'CruceController@cruzarBien')->name('cruzar.bien');
   // *********** UBICACIONES PARA CAMPO ******************
   Route::resource('ubicaciones', 'UbicacionController');
   Route::get('ubicaciones-data', 'UbicacionController@datatables')->name('ubicaciones.data');
   // *********** CATALOGO ******************
   Route::resource('catalogo', 'CatalogoController');
   Route::get('catalogo-data', 'CatalogoController@datatables')->name('catalogo.data');

   // ********** RECARGAR SOLO LA FOTO Y NOMBRE DEL USUARIO AL EDITAR DESDE MODAL *************
   Route::get('/load_perfil', function () {
      return view('tema.load_perfil');
   });


   // Route::get('chart-line', 'ChartController@chartLine');
   // Route::resource('chart', 'ChartController');
   // Route::get('chart-line-ajax', 'ChartController@chartLineAjax');


});
