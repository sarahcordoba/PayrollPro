<?php

namespace App\Http\Controllers;

use App\Models\Deduccion;
//use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeduccionController extends Controller
{
    // Mostrar todas las deducciones
    public function index()
    {
        $deducciones = Deduccion::all();
        return response()->json($deducciones);
    }

    // Mostrar una deducción específica
    public function show($id)
    {
        $deduccion = Deduccion::findOrFail($id);
        return response()->json($deduccion);
    }

    // Crear una nueva deducción
    public function store(Request $request)
    {
        try {
            $deduccion = Deduccion::create($request->all());
            return response()->json($deduccion, 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    // Actualizar una deducción
    public function update(Request $request, $id)
    {
        $deduccion = Deduccion::findOrFail($id);
        $deduccion->update($request->all());
        return response()->json($deduccion, 200);
    }

    // Eliminar una deducción
    public function destroy($id)
    {
        $deduccion = Deduccion::findOrFail($id);
        $deduccion->delete();
        return response()->json(null, 204);
    }
}
