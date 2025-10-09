@extends('adminlte::page')

@section('content_header')
    <h1><b>Listado de productos</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Productos registrados</h3>
                <div class="card-tools">
                    <a href="{{url('admin/productos/create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear nuevo</a>
                </div>
              </div>
              <div class="card-body">
                <table id="mitabla" class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col" style="text-align: center;">Nro</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Codigo</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Precio de compra</th>
                    <th scope="col">Precio de venta</th>
                    <th scope="col">Imagen</th>
                    <th scope="col" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $contador = 1; ?>
                  @foreach($productos as $producto)
                    <tr>
                      <td style="text-align: center;">{{$contador++}}</td>
                    <td>{{$producto->categoria->nombre}}</td>
                      <td>{{$producto->codigo}}</td>
                      <td>{{$producto->nombre}}</td>
                      <td>{{$producto->descripcion}}</td>
                      <td style="text-align: center;">{{$producto->stock}}</td>
                      <td style="text-align: center;">{{$producto->precio_compra}}</td>
                      <td style="text-align: center;">{{$producto->precio_venta}}</td>
                      <td style="text-align: center;">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen del producto" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <span>No hay imagen</span>
                        @endif
                      </td>
                      <td style="text-align: center;">
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <a href="{{ url('/admin/productos/'.$producto->id.'/edit') }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                          <a href="{{ url('/admin/productos', $producto->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                          <form action="{{url ('/admin/productos', $producto->id)}}" method="post" 
                          onclick="preguntar{{$producto->id}}(event)" id="miFormulario{{$producto->id}}">
                            @csrf
                            @method('DELETE')
                          <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                          </form>
                          <script>
                            function preguntar{{$producto->id}}(event){
                              event.preventDefault();
                              Swal.fire({
                                title: '¿Está seguro de eliminar el producto?',
                                text: "",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#5a3a3aff',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                              }).then((result) => {
                                if (result.isConfirmed) {
                                  document.getElementById("miFormulario{{$producto->id}}").submit();
                                }
                              })
                            }
                          </script>
                        </div>
                        </td>
                    </tr>
                  @endforeach
                    
                </tbody>
                </table>
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

<script>
    $('#mitabla').DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
                "infoFiltered": "(Filtrado de _MAX_ total Productos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Productos",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                
            }
        },
    });

</script>
@stop