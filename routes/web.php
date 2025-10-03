<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware('auth');

Route::get('/crear-empresa', [App\Http\Controllers\EmpresaController::class, 'create'])->name('admin.empresa.create');
Route::post('/crear-empresa/create', [App\Http\Controllers\EmpresaController::class, 'store'])->name('admin.empresa.store');
Route::get('/crear-empresa/{id_pais}', [App\Http\Controllers\EmpresaController::class, 'buscar_pais'])->name('admin.empresa.create.buscar_pais');
Route::get('/buscar-ciudades/{id_estado}', [App\Http\Controllers\EmpresaController::class, 'buscar_ciudades'])->name('admin.empresa.buscar_ciudades');
