@extends('adminlte::page')

@section('content_header')
    <h1><b>Datos de los productos</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
              <div class="card-header">
                <h3 class="card-title">Datos registrados</h3>
                
              </div>
              <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Categoria</label>
                                        <p>{{$producto->categoria->nombre}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="codigo">Codigo</label>
                                        <p>{{$producto->codigo}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre">Nombre del producto</label>
                                        <p>{{$producto->nombre}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion</label>
                                        <p>{{$producto->descripcion}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock">Stock</label>
                                        <p>{{$producto->stock}}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock_minimo">Stock Minimo</label>
                                        <p>{{$producto->stock_minimo}}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock_maximo">Stock Maximo</label>
                                        <p>{{$producto->stock_maximo}}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="precio_compra">Precio Compra</label>
                                        <p>{{$producto->precio_compra}}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="precio_venta">Precio Venta</label>
                                        <p>{{$producto->precio_venta}}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="fecha_ingreso">Fecha Ingreso</label>
                                        <p>{{$producto->fecha_ingreso}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                        <label for="logo">Imagen</label><br>
                                        <img src="{{ asset('storage/' . $producto->imagen) }}" width="200px" alt="imagen">
                            </div>
                        </div>
                    </div>

                    
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url ('admin/productos')}}" class="btn btn-secondary">Regresar</a>
                            </div>
                        </div>
                    </div>
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