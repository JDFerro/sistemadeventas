@extends('adminlte::page')

@section('title', 'Configuraciones')

@section('content_header')
<h1>Configuraciones/editar</h1>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-success" style="box-shadow: 5px 5px 5px 5px #cccccc">
            <div class="card-header">
                <h3 class="card-title float-none">
                    <b>Datos Registrados</b>
                </h3>
            </div>

            <div class="card-body">
                @if(session('mensaje'))
                <div class="alert alert-{{ session('icono') }} alert-dismissible fade show" role="alert">
                    {{ session('mensaje') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Cambiar la acción del formulario para enviar a la ruta de update -->
                <form action="{{ url('/admin/configuracion',$empresa->id) }}" method="post" enctype="multipart/form-data" id="empresa-form">
                    @csrf
                    @method('PUT')
                    {{-- si usas PUT, añade @method('PUT') y ajusta la ruta a Route::put --}}
                    <div class="form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="logo">Logo Actual</label>
                                    @if($empresa->logo)
                                    <div class="text-center mb-2">
                                        <!-- Reemplazado: agrego id y data-original-src -->
                                        <img id="current_logo" data-original-src="{{ asset('storage/' . $empresa->logo) }}" src="{{ asset('storage/' . $empresa->logo) }}" width="70%" alt="Logo actual" class="img-thumbnail">
                                    </div>
                                    @endif
                                    <label for="logo">Cambiar Logo</label>
                                    <input type="file" id="file" name="logo" accept=".png, .jpg, .jpeg" class="form-control">
                                    @error('logo')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                    <br>
                                    {{-- preview eliminado para evitar imagen duplicada --}}
                                    {{-- <center><output id="list"></output></center> --}}

                                    <script>
                                        // Reemplazo de la función de preview para que sustituya la imagen actual
                                        function archivo(evt) {
                                            var files = evt.target.files; // FileList object
                                            var current = document.getElementById('current_logo');

                                            // Si no hay archivos seleccionados, restaurar imagen original
                                            if (!files || files.length === 0) {
                                                if (current && current.dataset && current.dataset.originalSrc) {
                                                    current.src = current.dataset.originalSrc;
                                                }
                                                return;
                                            }

                                            // Tomar solo el primer archivo
                                            var f = files[0];
                                            if (!f.type.match('image.*')) {
                                                return;
                                            }

                                            var reader = new FileReader();
                                            reader.onload = function(e) {
                                                // Reemplazar la imagen actual con la preview
                                                if (current) {
                                                    current.src = e.target.result;
                                                }
                                                // ya no se inserta ninguna imagen adicional
                                            };
                                            reader.readAsDataURL(f);
                                        }

                                        // Asegurar que el listener esté solo una vez
                                        var fileInput = document.getElementById('file');
                                        if (fileInput) {
                                            fileInput.removeEventListener('change', archivo);
                                            fileInput.addEventListener('change', archivo, false);
                                        }
                                    </script>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pais">País</label>
                                            <select name="pais" id="select_pais" class="form-control">
                                                <option value="">Seleccione un país</option>
                                                @foreach($paises as $paise)
                                                <option value="{{$paise->id}}" {{ $empresa->pais == $paise->name ? 'selected' : '' }}>{{$paise->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="departamento">Departamento/Provincia/Region</label>
                                            <div id="respuesta_pais">
                                                <select name="departamento" id="select_estado" class="form-control" required>
                                                    <option value="">Seleccione un departamento</option>
                                                    @foreach($estados as $estado)
                                                    <option value="{{$estado->id}}" {{ $empresa->departamento == $estado->name ? 'selected' : '' }}>{{$estado->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('departamento')
                                            <small style="color: red;">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="ciudad">Ciudad</label>
                                            <div id="respuesta_estado">
                                                <select name="ciudad" id="select_ciudad" class="form-control">
                                                    <option value="">Seleccione una ciudad</option>
                                                    @foreach($ciudades as $ciudad)
                                                    <option value="{{$ciudad->name}}" {{ $empresa->ciudad == $ciudad->name ? 'selected' : '' }}>{{$ciudad->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nombre_empresa">Nombre de Empresa</label>
                                            <input type="text" value="{{$empresa->nombre_empresa}}" name="nombre_empresa" class="form-control" required>
                                            @error('nombre_empresa')
                                            <small style="color: red;">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipo_empresa">Tipo de Empresa</label>
                                            <input type="text" value="{{ $empresa->tipo_empresa }}" name="tipo_empresa" class="form-control" required>
                                            @error('tipo_empresa')
                                            <small style="color: red;">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nit">NIT</label>
                                            <input type="text" value="{{ $empresa->nit }}" name="nit" class="form-control" required>
                                            @error('nit')
                                            <small style="color: red;">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="moneda">Moneda</label>
                                            <select name="moneda" class="form-control" required>
                                                @foreach($monedas as $moneda)
                                                <option value="{{$moneda->symbol}}" {{ $empresa->moneda == $moneda->symbol ? 'selected' : '' }}>{{$moneda->symbol}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nombre_impuesto">Nombre del Impuesto</label>
                                            <input type="text" value="{{ $empresa->nombre_impuesto }}" name="nombre_impuesto" class="form-control" required>
                                            @error('nombre_impuesto')
                                            <small style="color: red;">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cantidad_impuestos">Cantidad de Impuestos</label>
                                            <input type="number" value="{{ $empresa->cantidad_impuesto }}" name="cantidad_impuestos" class="form-control" required>
                                            @error('cantidad_impuestos')
                                            <small style="color: red;">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="codigo_postal">Codigo Postal</label>
                                            <select name="codigo_postal" class="form-control" required>
                                                @foreach($paises as $paise)
                                                <option value="{{$paise->phone_code}}" {{ $empresa->codigo_postal == $paise->phone_code ? 'selected' : '' }}>{{$paise->phone_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="telefono">Teléfonos de la Empresa</label>
                                            <input type="text" value="{{ $empresa->telefono }}" name="telefono" class="form-control" required>
                                            @error('telefono')
                                            <small style="color: red;">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="correo">Correo de la Empresa</label>
                                            <input type="email" value="{{ $empresa->correo }}" name="correo" class="form-control" required>
                                            @error('correo')
                                            <small style="color: red;">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="map_search">Buscar Dirección en Mapa</label>
                                            <input type="text" id="map_search" value="{{ $empresa->direccion }}" name="direccion" class="form-control" required>
                                            @error('direccion')
                                            <small style="color: red;">{{ $message }}</small>
                                            @enderror
                                            <input type="hidden" name="latitud" id="latitud">
                                            <input type="hidden" name="longitud" id="longitud">
                                            <br>
                                            {{-- <div id="map" style="width: 100%; height: 400px; border: 1px solid #ccc; border-radius: 5px;"></div> --}}
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-lg btn-success btn-block">Actualizar empresa</button>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('admin.index') }}" class="btn btn-lg btn-secondary btn-block">Cancelar</a>
                                    </div>
                                </div>
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
@stack('js')
@yield('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Cargar estados al cambiar país
        $('#select_pais').on('change', function() {
            var id_pais = $(this).val();
            if (id_pais) {
                $.ajax({
                    url: "{{ url('/crear-empresa') }}" + '/' + id_pais,
                    type: "GET",
                    beforeSend: function() {
                        $('#respuesta_pais').html('<select name="departamento" class="form-control" required><option>Cargando estados...</option></select>');
                    },
                    success: function(data) {
                        $('#respuesta_pais').html(data);
                        // limpiar ciudades
                        $('#respuesta_estado').html('<select name="ciudad" class="form-control" required><option>Primero seleccione un departamento</option></select>');
                    },
                    error: function() {
                        $('#respuesta_pais').html('<select name="departamento" class="form-control" required><option>Error al cargar estados</option></select>');
                    }
                });
            } else {
                $('#respuesta_pais').html('<select name="departamento" class="form-control" required><option value="">Seleccione un departamento</option></select>');
                $('#respuesta_estado').html('<select name="ciudad" class="form-control" required><option value="">Seleccione una ciudad</option></select>');
            }
        });

        // Cargar ciudades al cambiar estado/departamento (delegado porque select_estado se reemplaza)
        $(document).on('change', '#select_estado', function() {
            var id_estado = $(this).val();
            if (id_estado) {
                $.ajax({
                    url: "{{ url('/buscar-ciudades') }}" + '/' + id_estado,
                    type: "GET",
                    beforeSend: function() {
                        $('#respuesta_estado').html('<select name="ciudad" class="form-control" required><option>Cargando ciudades...</option></select>');
                    },
                    success: function(data) {
                        $('#respuesta_estado').html(data);
                    },
                    error: function() {
                        $('#respuesta_estado').html('<select name="ciudad" class="form-control" required><option>Error al cargar ciudades</option></select>');
                    }
                });
            } else {
                $('#respuesta_estado').html('<select name="ciudad" class="form-control" required><option value="">Seleccione una ciudad</option></select>');
            }
        });
    });
</script>
@stop