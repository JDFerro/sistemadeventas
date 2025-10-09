@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><b>Listado de Roles</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Roles registrados</h3>
                <div class="card-tools">
                    <a href="{{url('admin/roles/create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear nuevo</a>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col" style="text-align: center;">Nro</th>
                    <th scope="col">Nombre del rol</th>
                    <th scope="col" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $contador = 1; ?>
                  @foreach($roles as $role)
                    <tr>
                      <td style="text-align: center;">{{$contador++}}</td>
                      <td>{{$role->name}}</td>
                      <td style="text-align: center;">
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <a href="{{ url('/admin/roles/'.$role->id.'/edit') }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                          <a href="{{ url('/admin/roles', $role->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                          <form action="{{url ('/admin/roles', $role->id)}}" method="post" 
                          onclick="preguntar{{$role->id}}(event)" id="miFormulario{{$role->id}}">
                            @csrf
                            @method('DELETE')
                          <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                          </form>
                          <script>
                            function preguntar{{$role->id}}(event){
                              event.preventDefault();
                              Swal.fire({
                                title: '¿Está seguro de eliminar el rol?',
                                text: "",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#5a3a3aff',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                              }).then((result) => {
                                if (result.isConfirmed) {
                                  document.getElementById("miFormulario{{$role->id}}").submit();
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