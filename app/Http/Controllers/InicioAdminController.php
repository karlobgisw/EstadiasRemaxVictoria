<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\User; // Asegúrate de importar el modelo User
use App\Models\Contacto; // Asegúrate de importar el modelo Contacto
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class InicioAdminController extends Controller
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
    // Obtener todos los permisos
    $permisos = Permission::all();

    // Obtener agentes (usuarios con permisos limited)
    $agentes = User::where('permisos_id', function ($query) {
        $query->select('id')
            ->from('permissions')
            ->where('type', 'limited');
    })->get();

    // Obtener usuarios con permisos staff
    $usuariosStaff = User::where('permisos_id', function ($query) {
        $query->select('id')
            ->from('permissions')
            ->where('type', 'full');
    })->get();

    return view('inicioadmin', compact('agentes', 'usuariosStaff','permisos'), ['permiso' => $permiso]);
}


public function create(Request $request)
{
    // Validación de los campos del formulario
    $request->validate([
        'nombre' => 'required|string',
        'sir' => 'required|string',
        'password' => 'required|string|min:8',
        'permisos_id' => 'required|exists:permissions,id',
        'celular' => 'required|numeric',
        'correo_institucional' => 'required|email',
        // Otras reglas de validación según tus campos
    ]);

    // Crear nuevo usuario
    $usuario = new User;
    $usuario->nombre = $request->nombre;
    $usuario->sir = $request->sir;
    $usuario->password = bcrypt($request->password);
    $usuario->permisos_id = $request->permisos_id;
    $usuario->celular = $request->celular;
    $usuario->correo_institucional = $request->correo_institucional;
    
    
    // Asignar otros campos aquí

    $usuario->save();

    return redirect()->back()->with('success', 'Usuario creado exitosamente');
}

// Agrega el método para cargar la vista de edición
public function edit($id)
{
    $user = User::findOrFail($id);
    return view('editar-user', ['user' => $user]);
}


// Modifica el método update para manejar la actualización de agentes
public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'password' => 'confirmed', // Asegura que 'password' y 'password_confirmation' coincidan
            // Otras reglas de validación según tus campos
        ]);
        // Validar y actualizar el usuario
        $user = User::findOrFail($id);
        $user->update($request->all());

        // Redireccionar o enviar una respuesta JSON, según tus necesidades
        return redirect()->route('inicioadmin');
    }

    public function editarUsuarioStaff($id)
{
   
    $usuarioStaff = UsuarioStaff::findOrFail($id);
    // Puedes agregar lógica adicional según tus necesidades antes de devolver la vista
    return view('inicioadmin', compact('usuarioStaff'));
}


public function actualizarUsuarioStaff(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'nombre_archivo_foto' => 'required|string|max:255',
        'correo_institucional' => 'required|email|max:255',
        'celular' => 'required|string|max:15',
        'sir' => 'required|string|max:255',
        'password' => 'nullable|confirmed',
        'permisos_id' => 'required|exists:permissions,id',
        // Otras reglas de validación según tus necesidades
    ]);

    // Actualizar el usuario Staff
    $usuarioStaff = UsuarioStaff::findOrFail($id);
    $usuarioStaff->nombre = $request->nombre;
    $usuarioStaff->nombre_archivo_foto = $request->nombre_archivo_foto;
    $usuarioStaff->correo_institucional = $request->correo_institucional;
    $usuarioStaff->celular = $request->celular;
    $usuarioStaff->sir = $request->sir;
    $usuariosStaff->permisos_id = $request->permisos_id;

    // Actualizar la contraseña solo si se proporciona una nueva
    if ($request->filled('password')) {
        $usuarioStaff->password = bcrypt($request->password);
    }

    $usuarioStaff->permissions_id = $request->permissions_id;
    // Actualiza otros campos según tus necesidades
    $usuarioStaff->save();

    // Puedes agregar un mensaje de éxito o redirigir a otra página
    return redirect()->route('inicioadmin')->with('success', 'Usuario Staff actualizado exitosamente');
}

// Controlador
public function verContactos($id)
{
    $user = Auth::guard('web')->user();
    if ($user->permisos->type === 'limited') {
        // Usuario agente
        $permiso = 'limited';
    } elseif ($user->permisos->type === 'full') {
        // Usuario staff
        $permiso = 'full';
    }

    $contactos = Contacto::where('user_id', $id)->get();

    return view('circuloinf', compact('contactos'), ['permiso' => $permiso]);
    // o
    // return view('circuloinf')->with('contactos', $contactos);
}




public function eliminar($id)
    {
        // Buscar el agente por el ID
        $user = User::find($id);

        // Verificar si el agente existe
        if (!$user) {
            // Puedes manejar la situación en la que el agente no existe, por ejemplo, redirigir a una página de error.
            return redirect()->route('ruta_error_agente_no_encontrado');
        }

        // Realizar la lógica para eliminar el agente
        $user->delete();

        // Redirigir a alguna parte después de la eliminación exitosa
        return redirect()->route('inicioadmin')->with('success', 'Agente eliminado exitosamente');
    }
}



