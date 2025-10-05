<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paises = DB::table('countries')->get();
        $estados = DB::table('states')->get();
        $ciudades = DB::table('cities')->get();
        $monedas = DB::table('currencies')->get();

        return view('admin.empresas.create', compact('paises', 'estados', 'ciudades', 'monedas'));
    }

    public function buscar_pais($id_pais)
    {
        try {
            $estados = DB::table('states')->where('country_id', $id_pais)->get();

            // Debug para verificar si hay estados
            if ($estados->isEmpty()) {
                return response('<p>No se encontraron estados para este país</p>');
            }

            return view('admin.empresas.cargar_estados', compact('estados'));
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error: ' . $exception->getMessage()]);
        }
    }

    public function buscar_ciudades($id_estado)
    {
        try {
            $ciudades = DB::table('cities')->where('state_id', $id_estado)->get();

            // Debug para verificar si hay ciudades
            if ($ciudades->isEmpty()) {
                return response('<select name="ciudad" class="form-control"><option value="">No se encontraron ciudades para este estado</option></select>');
            }

            return view('admin.empresas.cargar_ciudades', compact('ciudades'));
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error: ' . $exception->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Debug: Ver todos los datos recibidos
            \Log::info('Datos recibidos:', $request->all());

            $request->validate([
                'pais' => 'required|string|max:255',
                'nombre_empresa' => 'required|string|max:255',
                'tipo_empresa' => 'required|string|max:255',
                'nit' => 'required|string|max:255|unique:empresas,nit',
                'telefono' => 'required|string|max:20',
                'correo' => 'required|email|max:255|unique:empresas,correo|unique:users,email',
                'cantidad_impuestos' => 'required|integer|min:0',
                'nombre_impuesto' => 'required|string|max:255',
                'moneda' => 'required|string|max:10',
                'direccion' => 'required|string|max:500',
                'ciudad' => 'required|string|max:255',
                'departamento' => 'required|string|max:255',
                'codigo_postal' => 'required|string|max:20',
                'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Obtener nombres en lugar de IDs para guardar en la base de datos
            $nombre_pais = DB::table('countries')->where('id', $request->input('pais'))->value('name');
            $nombre_departamento = DB::table('states')->where('id', $request->input('departamento'))->value('name');

            // Manejo del archivo de logo
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }

            $empresa = new Empresa();
            $empresa->pais = $nombre_pais;
            $empresa->nombre_empresa = $request->input('nombre_empresa');
            $empresa->tipo_empresa = $request->input('tipo_empresa');
            $empresa->nit = $request->input('nit');
            $empresa->telefono = $request->input('telefono');
            $empresa->correo = $request->input('correo');
            $empresa->cantidad_impuesto = $request->input('cantidad_impuestos');
            $empresa->nombre_impuesto = $request->input('nombre_impuesto');
            $empresa->moneda = $request->input('moneda');
            $empresa->direccion = $request->input('direccion');
            $empresa->ciudad = $request->input('ciudad');
            $empresa->departamento = $nombre_departamento;
            $empresa->codigo_postal = $request->input('codigo_postal');
            $empresa->logo = $logoPath;
            $empresa->save();

            \Log::info('Empresa guardada exitosamente con ID: ' . $empresa->id);

            // Crear usuario para la empresa
            $usuario = new User();
            $usuario->name = "Admin";
            $usuario->email = $request->input('correo');
            $usuario->password = Hash::make($request->input('nit'));
            $usuario->empresa_id = $empresa->id;
            $usuario->save();

            Auth::login($usuario); // Iniciar sesión automáticamente

            \Log::info('Usuario creado exitosamente con ID: ' . $usuario->id);

            return redirect()->route('admin.index')->with('mensaje', 'Empresa y usuario creados correctamente')
                ->with('icono', 'success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación:', $e->errors());
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Error al guardar empresa: ' . $e->getMessage());
            return redirect()->back()->with('mensaje', 'Error al guardar la empresa: ' . $e->getMessage())
                ->with('icono', 'error')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource and handle update when POST.
     */
    public function edit(Request $request)
    {
        $empresa_id = Auth::user()->empresa_id;
        $empresa = Empresa::where('id', $empresa_id)->first();

        // Mostrar formulario (GET)
        if (! $request->isMethod('post')) {
            $paises = DB::table('countries')->get();
            $estados = DB::table('states')->get();
            $ciudades = DB::table('cities')->get();
            $monedas = DB::table('currencies')->get();

            return view('admin.configuraciones.edit', compact('empresa', 'paises', 'estados', 'ciudades', 'monedas'));
        }

        // Procesar actualización (POST)
        $user = User::where('empresa_id', $empresa->id)->first();

        $request->validate([
            'pais' => 'required|integer',
            'nombre_empresa' => 'required|string|max:255',
            'tipo_empresa' => 'required|string|max:255',
            'nit' => ['required', 'string', 'max:255', Rule::unique('empresas', 'nit')->ignore($empresa->id)],
            'telefono' => 'required|string|max:20',
            'correo' => [
                'required',
                'email',
                'max:255',
                Rule::unique('empresas', 'correo')->ignore($empresa->id),
                $user ? Rule::unique('users', 'email')->ignore($user->id) : 'unique:users,email'
            ],
            'cantidad_impuestos' => 'required|integer|min:0',
            'nombre_impuesto' => 'required|string|max:255',
            'moneda' => 'required|string|max:10',
            'direccion' => 'required|string|max:500',
            'ciudad' => 'required|string|max:255',
            'departamento' => 'required|integer',
            'codigo_postal' => 'required|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Convertir IDs a nombres (igual que store)
        $nombre_pais = DB::table('countries')->where('id', $request->input('pais'))->value('name');
        $nombre_departamento = DB::table('states')->where('id', $request->input('departamento'))->value('name');

        // Manejo del logo si se sube
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $empresa->logo = $logoPath;
        }

        $empresa->pais = $nombre_pais;
        $empresa->nombre_empresa = $request->input('nombre_empresa');
        $empresa->tipo_empresa = $request->input('tipo_empresa');
        $empresa->nit = $request->input('nit');
        $empresa->telefono = $request->input('telefono');
        $empresa->correo = $request->input('correo');
        $empresa->cantidad_impuesto = $request->input('cantidad_impuestos');
        $empresa->nombre_impuesto = $request->input('nombre_impuesto');
        $empresa->moneda = $request->input('moneda');
        $empresa->direccion = $request->input('direccion');
        $empresa->ciudad = $request->input('ciudad');
        $empresa->departamento = $nombre_departamento;
        $empresa->codigo_postal = $request->input('codigo_postal');

        $empresa->save();

        // Actualizar usuario relacionado (email)
        if ($user) {
            $user->email = $request->input('correo');
            $user->save();
        }

        // Redirigir al panel admin con mensaje de éxito
        return redirect()->route('admin.index')
            ->with('mensaje', 'Empresa actualizada correctamente')
            ->with('icono', 'success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $empresa = Empresa::findOrFail($id);
            $user = User::where('empresa_id', $empresa->id)->first();

            // Reglas de correo dinámicas (permitir el valor actual)
            $correoRules = ['required', 'email', 'max:255', Rule::unique('empresas', 'correo')->ignore($empresa->id)];
            if ($user) {
                $correoRules[] = Rule::unique('users', 'email')->ignore($user->id);
            } else {
                $correoRules[] = 'unique:users,email';
            }

            $request->validate([
                'pais' => 'required|integer',
                'departamento' => 'required|integer',
                'ciudad' => 'required|string|max:255',
                'nombre_empresa' => 'required|string|max:255',
                'tipo_empresa' => 'required|string|max:255',
                'nit' => ['required', 'string', 'max:255', Rule::unique('empresas', 'nit')->ignore($empresa->id)],
                'telefono' => 'required|string|max:20',
                'correo' => $correoRules,
                'cantidad_impuestos' => 'required|integer|min:0',
                'nombre_impuesto' => 'required|string|max:255',
                'moneda' => 'required|string|max:10',
                'direccion' => 'required|string|max:500',
                'codigo_postal' => 'required|string|max:20',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            DB::beginTransaction();

            // Convertir IDs a nombres (igual que en store)
            $nombre_pais = DB::table('countries')->where('id', $request->input('pais'))->value('name');
            $nombre_departamento = DB::table('states')->where('id', $request->input('departamento'))->value('name');

            // Manejo del logo (si se sube, sobrescribe la ruta)
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
                $empresa->logo = $logoPath;
            }

            // Actualizar campos
            $empresa->pais = $nombre_pais;
            $empresa->nombre_empresa = $request->input('nombre_empresa');
            $empresa->tipo_empresa = $request->input('tipo_empresa');
            $empresa->nit = $request->input('nit');
            $empresa->telefono = $request->input('telefono');
            $empresa->correo = $request->input('correo');
            $empresa->cantidad_impuesto = $request->input('cantidad_impuestos');
            $empresa->nombre_impuesto = $request->input('nombre_impuesto');
            $empresa->moneda = $request->input('moneda');
            $empresa->direccion = $request->input('direccion');
            $empresa->ciudad = $request->input('ciudad');
            $empresa->departamento = $nombre_departamento;
            $empresa->codigo_postal = $request->input('codigo_postal');

            $empresa->save();

            // Actualizar usuario asociado si existe
            if ($user) {
                $user->email = $request->input('correo');
                $user->save();
            }

            DB::commit();

            return redirect()->route('admin.index')->with('mensaje', 'Empresa actualizada correctamente')->with('icono', 'success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al actualizar empresa: ' . $e->getMessage());
            return redirect()->back()->with('mensaje', 'Error al actualizar la empresa: ' . $e->getMessage())
                ->with('icono', 'error')->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        //
    }
}
