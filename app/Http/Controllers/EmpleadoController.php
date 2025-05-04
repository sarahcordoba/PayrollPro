<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar el facade Auth


class EmpleadoController extends Controller
{
    // Mostrar todos los empleados
    public function index()
    {
        // Fetch the authenticated user's ID
        $idEmpleador = Auth::id();

        // Get all empleados where idEmpleador matches the logged user's ID
        $empleados = Empleado::where('idEmpleador', $idEmpleador)->get();
        $totalEmpleados = $empleados->count();

        return view('empleados.index', compact('empleados', 'totalEmpleados'));
    }

    // Mostrar el formulario para crear un nuevo empleado
    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        Log::info('Request Data: ', $request->all());

        // Validate the data
        $validatedData = $request->validate([
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'tipo_identificacion' => 'required|string',
            'numero_identificacion' => 'required|numeric|unique:empleados,numero_identificacion',
            'municipio' => 'required|string',
            'direccion' => 'required|string|max:255',
            'celular' => 'required|numeric',
            'correo' => 'required|email|unique:empleados,correo',
            'tipo_contrato' => 'required|string',
            'fecha_contratacion' => 'required|date',
            'fecha_fin_contrato' => 'nullable|date|after_or_equal:fecha_contratacion',
            'salario' => 'required|numeric|min:0',
            'salario_integral' => 'required|boolean',
            'frecuencia_pago' => 'required|string',
            'tipo_trabajador' => 'required|string',
            'subtipo_trabajador' => 'nullable|string',
            'auxilio_transporte' => 'required|boolean',
            'alto_riesgo' => 'required|boolean',
            'sabado_laboral' => 'required|boolean',
            'nivel_riesgo' => 'required|string',
            'cargo' => 'required|string',
            'area' => 'required|string',
            'dias_vacaciones' => 'required|numeric|min:0',
            'metodo_pago' => 'required|string',
            'banco' => 'nullable|string',
            'numero_cuenta' => 'nullable|string',
            'tipo_cuenta' => 'nullable|string',
            'eps' => 'required|string',
            'caja_compensacion' => 'required|string',
            'fondo_pensiones' => 'required|string',
            'fondo_cesantias' => 'required|string',
        ], [
            'correo.unique' => 'El correo electrónico ya está registrado. Por favor, ingrese otro.'
        ]);

        // Add the idEmpleador from the authenticated user
        $validatedData['idEmpleador'] = Auth::id();  // Assign the idEmpleador
        Log::info('Data: ', $validatedData);

        // Create the new employee with the validated data
        Empleado::create($validatedData);

        // Redirect to the employee list page with a success message
        return redirect()->route('empleados.index') // Change to the desired route
            ->with('success', 'Empleado creado correctamente');
    }

    // Mostrar un empleado específico
    public function show($id)
    {
        // $empleado = Empleado::findOrFail($id);
        // return view('empleados.show', data: compact('empleado'));


        // Obtén el empleado
        $empleado = Empleado::findOrFail($id);

        // Fecha de contratación
        $fechaContratacion = Carbon::parse($empleado->fecha_contratacion)->startOfDay(); // Eliminar horas

        // Fecha actual (hoy)
        $currentDate = Carbon::now()->startOfDay(); // Eliminar horas

        // Si la fecha de contratación es hoy mismo, el empleado ya está trabajando
        if ($fechaContratacion->isToday()) {
            $diasTrabajados = 1;
        } else {
            // Calcular la diferencia en días completos
            $diasTrabajados = $fechaContratacion->diffInDays($currentDate);
        }

        // Pasar los datos a la vista
        return view('empleados.show', compact('empleado', 'diasTrabajados'));
    }

    // Mostrar el formulario para editar un empleado existente
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    // Actualizar un empleado existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'required|string|max:255',
            'tipo_identificacion' => 'required|string',
            'numero_identificacion' => 'required|numeric|unique:empleados,numero_identificacion',
            'municipio' => 'required|string',
            'direccion' => 'required|string|max:255',
            'celular' => 'required|numeric',
            'correo' => 'required|email|unique:empleados,correo',
            'tipo_contrato' => 'required|string',
            'fecha_contratacion' => 'required|date',
            'fecha_fin_contrato' => 'nullable|date|after_or_equal:fecha_contratacion',
            'salario' => 'required|numeric|min:0',
            'salario_integral' => 'required|boolean',
            'frecuencia_pago' => 'required|string',
            'tipo_trabajador' => 'required|string',
            'subtipo_trabajador' => 'nullable|string',
            'auxilio_transporte' => 'required|boolean',
            'alto_riesgo' => 'required|boolean',
            'sabado_laboral' => 'required|boolean',
            'nivel_riesgo' => 'required|string',
            'cargo' => 'required|string',
            'area' => 'required|string',
            'dias_vacaciones' => 'required|numeric|min:0',
            'metodo_pago' => 'required|string',
            'banco' => 'nullable|string',
            'numero_cuenta' => 'nullable|string',
            'tipo_cuenta' => 'nullable|string',
            'eps' => 'required|string',
            'caja_compensacion' => 'required|string',
            'fondo_pensiones' => 'required|string',
            'fondo_cesantias' => 'required|string',
        ]);

        $empleado = Empleado::findOrFail($id);
        $empleado->update($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado con éxito.');
    }

    // Eliminar un empleado existente
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado con éxito.');
    }
}
