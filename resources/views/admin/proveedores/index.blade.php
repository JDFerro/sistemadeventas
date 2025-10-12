@extends('adminlte::page')

@section('content_header')
    <h1><b>Listado de proveedores</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Proveedores registrados</h3>
                <div class="card-tools">
                    <a href="{{url('admin/proveedores/create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear nuevo</a>
                </div>
              </div>
              <div class="card-body">
                <table id="mitabla" class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col" style="text-align: center;">Nro</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Direccion</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Email</th>
                    <th scope="col">Nombre del proveedor</th>
                    <th scope="col">Celular del proveedor</th>
                    <th scope="col" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $contador = 1; ?>
                  @foreach($proveedores as $proveedor)
                    <tr>
                      <td style="text-align: center;">{{$contador++}}</td>
                      <td>{{$proveedor->empresa}}</td>
                      <td>{{$proveedor->direccion}}</td>
                      <td>{{$proveedor->telefono}}</td>
                      <td>{{$proveedor->email}}</td>
                      <td>{{$proveedor->nombre}}</td>
                      <td>
                        <a href="https://wa.me/{{$empresa->codigo_postal."".$proveedor->celular}}"
                        class="btn btn-success" target="_blank"><i class="fab fa-whatsapp"></i>
                          {{$empresa->codigo_postal."".$proveedor->celular}}</a>
                      </td>
                      <td style="text-align: center;">
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <a href="{{ url('/admin/proveedores/'.$proveedor->id.'/edit') }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                          <a href="{{ url('/admin/proveedores', $proveedor->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                          <form action="{{url ('/admin/proveedores', $proveedor->id)}}" method="post" 
                          onclick="preguntar{{$proveedor->id}}(event)" id="miFormulario{{$proveedor->id}}">
                            @csrf
                            @method('DELETE')
                          <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                          </form>
                          <script>
                            function preguntar{{$proveedor->id}}(event){
                              event.preventDefault();
                              Swal.fire({
                                title: '¿Está seguro de eliminar el proveedor?',
                                text: "",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#5a3a3aff',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                              }).then((result) => {
                                if (result.isConfirmed) {
                                  document.getElementById("miFormulario{{$proveedor->id}}").submit();
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
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Proveedores",
                "infoEmpty": "Mostrando 0 a 0 de 0 Proveedores",
                "infoFiltered": "(Filtrado de _MAX_ total Proveedores)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Proveedores",
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