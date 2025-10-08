@extends('adminlte::page')

@section('content_header')
    <h1><b>Registro de una categoría</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Ingrese los datos</h3>
                
              </div>
              <div class="card-body">
                <form action="{{url ('admin/categorias/create')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Nombre de la categoría</label>
                                <input type="text" class="form-control" value="{{ old('nombre') }}" id="nombre" name="nombre" placeholder="Ingrese el nombre de la categoría" required>
                                @error('nombre')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <input type="text" class="form-control" value="{{ old('descripcion') }}" id="descripcion" name="descripcion" placeholder="Ingrese la descripción" required>
                                @error('descripcion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url ('admin/categorias')}}" class="btn btn-secondary">Regresar</a>
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