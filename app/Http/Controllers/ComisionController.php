<?php

namespace App\Http\Controllers;

use App\Models\Comision;
use Illuminate\Http\Request;

class ComisionController extends Controller
{
    // Mostrar todas las comisiones
    public function index()
    {
        $comisiones = Comision::all();
        return response()->json($comisiones);
    }

    // Mostrar una comisión específica
    public function show($id)
    {
        $comision = Comision::findOrFail($id);
        return response()->json($comision);
    }

    // Crear una nueva comisión
    public function store(Request $request)
    {
        $comision = Comision::create($request->all());
        return response()->json($comision, 201);
    }

    // Actualizar una comisión
    public function update(Request $request, $id)
    {
        $comision = Comision::findOrFail($id);
        $comision->update($request->all());
        return response()->json($comision, 200);
    }

    // Eliminar una comisión
    public function destroy($id)
    {
        $comision = Comision::findOrFail($id);
        $comision->delete();
        return response()->json(null, 204);
    }
}
