<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;


class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener empresa_id del usuario autenticado
        $empresa_id = Auth::user()->empresa_id;

        $usuarios = User::where('empresa_id', $empresa_id)->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view ('admin.usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required'
        ]);

        // Obtener empresa_id del usuario autenticado
        $empresa_id = Auth::user()->empresa_id;

        $usuario = new User();
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->password = bcrypt($request->input('password'));
        $usuario->empresa_id = $empresa_id; // Asignar empresa_id
        $usuario->save();

        // Asignar rol al usuario
        $usuario->assignRole($request->role);

        return redirect()->route('admin.usuarios.index')
            ->with('mensaje', 'Usuario creado exitosamente.')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $usuario = User::find($id);
        return view('admin.usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = User::find($id);
        $roles = Role::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {


       // $datos = request()->all();
       // return response()->json($datos);
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
        ]);

        $usuario = User::find($id);

        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        if($request->filled('password')){
            $usuario->password = Hash::make($request->password);
        }

        $usuario->empresa_id = Auth::user()->empresa_id; // Asegurar que el empresa_id no cambie
        $usuario->save();

        $usuario->syncRoles($request->role);

        return redirect()->route('admin.usuarios.index')
            ->with('mensaje', 'Usuario modificado exitosamente.')
            ->with('icono', 'success');

            

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
