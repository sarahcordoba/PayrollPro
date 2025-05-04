<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    // Mostrar todos los departamentos
    public function index()
    {
        $departamentos = Departamento::all();
        return view('departamentos.index', compact('departamentos'));
    }

    // Mostrar el formulario para crear un nuevo departamento
    public function create()
    {
        return view('departamentos.create');
    }

    // Guardar un nuevo departamento
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        Departamento::create($request->all());

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado con éxito.');
    }

    // Mostrar un departamento específico
    public function show($id)
    {
        $departamento = Departamento::findOrFail($id);
        return view('departamentos.show', compact('departamento'));
    }

    // Mostrar el formulario para editar un departamento existente
    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);
        return view('departamentos.edit', compact('departamento'));
    }

    // Actualizar un departamento existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        $departamento = Departamento::findOrFail($id);
        $departamento->update($request->all());

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado con éxito.');
    }

    // Eliminar un departamento existente
    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado con éxito.');
    }
}
