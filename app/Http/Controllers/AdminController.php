<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;


class AdminController extends Controller
{
    public function index()
    {
        $total_roles = Role::count();
        $total_usuarios = User::count();
        $total_categorias = Categoria::count();
        $total_productos = Producto::count();


        $empresa_id = Auth::check() ? Auth::user()->empresa_id : redirect()->route('login')->send();

        $empresa = Empresa::where('id', $empresa_id)->first();
        return view('admin.index', compact('empresa', 'total_roles', 'total_usuarios', 'total_categorias', 'total_productos'));
    }
}
