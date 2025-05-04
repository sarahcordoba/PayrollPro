<?php

namespace App\Http\Controllers;

use App\Models\Liquidacion;
use App\Models\Empleado;
use App\Models\DeduccionNomina;
use App\Models\ComisionNomina;
use App\Models\Nomina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LiquidacionController extends Controller
{
    // Mostrar todas las liquidaciones
    public function index()
    {
        $liquidaciones = Liquidacion::all();
        return view('liquidaciones.index', compact('liquidaciones'));
    }

    // Mostrar el formulario para crear una nueva liquidación
    public function create()
    {
        $empleados = Empleado::all(); // Asumiendo que tienes el modelo Empleado
        return view('liquidaciones.create', compact('empleados'));
    }

    // Guardar una nueva liquidación en la base de datos
    public function store(Request $request)
    {
        try {
            $request->validate([
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'estado' => 'required|string|max:15',
                'salario' => 'required|numeric',
                'total_deducciones' => 'nullable|numeric',
                'total_comisiones' => 'nullable|numeric',
                'total' => 'required|numeric',
            ]);

            // Crear la liquidación
            $liquidacion = Liquidacion::create($request->all());

            // Retornar un JSON con éxito y los datos de la liquidación creada
            // Retornar el ID de la liquidación recién creada como JSON
            return response()->json(['id' => $liquidacion->id, 'message' => 'Liquidación creada exitosamente.']);
        } catch (\Exception $e) {
            // Log the error and return a JSON response
            Log::error('Error in store method: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // Mostrar una liquidación específica
    public function show($id)
    {
        $liquidacion = Liquidacion::findOrFail($id);
        $nominas = Nomina::where('idLiquidacion', $id)->get(); // Obtiene las nóminas relacionadas con esta liquidación
        $empleados = Empleado::where('idEmpleador', Auth::id())->get(); // Filtra empleados asociados al usuario logueado
        return view('liquidaciones.show', compact('liquidacion', 'nominas', 'empleados'));
    }


    // Mostrar el formulario para editar una liquidación
    public function edit($id)
    {
        $liquidacion = Liquidacion::findOrFail($id);
        $empleados = Empleado::all();
        return view('liquidaciones.edit', compact('liquidacion', 'empleados'));
    }

    // Actualizar una liquidación en la base de datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'idEmpleado' => 'required|exists:empleados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|string|max:15',
            'salario' => 'required|numeric',
            'total_deducciones' => 'nullable|numeric',
            'total_comisiones' => 'nullable|numeric',
            'total' => 'required|numeric',
        ]);

        $liquidacion = Liquidacion::findOrFail($id);
        $liquidacion->update($request->all());

        return redirect()->route('liquidaciones.index')->with('success', 'Liquidación actualizada exitosamente.');
    }

    // Eliminar una liquidación de la base de datos
    public function destroy($id)
    {
        // Find the liquidacion by id
        $liquidacion = Liquidacion::findOrFail($id);

        // Get all the nominas associated with the liquidacion
        $nominas = Nomina::where('idLiquidacion', $id)->get()->each->delete();

        // Loop through each nomina and delete associated deducciones and comisiones
        //foreach ($nominas as $nomina) {
            // Get the related DeduccionNomina and ComisionNomina records and delete them
            //DeduccionNomina::where('nomina_id', $nomina->id)->delete();
            //ComisionNomina::where('nomina_id', $nomina->id)->delete();
        //}

        // Delete all the nominas associated with the liquidacion
        //$nominas->each->delete();

        // Finally, delete the liquidacion
        $liquidacion->delete();

        return redirect()->route('liquidaciones.index')->with('success', 'Liquidación eliminada exitosamente.');
    }


    public function getLiquidaciones()
    {
        return response()->json(Liquidacion::all());
    }
}
