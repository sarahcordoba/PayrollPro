<?php

namespace App\Http\Controllers;

use App\Models\Nomina;
use App\Models\Empleado;
use App\Models\Deduccion;
use App\Models\Comision;
use App\Models\DeduccionNomina;
use App\Models\ComisionNomina;
use App\Models\Liquidacion;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class NominaController extends Controller
{
    // Mostrar todas las nóminas
    public function index()
    {
        $nominas = Nomina::all();
        return response()->json($nominas);
    }

    // Mostrar una nómina específica
    public function show($id)
    {
        $fromIndex = request()->query('fromIndex', false); // devuelve true/false

        Log::info($fromIndex);

        
        $nomina = Nomina::findOrFail($id);
        $deduccionesAplicadas = DeduccionNomina::where('nomina_id', $nomina->id)->get();
        $comisionesAplicadas = ComisionNomina::where('nomina_id', $nomina->id)->get();
        $deduccionesDisponibles = Deduccion::all();
        $comisionesDisponibles = Comision::all();
        //return response()->json($nomina);
        return view('nominas.show', compact('nomina', 'deduccionesAplicadas', 'comisionesAplicadas', 'fromIndex')); //, 'deduccionesDisponibles', 'comisionesDisponibles'));
    }

    // Crear una nueva nómina
    public function store(Request $request)
    {
        try {
            // Obtener el empleado
            $empleado = Empleado::find($request->empleado_id);
            if (!$empleado) {
                return response()->json(['error' => 'Empleado no encontrado'], 404);
            }

            $yatiene = Nomina::where('empleado_id', $request->empleado_id)->where('idLiquidacion', $request->idLiquidacion)->first();
            if ($yatiene) {
                return response()->json(['error' => 'Empleado ya existe en liquidacion'], 503);
            }
            // Calcular el total devengado, incluyendo el salario base
            $totalDevengado = $empleado->salario;

            // Inicializar variables para comisiones y deducciones
            $vComisiones = 0;
            $vDeducciones = 0;

            // Inicializar arreglos para deducciones y comisiones de la nómina
            $comisionesNomina = [];
            $deduccionesNomina = [];

            // Si el salario es menor al doble del salario mínimo, aplicar auxilio de transporte
            if ($empleado->salario < (1300000 * 2)) {
                $comisionAuxilio = Comision::find(1); // Verificar que la comisión con id 1 exista
                if ($comisionAuxilio) {
                    $comisionesNomina[] = [
                        'comision_id' => $comisionAuxilio->id,
                        'esporcentaje' => $comisionAuxilio->esporcentaje,
                        'monto' => $comisionAuxilio->monto
                    ];
                    $vComisiones += $comisionAuxilio->monto;
                }
            }

            // Obtener todas las deducciones obligatorias
            $deducciones = Deduccion::where('obligatorio', true)->get();

            foreach ($deducciones as $deduccion) {
                $valorDeduccion = 0;
                $applyDeduccion = false;

                switch ($deduccion->id) {
                    case 3:
                        // FSP
                        if ($empleado->salario > (1300000 * 4)) {
                            $valorDeduccion = $totalDevengado * $deduccion->monto;
                            $vDeducciones += $valorDeduccion;
                            $applyDeduccion = true;
                        }
                        break;
                    default:
                        // Salud y Pensión
                        if ($empleado->salario >= 1300000) {
                            $valorDeduccion = $totalDevengado * $deduccion->monto;
                            $vDeducciones += $valorDeduccion;
                            $applyDeduccion = true;
                        }

                        break;
                }

                // Agregar deducción a la nómina si es aplicable
                if ($applyDeduccion) {
                    $deduccionesNomina[] = [
                        'deduccion_id' => $deduccion->id,
                        'esporcentaje' => $deduccion->esporcentaje,
                        'monto' => $deduccion->monto
                    ];
                }
            }

            // Crear la nómina con los datos calculados
            $nominaData = [
                'empleado_id' => $empleado->id,
                'idLiquidacion' => $request->idLiquidacion,
                'metodopago' => $empleado->metodo_pago,
                'estado' => 'Por liquidar',
                'salario_base' => $empleado->salario,
                'total_deducciones' => $vDeducciones,
                'total_comisiones' => $vComisiones,
                'total' => $empleado->salario + $vComisiones - $vDeducciones
            ];

            $nomina = Nomina::create($nominaData);
            Log::error('GUARDANMOS LA NOMINA');

            // Guardar cada comisión de la nómina con el ID de la nómina creada
            foreach ($comisionesNomina as $comisionData) {
                ComisionNomina::create([
                    'nomina_id' => $nomina->id,
                    'comision_id' => $comisionData['comision_id'],
                    'esporcentaje' => $comisionData['esporcentaje'],
                    'monto' => $comisionData['monto']
                ]);
            }
            Log::error('GUARDANMOS LAS COMISIONES');

            // Guardar cada deducción de la nómina con el ID de la nómina creada
            foreach ($deduccionesNomina as $deduccionData) {
                DeduccionNomina::create([
                    'nomina_id' => $nomina->id,
                    'deduccion_id' => $deduccionData['deduccion_id'],
                    'esporcentaje' => $deduccionData['esporcentaje'],
                    'monto' => $deduccionData['monto']
                ]);
            }

            DB::statement("CALL UpdateLiquidacionTotals($nomina->idLiquidacion)");
            return response()->json([
                'id' => $nomina->id,
                'salario_base' => $nomina->salario_base,
                'total_deducciones' => $nomina->total_deducciones,
                'total_comisiones' => $nomina->total_comisiones,
                'total' => $nomina->total,
                'estado' => $nomina->estado,
                'empleado' => [
                    'primer_nombre' => $empleado->primer_nombre,
                    'segundo_nombre' => $empleado->segundo_nombre,
                    'primer_apellido' => $empleado->primer_apellido,
                    'segundo_apellido' => $empleado->segundo_apellido,
                ]
            ], 201);
        } catch (\Exception $e) {
            // Registrar el error y retornar una respuesta JSON
            Log::error('Error en el método store: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    // Actualizar una nómina
    public function update(Request $request, $id)
    {
        $nomina = Nomina::findOrFail($id);
        $nomina->update($request->all());
        return response()->json($nomina, 200);
    }

    // Eliminar una nómina
    public function destroy($id)
    {
        $nomina = Nomina::findOrFail($id);
        $nomina->delete();
        return response()->json(null, 204);
    }

    public function edit($id)
    {
        // Buscar la nómina por ID
        $nomina = Nomina::findOrFail($id);
        $deduccionesAplicadas = DeduccionNomina::where('nomina_id', $nomina->id)->get();
        $comisionesAplicadas = ComisionNomina::where('nomina_id', $nomina->id)->get();
        $deduccionesDisponibles = Deduccion::all();
        $comisionesDisponibles = Comision::all();
        //return response()->json($nomina);
        return view('nominas.edit', compact('nomina', 'deduccionesAplicadas', 'comisionesAplicadas', 'deduccionesDisponibles', 'comisionesDisponibles'));
        // Retornar la vista de edición con la información de la nómina
    }

    public function liquidar(Request $request, $id)
    {
        Log::info('Mondongo1: ', ['paymentOption' => $request['paymentOption']]);


        $request->validate([
            'paymentOption' => 'required|string|in:transferencia,pago_efectivo,cheque_bancario,pago_especie',
        ]);

        Log::info('Mondongo2');


        $nomina = Nomina::findOrFail($id);

        Log::info('Mondongo3');


        $nomina->estado = 'Liquidado';
        $nomina->metodopago = $request->paymentOption;
        $nomina->save();
        
        Log::info('Mondongo4');

        $liquidacion = Liquidacion::findOrFail($nomina->idLiquidacion);

        Log::info('Mondongo5');


        $total = Nomina::where('idLiquidacion', $liquidacion->id)->count();
        $liquidadas = Nomina::where('idLiquidacion', $liquidacion->id)
            ->where('estado', 'Liquidado')
            ->count();

        Log::info('Mondong6');


        $progreso = $total > 0 ? round(($liquidadas / $total) * 100, 2) : 0;
        $liquidacion->progreso = $progreso;
        
        if ($progreso >= 100) {
            $liquidacion->estado = 'Liquidado';
        }
        
        
        $liquidacion->save();
        Log::info('Mondong7');

        // Crear el pago automáticamente
        $pago = Pago::create(attributes: [
            'empleado_id'        => $nomina->empleado_id,
            'nomina_id'          => $nomina->id,
            'total_devengado'    => $nomina->salario_base + $nomina->total_comisiones,
            'total_deducciones'  => $nomina->total_deducciones,
            'total_pagado'       => $nomina->total,
            'fecha_pago'         => now()->toDateString(),
            'estado_pago'        => 'Completado',
        ]);

        Log::info('Mondong8');

        $pago->save();

        Log::info('Mondongo?');

        $empleado = $nomina->empleado;
        $empleado->notify(new \App\Notifications\PaymentNotification());
        
        return redirect()->route('nominas.show', $nomina->id)
            ->with('success', 'Nómina liquidada y pago registrado automáticamente.');
    }
}
