    <?php

    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Auth; // Asegúrate de importar el facade Auth
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
        DeduccionNominaController,
        PagoController
    };
use App\Models\Liquidacion;

    // Redirección raíz condicional según el rol del usuario
    Route::get('/', function () {

        /** @var \App\Models\User $user */ // <-- This PHPDoc hint is for Intelephense
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasRole('admin') || $user->hasRole('rrhh')) {
            return redirect()->route('dashboard');
        }

        if ($user->hasRole('employee')) {
            return redirect('/profile');
        }

        // Si el usuario no tiene roles válidos, abortar con 403
        abort(403, 'No tienes permisos para acceder.');
    })->middleware('auth')->name('home');

    // Vista del dashboard (solo admin y rrhh)
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $lastLiquid = Liquidacion::where('progreso', 100)
        ->orderBy('fecha_inicio', 'desc')
        ->first();
        return view('dashboard', compact('user', 'lastLiquid'));
    })->middleware(['auth', 'role:admin,rrhh'])->name('dashboard');


    // Autenticación y perfil
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Recursos principales (RESTful) ['admin', 'rrhh', 'employee']
    Route::middleware(['auth', 'role:admin,rrhh'])->group(function () {
        Route::resources([
            'departamentos'  => DepartamentoController::class,
            'empleados'      => EmpleadoController::class,
            'nominas'        => NominaController::class,
            'deducciones'    => DeduccionController::class,
            'bonificaciones' => ComisionController::class,
            'liquidaciones'  => LiquidacionController::class,
            'incapacidades'  => IncapacidadController::class,
            'pagos'          => PagoController::class,
        ]);
    });


    // Rutas personalizadas (acciones específicas)
    Route::put('/incapacidades/{id}/review', [IncapacidadController::class, 'review'])->name('incapacidades.review');

    Route::middleware(['auth', 'role:admin,rrhh,employee'])->group(function () {
        Route::get('/profile', [EmpleadoController::class, 'showself'])->name('empleados.showself');
    });

    Route::post('api/add/nomina', [NominaController::class, 'store']);
    // Route::get('/edit/nominas/{id}', [NominaController::class, 'edit'])->name('nominas.edit');
    Route::get('/liquidar/nominas/{id}', [NominaController::class, 'liquidar'])->name('nominas.liquidar');


    Route::post('api/add/deducciones', [DeduccionController::class, 'store']);
    Route::post('api/add/deduccionesnomina', [DeduccionNominaController::class, 'store']);

    Route::post('api/add/comisiones', [ComisionController::class, 'store']);
    Route::post('api/add/comisionesnomina', [ComisionNominaController::class, 'store']);

    Route::delete('api/delete/liquidacion/{id}', [LiquidacionController::class, 'destroy']);
    Route::delete('api/delete/deduccionnomina/{nomina_id}/{deduccion_id}', [DeduccionNominaController::class, 'destroy'])->name('deduccionnomina.delete');
    Route::delete('api/delete/comisionnomina/{nomina_id}/{comision_id}', [ComisionNominaController::class, 'destroy'])->name('comisionnomina.delete');
    Route::put('api/update/comisionnomina/{nomina_id}/{comision_id}', [ComisionNominaController::class, 'update'])->name('comisionnomina.update');
    // Route::put('api/update/deduccionnomina/{nomina_id}/{deduccion_id}', [DeduccionNominaController::class, 'update'])->name('comisionnomina.update');
    Route::put('api/update/deduccionnomina/{nomina_id}/{deduccion_id}', [DeduccionNominaController::class, 'update'])->name('deduccionnomina.update');

    Route::post('api/add/liquidacion', [LiquidacionController::class, 'store']);
    Route::get('api/getall/liquidaciones', [LiquidacionController::class, 'getLiquidaciones']);
    Route::post('api/add/nomina', [NominaController::class, 'store']);

    require __DIR__ . '/auth.php';
