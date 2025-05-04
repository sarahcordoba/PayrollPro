<?php

namespace App\Http\Controllers;

use App\Models\DeduccionNomina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeduccionNominaController extends Controller
{
    // Mostrar todas las deducciones asignadas a nóminas
    public function index()
    {
        $deduccionesNomina = DeduccionNomina::all();
        return response()->json($deduccionesNomina);
    }

    // Mostrar una deducción específica asignada a una nómina
    public function show($nomina_id, $deduccion_id)
    {
        $deduccionNomina = DeduccionNomina::where('nomina_id', $nomina_id)
            ->where('deduccion_id', $deduccion_id)
            ->firstOrFail();
        return response()->json($deduccionNomina);
    }

    // Asignar una deducción a una nómina
    public function store(Request $request)
    {
        try {
            $deduccionNomina = DeduccionNomina::create($request->all());
            return response()->json($deduccionNomina, 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    // Actualizar una deducción asignada a una nómina
    public function update(Request $request, $nomina_id, $deduccion_id)
    {
        try {
            Log::info('Request Data: ' . json_encode($request->all()));

            // Fetch the specific record
            $deduccionNomina = DeduccionNomina::where('nomina_id', $nomina_id)
                ->where('deduccion_id', $deduccion_id)
                ->firstOrFail();
            Log::info('Fetched record: ' . json_encode($deduccionNomina));

            // Validate the request data
            $request->validate([
                'esporcentaje' => 'required|boolean',
                'monto' => 'required|numeric',
            ]);
            Log::info('Validation passed.');

            // Retrieve and sanitize inputs
            $deduccionNomina->esporcentaje = $request->input('esporcentaje');
            $deduccionNomina->monto = $request->input('monto');
            Log::info('New record: ' . json_encode($deduccionNomina));

            // Save the record
            $deduccionNomina->save();
            Log::info('Record saved successfully.');

            return response()->json(['success' => 'si'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating DeduccionNomina: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Eliminar una deducción asignada a una nómina
    public function destroy($nomina_id, $deduccion_id)
    {
        // Eliminar basado en las claves compuestas
        DeduccionNomina::where('nomina_id', $nomina_id)
            ->where('deduccion_id', $deduccion_id)
            ->delete();

        // Redireccionar a la página de edición de la nómina
        return redirect()->route('nominas.edit', ['id' => $nomina_id])
            ->with('success', 'Comisión eliminada exitosamente.');
    }
}
