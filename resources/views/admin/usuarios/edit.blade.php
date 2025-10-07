@extends('adminlte::page')

@section('content_header')
    <h1><b>Modificar datos de Usuarios</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-success">
              <div class="card-header">
                <h3 class="card-title">Ingrese los datos</h3>
                
              </div>
              <div class="card-body">
                <form action="{{url ('/admin/usuarios', $usuario->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Nombre del rol</label>
                                <select name="role" id="" class="form-control">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{$role->name == $usuario->roles->pluck('name')->implode(', ') ? 'selected' : ''}}>{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Nombre del usuario</label>
                                <input type="text" class="form-control" value="{{ $usuario->name }}" id="name" name="name" placeholder="Ingrese el nombre del rol" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" value="{{ $usuario->email }}" id="email" name="email" placeholder="Ingrese el email" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" value="{{ old('password') }}" name="password" placeholder="Ingrese la contraseña" >
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password_confirmation">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="password_confirmation" value="{{ old('password_confirmation') }}" name="password_confirmation" placeholder="Confirme la contraseña" >
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url ('/admin/usuarios')}}" class="btn btn-secondary">Regresar</a>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Modificar</button>
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