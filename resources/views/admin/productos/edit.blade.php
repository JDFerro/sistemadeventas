@extends('adminlte::page')

@section('content_header')
    <h1><b>Modificar un producto</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
              <div class="card-header">
                <h3 class="card-title">Modificar producto</h3>
                
              </div>
              <div class="card-body">
                <form action="{{url ('/admin/productos',$producto->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Categoria</label>
                                        <select name="categoria_id" id="" class="form-control">
                                            @foreach($categorias as $categoria)
                                                <option value="{{ $categoria->id }}" {{ $categoria->id == $producto->categoria_id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="codigo">Codigo</label>
                                        <input type="text" class="form-control" value="{{ $producto->codigo }}" id="codigo" name="codigo" placeholder="Ingrese el código" required>
                                        @error('codigo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre">Nombre del producto</label>
                                        <input type="text" class="form-control" value="{{ $producto->nombre }}" id="nombre" name="nombre" placeholder="Ingrese el nombre del producto" required>
                                        @error('nombre')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion</label>
                                        <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese la descripcion">{{ $producto->descripcion }}</textarea>
                                        @error('descripcion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock">Stock</label>
                                        <input type="number" class="form-control" value="{{ $producto->stock }}" id="stock" name="stock" placeholder="Ingrese el stock" required>
                                        @error('stock')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock_minimo">Stock Minimo</label>
                                        <input type="number" class="form-control" value="{{ $producto->stock_minimo }}" id="stock_minimo" name="stock_minimo" placeholder="Ingrese el stock minimo" required>
                                        @error('stock_minimo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock_maximo">Stock Maximo</label>
                                        <input type="number" class="form-control" value="{{ $producto->stock_maximo }}" id="stock_maximo" name="stock_maximo" placeholder="Ingrese el stock maximo" required>
                                        @error('stock_maximo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="precio_compra">Precio Compra</label>
                                        <input type="text" class="form-control" value="{{ $producto->precio_compra }}" id="precio_compra" name="precio_compra" placeholder="Ingrese el precio de compra" required>
                                        @error('precio_compra')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="precio_venta">Precio Venta</label>
                                        <input type="text" class="form-control" value="{{ $producto->precio_venta }}" id="precio_venta" name="precio_venta" placeholder="Ingrese el precio de venta" required>
                                        @error('precio_venta')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="fecha_ingreso">Fecha Ingreso</label>
                                        <input type="date" class="form-control" value="{{ $producto->fecha_ingreso }}" id="fecha_ingreso" name="fecha_ingreso" placeholder="Ingrese la fecha de ingreso" required>
                                        @error('fecha_ingreso')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                        <label for="logo">Imagen</label>
                                        <input type="file" id="file" name="imagen" accept=".png, .jpg, .jpeg" class="form-control">
                                        @error('logo')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                        <br>
                                        <center><output id="list"><img src="{{ asset('storage/' . $producto->imagen) }}" width="200px" alt="imagen"></output></center>

                                        <script>
                                            function archivo(evt) {
                                                var files = evt.target.files; // FileList object
                                                // Obtenemos la imagen del campo "file".
                                                for (var i = 0, f; f = files[i]; i++) {
                                                    // Solo admitimos imágenes.
                                                    if (!f.type.match('image.*')) {
                                                        continue;
                                                    }
                                                    var reader = new FileReader();
                                                    reader.onload = (function(theFile) {
                                                        return function(e) {
                                                            // Insertamos la imagen
                                                            document.getElementById('list').innerHTML = ['<img class="thumb thumbnail" src="', e.target.result,
                                                                '" width="70%" title="', escape(theFile.name), '"/>'
                                                            ].join('');
                                                        };
                                                    })(f);
                                                    reader.readAsDataURL(f);
                                                }
                                            }

                                            document.getElementById('file').addEventListener('change', archivo, false);
                                        </script>
                                    </div>
                        </div>
                    </div>

                    
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url ('admin/productos')}}" class="btn btn-secondary">Regresar</a>
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