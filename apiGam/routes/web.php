<?php

use App\Http\Controllers\CitaUsuariosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExperienciasController;
use App\Http\Controllers\LocalidadesController;
use App\Http\Controllers\TipoDeExperienciasController;
use App\Http\Controllers\UsuariossController;
use App\Http\Middleware\CorsMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
///////////////////////////////////////////////////////////////////////////////////////////////
//////////  R E L A T I V A S   A L   C O N T R O L A D O R   E X P E R I E N C I A S /////////
///////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/todas-las-experiencias-filtro', [ExperienciasController::class, 'todasLasExperienciasFiltradas'])->middleware(CorsMiddleware::class);
Route::get('/cambiar-estado-inactivo', [ExperienciasController::class, 'cambiarEstadoExperiencia'])->middleware(CorsMiddleware::class);
Route::post('/insertar-experiencia', [ExperienciasController::class, 'insertarExperiencia'])->middleware(CorsMiddleware::class);
Route::get('/consultar-experiencia', [ExperienciasController::class, 'consultarExperiencia'])->middleware(CorsMiddleware::class);

/////////////////////////////////////////////////////////////////////////////////////////////
//////////  R E L A T I V A S   A L   C O N T R O L A D O R   L O C A L I D A D E S /////////
/////////////////////////////////////////////////////////////////////////////////////////////

Route::post('/insertar-localidad', [LocalidadesController::class, 'insertarLocalidad'])->middleware(CorsMiddleware::class);
Route::get('/consultar-localidades', [LocalidadesController::class, 'consultarLocalidades'])->middleware(CorsMiddleware::class);

/////////////////////////////////////////////////////////////////////////////////////////////
////  R E L A T I V A S   A L   C O N T R O L A D O R   T I P O  E X P E R I E N C I A //////
/////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/consultar-tipos-experiencias', [TipoDeExperienciasController::class, 'consultarTiposExperiencias'])->middleware(CorsMiddleware::class);

/////////////////////////////////////////////////////////////////////////////////////////////
////////////  R E L A T I V A S   A L   C O N T R O L A D O R   U S U A R I O S /////////////
/////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/consultar-credenciales-usuario', [UsuariossController::class, 'consultarUsuario'])->middleware(CorsMiddleware::class);
Route::get('/consultar-usuario', [UsuariossController::class, 'consultarUsuarioPorDni'])->middleware(CorsMiddleware::class);
Route::post('/crear-usuario', [UsuariossController::class, 'crearUsuario'])->middleware(CorsMiddleware::class);

/////////////////////////////////////////////////////////////////////////////////////////////
//////  R E L A T I V A S   A L   C O N T R O L A D O R   c I T A S   U S U A R I O S ///////
/////////////////////////////////////////////////////////////////////////////////////////////

Route::post('/crear-cita', [CitaUsuariosController::class, 'crearCita'])->middleware(CorsMiddleware::class);

/////////////////////////////////////////////////////////////////////////////////////////////