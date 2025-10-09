@extends('adminlte::page')

@section('content_header')
    <h1><b>Listado de Usuarios</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Usuarios registrados</h3>
                <div class="card-tools">
                    <a href="{{url('admin/usuarios/create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear nuevo</a>
                </div>
              </div>
              <div class="card-body">
                <table id="mitabla" class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col" style="text-align: center;">Nro</th>
                    <th scope="col">Rol del usuario</th>
                    <th scope="col">Nombre del usuario</th>
                    <th scope="col">Email</th>
                    <th scope="col" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $contador = 1; ?>
                  @foreach($usuarios as $usuario)
                    <tr>
                      <td style="text-align: center;">{{$contador++}}</td>
                      <td>{{$usuario->roles->pluck('name')->implode(', ')}}</td>
                      <td>{{$usuario->name}}</td>
                      <td>{{$usuario->email}}</td>
                      <td style="text-align: center;">
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <a href="{{ url('/admin/usuarios/'.$usuario->id.'/edit') }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                          <a href="{{ url('/admin/usuarios', $usuario->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                          <form action="{{url ('/admin/usuarios', $usuario->id)}}" method="post" 
                          onclick="preguntar{{$usuario->id}}(event)" id="miFormulario{{$usuario->id}}">
                            @csrf
                            @method('DELETE')
                          <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                          </form>
                          <script>
                            function preguntar{{$usuario->id}}(event){
                              event.preventDefault();
                              Swal.fire({
                                title: '¿Está seguro de eliminar el usuario?',
                                text: "",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#5a3a3aff',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                              }).then((result) => {
                                if (result.isConfirmed) {
                                  document.getElementById("miFormulario{{$usuario->id}}").submit();
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
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Usuarios",
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