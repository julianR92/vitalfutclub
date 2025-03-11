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

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
	return view('dashboard');
})->name('inicio');

Route::middleware(['auth:sanctum', 'verified'])->get('/inicio', function () {
	return view('dashboard');
})->name('inicio');

Route::middleware(['auth:sanctum', 'verified'])
	->get('/persona/index', Persona::class)
	->name('persona.index')
	->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
	->get('/persona/historico', Historico::class)
	->name('persona.historico')
	->middleware(['auth:sanctum', 'verified']);


Route::middleware(['auth:sanctum', 'verified'])
	->get('/persona/{persona}/detalle', Detalle::class)
	->name('persona.detalle')
	->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
	->get('/plan/index', Plan::class)
	->name('plan.index')
	->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
	->get('/sedes/index', Sede::class)
	->name('sedes.index')
	->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
	->get('/empresa/index', Empresa::class)
	->name('empresa.index')
	->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
	->get('/ingreso/index', Ingreso::class)
	->name('ingreso.index')
	->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
	->get('/ingreso/scanner', QrScanner::class)
	->name('ingreso.scanner')
	->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
	->get('/reportes/index', Reportes::class)
	->name('reportes.index')
	->middleware(['auth:sanctum', 'verified']);


Route::get('/persona/getData', [App\Http\Controllers\PersonaController::class, 'getData'])->middleware(['auth:sanctum', 'verified']);
Route::get('/index/user', [App\Http\Controllers\UserController::class, 'index'])->middleware(['auth:sanctum', 'verified'])->name('users.index');
Route::get('/user/data', [App\Http\Controllers\UserController::class, 'getData'])->middleware(['auth:sanctum', 'verified'])->name('users.data');
Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->middleware(['auth:sanctum', 'verified'])->name('users.store');
Route::get('/users/edit/{persona_id}', [App\Http\Controllers\UserController::class, 'edit'])->middleware(['auth:sanctum', 'verified'])->name('users.edit');
Route::get('/users/delete/{user_id}', [App\Http\Controllers\UserController::class, 'delete'])->middleware(['auth:sanctum', 'verified'])->name('delete.edit');
Route::get('/users/getSedes/{user_id}', [App\Http\Controllers\UserController::class, 'getSedes'])->middleware(['auth:sanctum', 'verified'])->name('get.sedes');
Route::post('/sedes/users', [App\Http\Controllers\UserController::class, 'storeSedes'])->middleware(['auth:sanctum', 'verified'])->name('store.sedes');

//torneo
// cambios JR
// 2024-10-28
Route::get('/torneo/getData', [App\Http\Controllers\TorneoController::class, 'getData'])->middleware(['auth:sanctum', 'verified'])->name('torneo.getData');
Route::get('/torneos', [App\Http\Controllers\TorneoController::class, 'index'])->middleware(['auth:sanctum', 'verified'])->name('torneo.index');
Route::get('/torneo/add', [App\Http\Controllers\TorneoController::class, 'addTorneo'])->middleware(['auth:sanctum', 'verified'])->name('torneo.add');
Route::get('/jugadores/getData', [App\Http\Controllers\TorneoController::class, 'getDataClientes'])->middleware(['auth:sanctum', 'verified'])->name('torneo.getJugadores');
Route::post('/torneo/store', [App\Http\Controllers\TorneoController::class, 'store'])->middleware(['auth:sanctum', 'verified'])->name('users.store');
Route::get('/torneo/data/{id}', [App\Http\Controllers\TorneoController::class, 'torneoData'])->middleware(['auth:sanctum', 'verified'])->name('torneo.data');
Route::get('/torneo/loadData/{id}', [App\Http\Controllers\TorneoController::class, 'loadDataActiveTorneo'])->middleware(['auth:sanctum', 'verified'])->name('torneo.loadData');
Route::get('/jugador/delete/{id}', [App\Http\Controllers\TorneoController::class, 'jugadorDelete'])->middleware(['auth:sanctum', 'verified'])->name('jugador.delete');
Route::get('/torneo/delete/{id}', [App\Http\Controllers\TorneoController::class, 'torneoDelete'])->middleware(['auth:sanctum', 'verified'])->name('torneo.delete');
Route::post('/jugador/store', [App\Http\Controllers\TorneoController::class, 'storeJugador'])->middleware(['auth:sanctum', 'verified'])->name('users.store');

//Congelacion planes
//Fabian h
Route::get('/congelacion-plan/index', [App\Http\Controllers\CongelacionPlanesController::class, 'index'])->middleware(['auth:sanctum', 'verified'])->name('congelacion.index');
Route::post('/congelacion-plan', [App\Http\Controllers\CongelacionPlanesController::class, 'store'])->middleware(['auth:sanctum', 'verified'])->name('congelacion.store');

// Route::get('/pruebas', function (){
//       $id = 1343;
//         //generate pdf
//         $empresa = Job::all();
//         $plan_activo = PerPlanes::join('planes', 'planes.id', '=', 'per_planes.plan_id')->join('personas', 'personas.id', '=', 'per_planes.persona_id')
//         ->where('per_planes.persona_id', 6)->where('per_planes.estado', 1)->get();       
//         $hoy = date("Y-m-d");	
//     $pdf = app('dompdf.wrapper');
//     $pdf->loadView('factura.factura',compact('empresa','plan_activo', 'hoy', 'id'));
//     return $pdf->stream();
// });

// Route::get('/pruebasqr', function (){
//       $png = QrCode::format('png')->size(512)->generate(1);
//         $png = base64_encode($png);
//         echo "<img src='data:image/png;base64," . $png . "'>";

// });

Route::get('/clear', function () {
	//Artisan::call('storage:link');
	Artisan::call('cache:clear');
	Artisan::call('config:cache');
	Artisan::call('view:clear');
	return "Cleared!";
	//return  $_SERVER["REMOTE_ADDR"];
});
