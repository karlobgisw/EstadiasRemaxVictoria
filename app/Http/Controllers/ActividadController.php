<?php
namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\DiaSemana;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        if ($user->permisos->type === 'limited') {
            // Usuario agente
            $permiso = 'limited';
        } elseif ($user->permisos->type === 'full') {
            // Usuario staff
            $permiso = 'full';
        }

        $actividades = Actividad::all();
        $diasSemana = DiaSemana::all();
        $user_id = auth()->user()->id;


        return view('agendacrear', [
            'actividades' => $actividades,
            'diasSemana' => $diasSemana,
            'permiso' => $permiso,
            'user_id' => $user_id,
        ]);
    }
    public function indexAdmin($id)
    {
        $user = Auth::guard('web')->user();
        if ($user->permisos->type === 'limited') {
            // Usuario agente
            $permiso = 'limited';
        } elseif ($user->permisos->type === 'full') {
            // Usuario staff
            $permiso = 'full';
        }

        $actividades = Actividad::all();
        $diasSemana = DiaSemana::all();
        $user_id = auth()->user()->id;

        return view('agendacrear', [
            'actividades' => $actividades,
            'diasSemana' => $diasSemana,
            'permiso' => $permiso,
            'id' => $id,
            'user_id' => $user_id
        ]);
    }

    public function create()
    {
        $diasSemana = DiaSemana::all();

        return view('actividades.create', [
            'diasSemana' => $diasSemana,
        ]);
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        
        $actividad = new Actividad();
        $actividad->nombre_actividad = $request->input('nombre_actividad');

        $actividad->save();

        return redirect()->route('actividadesAdmin', ['id' => $id]);
    }

    public function edit($id)
    {
        $actividad = Actividad::find($id);
        $diasSemana = DiaSemana::all();

        return view('actividades.edit', [
            'actividad' => $actividad,
            'diasSemana' => $diasSemana,
        ]);
    }

    public function update(Request $request, $id)
    {
        $ids = $request->input('id');

        $actividad = Actividad::find($id);
        $actividad->nombre_actividad = $request->input('nombre_actividad');

        $actividad->save();

        return redirect()->route('actividadesAdmin', ['id' => $ids]);
    }

    public function destroy(Request $request, $id)
    {
        $ids = $request->input('id');

        $actividad = Actividad::find($id);
        $actividad->delete();

        return redirect()->route('actividadesAdmin', ['id' => $ids]);
    }
}