<?php

namespace App\Http\Controllers;

use App\Models\Incapacidad;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IncapacidadController extends Controller
{
    // GET /incapacidades
    public function index()
    {
        $incapacidades = Incapacidad::all();

        return view('incapacidades.index', compact('incapacidades'));
    }

    // GET/create
    public function create()
    {
        return view('incapacidades.create');
    }


    // GET /incapacidades/{id}
    public function show($id)
    {
        $incapacidad = Incapacidad::findOrFail($id);
        return view('incapacidades.show', compact('incapacidad'));
    }

    // POST /incapacidades
    public function store(Request $request)
    {
        try {
            $request->validate([
                'fecha_contratacion' => 'required|date',
                'fecha_fin_incapacidad' => 'required|date|after_or_equal:fecha_contratacion',
                'tipo_incapacidad' => 'required|string|max:100',
                'descripcion' => 'nullable|string|max:1000',
                'soporte' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $soportePath = null;
            if ($request->hasFile('soporte')) {
                $soportePath = $request->file('soporte')->store('incapacidades', 'public');
            }

            /** @var \App\Models\User $user */ // <-- This PHPDoc hint is for Intelephense
            $user = Auth::user();
            $empleadoId = $user->empleado->id;
            if (!$empleadoId) {
                return back()->withErrors(['No se encontró un empleado asociado al usuario actual.']);
            }

            $dias = \Carbon\Carbon::parse($request->fecha_contratacion)->diffInDays(\Carbon\Carbon::parse($request->fecha_fin_incapacidad)) + 1;

            Incapacidad::create([
                'id_empleado' => $empleadoId,
                'fecha_inicio' => $request->fecha_contratacion,
                'fecha_fin' => $request->fecha_fin_incapacidad,
                'dias_incapacidad' => $dias,
                'fecha_registro' => now(),
                'tipo_incapacidad' => $request->tipo_incapacidad,
                'descripcion' => $request->descripcion,
                'soporte' => $soportePath,
                'estado' => 'Pendiente',
            ]);

            return redirect()->route('empleados.showself')->with('success', 'Incapacidad registrada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al registrar incapacidad: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error al guardar la incapacidad.']);
        }
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

    public function review(Request $request, $id)
    {
        $incapacidad = Incapacidad::findOrFail($id);

        $incapacidad->estado = $request->estado;
        $incapacidad->observaciones_rrhh = $request->observaciones_rrhh;
        $incapacidad->fecha_revision = now();
        $incapacidad->id_rrhh = Auth::id();

        $incapacidad->save();

        return redirect()->route('incapacidades.index')->with('success', 'Incapacidad actualizada correctamente');
    }

    // DELETE /incapacidades/{id}
    public function destroy($id)
    {
        $incapacidad = Incapacidad::findOrFail($id);
        $incapacidad->delete();
        return redirect()->route('incapacidades.index')->with('success', 'Incapacidad eliminado con éxito.');
    }
}
