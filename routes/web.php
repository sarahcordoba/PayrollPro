    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\{
        ProfileController,
        DepartamentoController,
        EmpleadoController,
        NominaController,
        DeduccionController,
        ComisionController,
        LiquidacionController,
        IncapacidadController,
        ComisionNominaController,
        DeduccionNominaController
    };

    // Redirección raíz al dashboard
    Route::get('/', fn() => redirect()->route('dashboard'))->name('home');

    // Vista del dashboard
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Autenticación y perfil
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Recursos principales (RESTful)
    Route::resources([
        'departamentos' => DepartamentoController::class,
        'empleados'     => EmpleadoController::class,
        'nominas'       => NominaController::class,
        'deducciones'   => DeduccionController::class,
        'bonificaciones' => ComisionController::class,
        'liquidaciones' => LiquidacionController::class,
        'incapacidades' => IncapacidadController::class,
    ]);

    // Rutas personalizadas (acciones específicas)
    Route::put('/nominas/{id}/liquidar', [NominaController::class, 'liquidar'])->name('nominas.liquidar');
    Route::put('/incapacidades/{id}/review', [IncapacidadController::class, 'review'])->name('incapacidades.review');
    Route::get('/edit/nominas/{id}', [NominaController::class, 'edit'])->name('nominas.edit');

    Route::delete('api/delete/deduccionnomina/{nomina_id}/{deduccion_id}', [DeduccionNominaController::class, 'destroy'])->name('deduccionnomina.delete');
    Route::delete('api/delete/comisionnomina/{nomina_id}/{comision_id}', [ComisionNominaController::class, 'destroy'])->name('comisionnomina.delete');
    Route::put('api/update/comisionnomina/{nomina_id}/{comision_id}', [ComisionNominaController::class, 'update'])->name('comisionnomina.update');
    Route::put('api/update/deduccionnomina/{nomina_id}/{deduccion_id}', [DeduccionNominaController::class, 'update'])->name('comisionnomina.update');

    require __DIR__ . '/auth.php';
