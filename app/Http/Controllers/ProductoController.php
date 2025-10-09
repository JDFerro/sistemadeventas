<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$datos = request()->all();
        //return response()->json($datos);
        $request->validate([
            'codigo' => 'required|unique:productos,codigo',
            'nombre' => 'required',
            'descripcion' => 'required',
            'stock' => 'required',
            'stock_minimo' => 'required',
            'stock_maximo' => 'required',
            'precio_compra' => 'required',
            'precio_venta' => 'required',
            'fecha_ingreso' => 'required',
        ]);

        $producto = new Producto();

        $producto->codigo = $request->input('codigo');
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->stock = $request->input('stock');
        $producto->stock_minimo = $request->input('stock_minimo');
        $producto->stock_maximo = $request->input('stock_maximo');
        $producto->precio_compra = $request->input('precio_compra');
        $producto->precio_venta = $request->input('precio_venta');
        $producto->fecha_ingreso = $request->input('fecha_ingreso');
        $producto->categoria_id = $request->input('categoria_id');
        $producto->empresa_id = Auth::user()->empresa_id;

        if ($request->hasFile('imagen')) {
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();

        return redirect()->route('admin.productos.index')
            ->with('mensaje', 'Producto creado exitosamente.')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $producto = Producto::find($id);
        return view('admin.productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $producto = Producto::find($id);
        $categorias = Categoria::all();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required|unique:productos,codigo,' . $id,
            'nombre' => 'required',
            'descripcion' => 'required',
            'stock' => 'required',
            'stock_minimo' => 'required',
            'stock_maximo' => 'required',
            'precio_compra' => 'required',
            'precio_venta' => 'required',
            'fecha_ingreso' => 'required',
        ]);

        $producto = Producto::find($id);

        $producto->codigo = $request->input('codigo');
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->stock = $request->input('stock');
        $producto->stock_minimo = $request->input('stock_minimo');
        $producto->stock_maximo = $request->input('stock_maximo');
        $producto->precio_compra = $request->input('precio_compra');
        $producto->precio_venta = $request->input('precio_venta');
        $producto->fecha_ingreso = $request->input('fecha_ingreso');
        $producto->categoria_id = $request->input('categoria_id');
        $producto->empresa_id = Auth::user()->empresa_id;

        if ($request->hasFile('imagen')) {
            // borrar imagen anterior si existe usando el disco 'public'
            if (!empty($producto->imagen)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($producto->imagen);
            }
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();

        return redirect()->route('admin.productos.index')
            ->with('mensaje', 'Producto modificado exitosamente.')
            ->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = \App\Models\Producto::findOrFail($id);

        // eliminar la imagen física si existe
        if (!empty($producto->imagen)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($producto->imagen);
        }

        // eliminar el registro
        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('mensaje', 'Producto eliminado exitosamente.')
            ->with('icono', 'success');
    }
}
