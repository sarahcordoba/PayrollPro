<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    // GET /pagos
    public function index()
    {
        $pagos = Pago::with(['empleado', 'nomina'])->get();
        return view('pagos.index', compact('pagos'));
    }

    // GET /pagos/{id}
    public function show($id)
    {
        $pago = Pago::with(['empleado', 'nomina'])->findOrFail($id);
        return view('pagos.show', compact('pago'));
    }

    // POST /pagos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'nomina_id' => 'required|exists:nominas,id',
            'total_devengado' => 'required|numeric|min:0',
            'total_deducciones' => 'required|numeric|min:0',
            'total_pagado' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'estado_pago' => 'required|string|max:100',
        ]);

        $pago = Pago::create($validated);
        return response()->json($pago, 201);
    }

    // GET /pagos/{id}/edit
    public function edit($id)
    {
        $pago = Pago::findOrFail($id);
        return response()->json($pago);
    }

    // PUT /pagos/{id}
    public function update(Request $request, $id)
    {
        $pago = Pago::findOrFail($id);

        $validated = $request->validate([
            'empleado_id' => 'sometimes|exists:empleados,id',
            'nomina_id' => 'sometimes|exists:nominas,id',
            'total_devengado' => 'sometimes|numeric|min:0',
            'total_deducciones' => 'sometimes|numeric|min:0',
            'total_pagado' => 'sometimes|numeric|min:0',
            'fecha_pago' => 'sometimes|date',
            'estado_pago' => 'sometimes|string|max:100',
        ]);

        $pago->update($validated);
        return response()->json($pago);
    }

    // DELETE /pagos/{id}
    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();

        return redirect()->route('pagos.index')->with('success', 'Pago eliminado con éxito.');
    }
}
