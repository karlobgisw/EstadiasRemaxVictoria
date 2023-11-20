<?php

namespace App\Http\Controllers;

use App\Models\RegistroCierre;
use App\Models\User;
use App\Models\FuenteContacto;
use Illuminate\Http\Request;

class RegistroSCRUDController extends Controller
{
    public function index()
    {
        $registros = RegistroCierre::all();
        $usuarios = User::all();
        $fuentes_contacto = FuenteContacto::all();
        $permiso = 'full';

        return view('registroscrud.index', compact('registros', 'usuarios', 'fuentes_contacto', 'permiso'));
    }

    public function edit($id)
    {
        $registro = RegistroCierre::findOrFail($id);
        $usuarios = User::all();
        $fuentes_contacto = FuenteContacto::all();
        $permiso = 'full';

        return view('registroscrud.edit', compact('registro', 'usuarios', 'fuentes_contacto', 'permiso'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        // Agrega las reglas de validación necesarias
        'cerroModal' => 'required|integer|exists:users,id',
        'ingresoModal' => 'required|integer|exists:users,id',
        'montoPropiedadModal' => 'required|string',
        'recursoModal' => 'required|string',
        'fuente_contacto' => 'required|integer|exists:fuentes_contacto,id',
        'genero' => 'required|string|not_in:0',
        'rango_edad' => 'required|string|not_in:0',
        'estado_civil' => 'required|string|not_in:0',
    ]);
    
    $registro = RegistroCierre::findOrFail($id);

    // Actualiza los campos con los valores del formulario
    $registro->update([
        'cerro' => $request->input('cerroModal'),
        'ingreso' => $request->input('ingresoModal'),
        'monto_propiedad' => $request->input('montoPropiedadModal'),
        'recurso' => $request->input('recursoModal'),
        'fuente_contacto' => $request->input('fuente_contacto'),
        'genero' => $request->input('genero'),
        'rango_edad' => $request->input('rango_edad'),
        'estado_civil' => $request->input('estado_civil'),
    ]);
    

    return redirect()->route('registroscrud.index')->with('success', 'Registro actualizado exitosamente');
}

    public function destroy($id)
    {
        $registro = RegistroCierre::findOrFail($id);
        $registro->delete();

        return redirect()->route('registroscrud.index')->with('success', 'Registro eliminado exitosamente');
    }
}
