@extends('adminlte::page')

@section('content_header')
    <h1><b>Registro de un nuevo proveedor</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Ingrese los datos</h3>
                
              </div>
              <div class="card-body">
                <form action="{{url ('admin/proveedores/create')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="empresa">Nombre de la empresa</label><b>*</b>
                                <input type="text" class="form-control" value="{{ old('empresa') }}" name="empresa" placeholder="Ingrese el nombre de la empresa" required>
                                @error('empresa')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="direccion">Dirección</label><b>*</b>
                                <input type="text" class="form-control" value="{{ old('direccion') }}" name="direccion" placeholder="Ingrese la dirección" required>
                                @error('direccion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefono">Telefono</label><b>*</b>
                                <input type="text" class="form-control" value="{{ old('telefono') }}" name="telefono" placeholder="Ingrese el telefono" required>
                                @error('telefono')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label><b>*</b>
                                <input type="email" class="form-control" value="{{ old('email') }}" name="email" placeholder="Ingrese el email" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre">Nombre del proveedor</label><b>*</b>
                                <input type="text" class="form-control" value="{{ old('nombre') }}" name="nombre" placeholder="Ingrese el nombre del proveedor" required>
                                @error('nombre')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="celular">Celular del proveedor</label><b>*</b>
                                <input type="text" class="form-control" value="{{ old('celular') }}" name="celular" placeholder="Ingrese el celular del proveedor" required>
                                @error('celular')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{ url ('/admin/proveedores') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>
                            </div>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
    </div>

@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@stop