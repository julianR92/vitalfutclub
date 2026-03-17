<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Persona\Index as Persona;
use App\Http\Livewire\Plan\Index as Plan;
use App\Http\Livewire\Persona\Detalle;
use App\Http\Livewire\Sede\Sede;
use App\Http\Livewire\Persona\Historico;
use App\Http\Livewire\Ingreso\Ingreso;
use App\Http\Livewire\Ingreso\QrScanner;
use App\Http\Livewire\Empresa\Index as Empresa;
use Illuminate\Support\Facades\Mail;
use App\Mail\Notificaciones;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\PDF;
use App\Models\PerPLanes;
use App\Models\Empresa as Job;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


// use PDF;
use Illuminate\Support\Facades\Artisan;
use App\Http\Livewire\Reportes\Index as Reportes;

// Artisan::call('storage:link');

// ─── Dashboard (todos los roles autenticados) ─────────────────────────────────
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', fn() => view('dashboard'))->name('inicio');
    Route::get('/inicio', fn() => view('dashboard'));
});

// ─── Rutas exclusivas para CLIENTES ──────────────────────────────────────────
Route::middleware(['auth:sanctum', 'verified', 'role:cliente'])->group(function () {
    Route::get('/persona/historico', Historico::class)->name('persona.historico');
});

// ─── Rutas para ADMIN y PROFESOR ─────────────────────────────────────────────
Route::middleware(['auth:sanctum', 'verified', 'role:admin,profesor'])->group(function () {

    // Personas
    Route::get('/persona/index', Persona::class)->name('persona.index');
    Route::get('/persona/{persona}/detalle', Detalle::class)->name('persona.detalle');
    Route::get('/persona/getData', [App\Http\Controllers\PersonaController::class, 'getData']);

    // Ingreso
    Route::get('/ingreso/index', Ingreso::class)->name('ingreso.index');
    Route::get('/ingreso/scanner', QrScanner::class)->name('ingreso.scanner');

    // Reportes
    Route::get('/reportes/index', Reportes::class)->name('reportes.index');

    // ─── Módulo de Medidas Corporales ─────────────────────────────────────────
    Route::prefix('medidas')->name('medidas.')->group(function () {
        Route::get('/', [App\Http\Controllers\MedidaController::class, 'seleccionarPersonas'])->name('seleccionar');
        Route::post('/', [App\Http\Controllers\MedidaController::class, 'crearSesion'])->name('crear');
        Route::get('/historial', [App\Http\Controllers\MedidaController::class, 'index'])->name('historial');
        Route::get('/historial/getData', [App\Http\Controllers\MedidaController::class, 'getData'])->name('historial.getData');
        Route::get('/{sesion}/editar', [App\Http\Controllers\MedidaController::class, 'editar'])->name('editar');
        Route::get('/{sesion}/detalle', [App\Http\Controllers\MedidaController::class, 'show'])->name('show');
        Route::post('/{sesion}/finalizar', [App\Http\Controllers\MedidaController::class, 'finalizarSesion'])->name('finalizar');
        Route::delete('/{sesion}', [App\Http\Controllers\MedidaController::class, 'destroy'])->name('destroy');
        Route::patch('/{detalle}', [App\Http\Controllers\MedidaController::class, 'actualizarMedida'])->name('actualizar');
    });

    // ─── Torneos ──────────────────────────────────────────────────────────────
    Route::get('/torneo/getData', [App\Http\Controllers\TorneoController::class, 'getData'])->name('torneo.getData');
    Route::get('/torneos', [App\Http\Controllers\TorneoController::class, 'index'])->name('torneo.index');
    Route::get('/torneo/add', [App\Http\Controllers\TorneoController::class, 'addTorneo'])->name('torneo.add');
    Route::get('/jugadores/getData', [App\Http\Controllers\TorneoController::class, 'getDataClientes'])->name('torneo.getJugadores');
    Route::post('/torneo/store', [App\Http\Controllers\TorneoController::class, 'store'])->name('torneo.store');
    Route::get('/torneo/data/{id}', [App\Http\Controllers\TorneoController::class, 'torneoData'])->name('torneo.data');
    Route::get('/torneo/loadData/{id}', [App\Http\Controllers\TorneoController::class, 'loadDataActiveTorneo'])->name('torneo.loadData');
    Route::get('/jugador/delete/{id}', [App\Http\Controllers\TorneoController::class, 'jugadorDelete'])->name('jugador.delete');
    Route::get('/torneo/delete/{id}', [App\Http\Controllers\TorneoController::class, 'torneoDelete'])->name('torneo.delete');
    Route::post('/jugador/store', [App\Http\Controllers\TorneoController::class, 'storeJugador'])->name('jugador.store');

    // ─── Sorteos ──────────────────────────────────────────────────────────────
    Route::get('/sorteo', [App\Http\Controllers\SorteoController::class, 'index'])->name('sorteo.index');
    Route::get('/sorteo/getData', [App\Http\Controllers\SorteoController::class, 'getData'])->name('sorteo.getData');
    Route::post('/sorteo/store', [App\Http\Controllers\SorteoController::class, 'store'])->name('sorteo');
    Route::get('/sorteo/delete/{id}', [App\Http\Controllers\SorteoController::class, 'sorteoDelete'])->name('sorteo.delete');
    Route::get('/sorteo/data/{id}', [App\Http\Controllers\SorteoController::class, 'sorteoData'])->name('sorteo.data');
    Route::get('/sorteo/jugadores/getData/{id}', [App\Http\Controllers\SorteoController::class, 'getDataClientes'])->name('sorteo.getJugadores');
    Route::post('/sorteo/add/players', [App\Http\Controllers\SorteoController::class, 'addPlayers'])->name('sorteo.addPlayers');
    Route::get('/sorteo/jugadores/{id}', [App\Http\Controllers\SorteoController::class, 'getSorteoJugadores'])->name('sorteo.jugadores.incluidos');
    Route::get('/jugador/sorteo/delete/{id}', [App\Http\Controllers\SorteoController::class, 'jugadorDelete'])->name('jugador.sorteo.delete');
    Route::get('/finish/selection/{id}', [App\Http\Controllers\SorteoController::class, 'finishSelection'])->name('sorteo.finish.selection');
    Route::post('/sorteo/numero-equipos', [App\Http\Controllers\SorteoController::class, 'teamNumber'])->name('sorteo.teamNumber');
    Route::post('/sorteo/actualizar-clasificacion', [App\Http\Controllers\SorteoController::class, 'updateClasificacion'])->name('update.clasificacion');
    Route::get('/sorteo/validate/{id}', [App\Http\Controllers\SorteoController::class, 'validateClasificacion'])->name('sorteo.validar');
    Route::get('/sorteo/create/{id}', [App\Http\Controllers\SorteoController::class, 'createSorteo'])->name('sorteo.create');
    Route::post('/sorteo/finalizar', [App\Http\Controllers\SorteoController::class, 'endingSorteo'])->name('sorteo.finalizar');
    Route::post('/sorteo/descargar', [App\Http\Controllers\SorteoController::class, 'downloadSorteo'])->name('sorteo.descargar');
    Route::post('/sorteo/update/equipo', [App\Http\Controllers\SorteoController::class, 'updateTeam'])->name('sorteo.update.team');
    Route::post('/sorteo/descargar/final', [App\Http\Controllers\SorteoController::class, 'downloadSorteoFinal'])->name('sorteo.descargar.final');
});

// ─── Rutas exclusivas para ADMIN ─────────────────────────────────────────────
Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->group(function () {

    // Empresa
    Route::get('/empresa/index', Empresa::class)->name('empresa.index');

    // Ciudades
    Route::get('/ciudades/getData', [App\Http\Controllers\CiudadController::class, 'getData'])->name('ciudades.getData');
    Route::resource('ciudades', App\Http\Controllers\CiudadController::class)->parameters(['ciudades' => 'ciudad']);

    // Sedes
    Route::get('/sedes/getData', [App\Http\Controllers\SedeController::class, 'getData'])->name('sedes.getData');
    Route::resource('sedes', App\Http\Controllers\SedeController::class)->parameters(['sedes' => 'sede']);
    Route::get('/users/getSedes/{user_id}', [App\Http\Controllers\UserController::class, 'getSedes'])->name('get.sedes');
    Route::post('/sedes/users', [App\Http\Controllers\UserController::class, 'storeSedes'])->name('store.sedes');

    // Planes
    Route::get('/planes/getData', [App\Http\Controllers\PlanController::class, 'getData'])->name('planes.getData');
    Route::post('/planes/{plan}/detalles', [App\Http\Controllers\PlanController::class, 'storeDetalle'])->name('planes.detalles.store');
    Route::put('/planes/{plan}/detalles/{detalle}', [App\Http\Controllers\PlanController::class, 'updateDetalle'])->name('planes.detalles.update');
    Route::delete('/planes/{plan}/detalles/{detalle}', [App\Http\Controllers\PlanController::class, 'destroyDetalle'])->name('planes.detalles.destroy');
    Route::resource('planes', App\Http\Controllers\PlanController::class)->parameters(['planes' => 'plan']);

    // Tablero
    Route::get('/tablero', [App\Http\Controllers\TableroController::class, 'index'])->name('tablero.index');

    // Usuarios
    Route::get('/index/user', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/user/data', [App\Http\Controllers\UserController::class, 'getData'])->name('users.data');
    Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{persona_id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::get('/users/delete/{user_id}', [App\Http\Controllers\UserController::class, 'delete'])->name('delete.edit');

    // Congelación de planes
    Route::get('/congelacion-plan/index', [App\Http\Controllers\CongelacionPlanesController::class, 'index'])->name('congelacion.index');
    Route::post('/congelacion-plan', [App\Http\Controllers\CongelacionPlanesController::class, 'store'])->name('congelacion.store');

    // Utilidades (solo admin)
    Route::get('/clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        return 'Cleared!';
    });
});








