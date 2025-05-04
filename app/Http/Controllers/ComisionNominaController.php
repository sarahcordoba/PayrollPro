<?php

namespace App\Http\Controllers;

use App\Models\ComisionNomina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ComisionNominaController extends Controller
{
    // Mostrar todas las comisiones asignadas a nóminas
    public function index()
    {
        $comisionesNomina = ComisionNomina::all();
        return response()->json($comisionesNomina);
    }

    // Mostrar una relación específica entre nómina y comisión
    public function show($nomina_id, $comision_id)
    {
        $comisionNomina = ComisionNomina::where('nomina_id', $nomina_id)
            ->where('comision_id', $comision_id)
            ->firstOrFail();
        return response()->json($comisionNomina);
    }

    // Asignar una comisión a una nómina
    public function store(Request $request)
    {
        $comisionNomina = ComisionNomina::create($request->all());
        return response()->json($comisionNomina, 201);
    }

    // Actualizar una comisión asignada a una nómina
    public function update(Request $request, $nomina_id, $comision_id)
    {
        try {
            Log::info('Request Data: ' . json_encode($request->all()));
    
            // Fetch the specific record
            $comisionNomina = ComisionNomina::where('nomina_id', $nomina_id)
                ->where('comision_id', $comision_id)
                ->firstOrFail();
            Log::info('Fetched record: ' . json_encode($comisionNomina));
    
            // Validate the request data
            $request->validate([
                'esporcentaje' => 'required|boolean',
                'monto' => 'required|numeric',
            ]);
            Log::info('Validation passed.');
    
            // Retrieve and sanitize inputs
            $comisionNomina->esporcentaje = $request->input('esporcentaje');
            $comisionNomina->monto = $request->input('monto');
    
            // Save the record
            $comisionNomina->save();
            Log::info('Record saved successfully.');
    
            return response()->json(['success' => 'si'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating ComisionNomina: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    // Eliminar una comisión asignada a una nómina
    public function destroy($nomina_id, $comision_id)
    {
        // Eliminar basado en las claves compuestas
        ComisionNomina::where('nomina_id', $nomina_id)
            ->where('comision_id', $comision_id)
            ->delete();

        // Redireccionar a la página de edición de la nómina
        return redirect()->route('nominas.edit', ['id' => $nomina_id])
            ->with('success', 'Comisión eliminada exitosamente.');
    }
}
