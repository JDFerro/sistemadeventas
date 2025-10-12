<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresa;



class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedor::all();
        $empresa = Empresa::where('id', Auth::user()->empresa_id)->first();
        return view('admin.proveedores.index', compact('proveedores', 'empresa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empresa' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required|email',
            'nombre' => 'required',
            'celular' => 'required',
        ]);

        $proveedor = new Proveedor();

        $proveedor->empresa = $request->input('empresa');
        $proveedor->direccion = $request->input('direccion');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->email = $request->input('email');
        $proveedor->nombre = $request->input('nombre');
        $proveedor->celular = $request->input('celular');
        $proveedor->empresa_id = Auth::user()->empresa_id;

        $proveedor->save();

        return redirect()->route('admin.proveedores.index')
            ->with('mensaje', 'Proveedor creado exitosamente.')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $proveedor = Proveedor::find($id);
        return view('admin.proveedores.show', compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $proveedor = Proveedor::find($id);
        return view('admin.proveedores.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'empresa'   => 'required',
            'direccion' => 'required',
            'telefono'  => 'required',
            'email'     => 'required|email',
            'nombre'    => 'required',
            'celular'   => 'required',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->empresa   = $request->input('empresa');
        $proveedor->direccion = $request->input('direccion');
        $proveedor->telefono  = $request->input('telefono');
        $proveedor->email     = $request->input('email');
        $proveedor->nombre    = $request->input('nombre');
        $proveedor->celular   = $request->input('celular');
        $proveedor->empresa_id = Auth::user()->empresa_id;
        $proveedor->save();

        return redirect()->route('admin.proveedores.index')
            ->with('mensaje', 'Proveedor modificado exitosamente.')
            ->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Proveedor::destroy($id);
        return redirect()->route('admin.proveedores.index')
            ->with('mensaje', 'Proveedor eliminado exitosamente.')
            ->with('icono', 'success');
    }
}
