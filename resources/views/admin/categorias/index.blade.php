@extends('adminlte::page')

@section('content_header')
    <h1><b>Listado de categorias</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Categorias registradas</h3>
                <div class="card-tools">
                    <a href="{{url('admin/categorias/create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear nuevo</a>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col" style="text-align: center;">Nro</th>
                    <th scope="col">Nombre de la categoria</th>
                    <th scope="col">Descripción</th>
                    <th scope="col" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $contador = 1; ?>
                  @foreach($categorias as $categoria)
                    <tr>
                      <td style="text-align: center;">{{$contador++}}</td>
                      <td>{{$categoria->nombre}}</td>
                      <td>{{$categoria->descripcion}}</td>
                      <td style="text-align: center;">
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <a href="{{ url('/admin/categorias/'.$categoria->id.'/edit') }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                          <a href="{{ url('/admin/categorias', $categoria->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                          <form action="{{url ('/admin/categorias', $categoria->id)}}" method="post" 
                          onclick="preguntar{{$categoria->id}}(event)" id="miFormulario{{$categoria->id}}">
                            @csrf
                            @method('DELETE')
                          <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                          </form>
                          <script>
                            function preguntar{{$categoria->id}}(event){
                              event.preventDefault();
                              Swal.fire({
                                title: '¿Está seguro de eliminar la categoría?',
                                text: "",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                              }).then((result) => {
                                if (result.isConfirmed) {
                                  document.getElementById("miFormulario{{$categoria->id}}").submit();
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

@stop