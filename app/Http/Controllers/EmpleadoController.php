<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar el facade Auth
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class EmpleadoController extends Controller
{
    // Mostrar todos los empleados
    public function index()
    {
        $empleados = Empleado::all();
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
            'correo.unique' => 'El correo electrónico ya está registrado.',
            'numero_identificacion.unique' => 'Ya existe un empleado con ese número de identificación.'
        ]);
    
        try {
            DB::transaction(function () use ($validatedData, $request) {
                // Crear el empleado
                $empleado = Empleado::create($validatedData);
    
                // Crear el usuario asociado
                User::create([
                    'name' => $empleado->primer_nombre . ' ' . $empleado->primer_apellido,
                    'employeeId' => $empleado->id,
                    'email' => $empleado->correo,
                    'role' => $request->input('role', 'employee'),
                    'password' => Hash::make($empleado->numero_identificacion),
                ]);
            });
    
            return redirect()->route('empleados.index')
                ->with('success', 'Empleado y usuario creados correctamente');
    
        } catch (\Exception $e) {
            Log::error('Error al crear empleado y usuario: ' . $e->getMessage());
    
            return back()->withInput()
                ->withErrors(['error' => 'Hubo un problema al crear el empleado o el usuario. Intente nuevamente.']);
        }
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
        $empleado = Empleado::findOrFail($id);

        $data = $request->all();
        
        $request->validate([
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'tipo_identificacion' => 'required|string',
            'numero_identificacion' => 'required|numeric|unique:empleados,numero_identificacion,' . $empleado->id,
            'municipio' => 'required|string',
            'direccion' => 'required|string|max:255',
            'celular' => 'required|numeric',
            'correo' => 'required|email|unique:empleados,correo,' . $empleado->id,
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

        if ($request->metodo_pago == 'pago_efectivo') {
            $data['banco'] = null;
            $data['numero_cuenta'] = null;
            $data['tipo_cuenta'] = null;
        }

        $empleado->update($data);
        // $empleado->update($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado con éxito.');
        Log::info('Empleado que se está editando:', ['municipio' => $empleado->municipio]);
    }

    // Eliminar un empleado existente
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado con éxito.');
    }
}
