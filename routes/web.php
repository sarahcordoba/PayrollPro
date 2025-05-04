<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\DeduccionController;
use App\Http\Controllers\ComisionController;
use App\Http\Controllers\ComisionNominaController;
use App\Http\Controllers\DeduccionNominaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LiquidacionController;
use App\Models\Comision;
use App\Models\ComisionNomina;
use App\Models\DeduccionNomina;

//Route::get('/', [HomeController::class, 'index']);

Route::resource('departamentos', DepartamentoController::class);
Route::resource('empleados', EmpleadoController::class);
Route::resource('nominas', NominaController::class);
Route::resource('deducciones', DeduccionController::class);
Route::resource('bonificaciones', ComisionController::class);
Route::resource('liquidaciones', LiquidacionController::class);
//Route::resource('comisionnomina', ComisionNominaController::class);
//Route::resource('deduccionnomina', DeduccionNominaController::class);
//Route::get('/liquidaciones/{id}', [LiquidacionController::class, 'show'])->name('liquidaciones.show');
//Route::get('/nominas/{id}', [NominaController::class, 'show'])->name('nominas.show');

use App\Models\Nomina;

// Route::get('edit/nominas/{id}', function ($id) {
//     $nomina = Nomina::findOrFail($id);
//     return view('nominas.edit', compact('nomina'));
// })->name('nominas.edit');

Route::get('/edit/nominas/{id}', [NominaController::class, 'edit'])->name('nominas.edit');
Route::get('/liquidar/nominas/{id}', [NominaController::class, 'liquidar'])->name('nominas.liquidar');



Route::post('api/add/deducciones', [DeduccionController::class, 'store']);
Route::post('api/add/deduccionesnomina', [DeduccionNominaController::class, 'store']);

Route::post('api/add/comisiones', [ComisionController::class, 'store']);
Route::post('api/add/comisionesnomina', [ComisionNominaController::class, 'store']);

Route::delete('api/delete/liquidacion/{id}', [LiquidacionController::class, 'destroy']);
Route::delete('api/delete/deduccionnomina/{nomina_id}/{deduccion_id}', [DeduccionNominaController::class, 'destroy'])->name('deduccionnomina.delete');
Route::delete('api/delete/comisionnomina/{nomina_id}/{comision_id}', [ComisionNominaController::class, 'destroy'])->name('comisionnomina.delete');
Route::put('api/update/comisionnomina/{nomina_id}/{comision_id}', [ComisionNominaController::class, 'update'])->name('comisionnomina.update');
Route::put('api/update/deduccionnomina/{nomina_id}/{deduccion_id}', [DeduccionNominaController::class, 'update'])->name('comisionnomina.update');


Route::post('api/add/liquidacion', [LiquidacionController::class, 'store']);
Route::get('api/getall/liquidaciones', [LiquidacionController::class, 'getLiquidaciones']);
Route::post('api/add/nomina', [NominaController::class, 'store']);



// Route for root URL
Route::get('/', function () {
    return view('dashboard'); // Serve the dashboard view
})->name('home'); // Optional name for the route

// Route for /dashboard
Route::get('/dashboard', function () {
    return view('dashboard'); // Serve the same dashboard view
})->name('dashboard'); // Name it "dashboard"

// Route::get('/dashboardb', function () {
//     return view('dashboardb');
// })->middleware(['auth', 'verified'])->name('dashboardb');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
