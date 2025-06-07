<?php

namespace App\Http\Controllers;

use App\Models\Incapacidad;
use Illuminate\Http\Request;

class IncapacidadController extends Controller
{
    // GET /incapacidades
    public function index()
    {
        $incapacidades = Incapacidad::all();

        return view('incapacidades.index', compact('incapacidades'));
    }

    // GET /incapacidades/{id}
    public function show($id)
    {
        $incapacidad = Incapacidad::findOrFail($id);
        return response()->json($incapacidad);
    }

    // POST /incapacidades
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_empleado' => 'required|integer|exists:empleados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'dias_incapacidad' => 'nullable|integer|min:0',
            'fecha_registro' => 'required|date',
            'tipo_incapacidad' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:1000',
            'soporte' => 'nullable|string|max:500',
            'estado' => 'nullable|string|max:50',
            'fecha_revision' => 'nullable|date',
            'id_rrhh' => 'nullable|integer|exists:users,id',
            'observaciones_rrhh' => 'nullable|string|max:1000',
        ]);

        $incapacidad = Incapacidad::create($validated);
        return response()->json($incapacidad, 201);
    }

    // GET /incapacidades/{id}/edit
    public function edit($id)
    {
        $incapacidad = Incapacidad::findOrFail($id);
        return response()->json($incapacidad);
    }

    // PUT /incapacidades/{id}
    public function update(Request $request, $id)
    {
        $incapacidad = Incapacidad::findOrFail($id);

        $validated = $request->validate([
            'id_empleado' => 'sometimes|integer|exists:empleados,id',
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'dias_incapacidad' => 'nullable|integer|min:0',
            'fecha_registro' => 'sometimes|date',
            'tipo_incapacidad' => 'sometimes|string|max:100',
            'descripcion' => 'nullable|string|max:1000',
            'soporte' => 'nullable|string|max:500',
            'estado' => 'nullable|string|max:50',
            'fecha_revision' => 'nullable|date',
            'id_rrhh' => 'nullable|integer|exists:users,id',
            'observaciones_rrhh' => 'nullable|string|max:1000',
        ]);

        $incapacidad->update($validated);
        return response()->json($incapacidad);
    }

    // DELETE /incapacidades/{id}
    public function destroy($id)
    {
        $incapacidad = Incapacidad::findOrFail($id);
        $incapacidad->delete();
        return response()->json(['message' => 'Incapacidad eliminada correctamente']);
    }
}
