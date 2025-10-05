@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1><b>Bienvenido {{ $empresa->nombre_empresa }}</b></h1>
<hr>
@stop

@section('content')

@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
@if(($mensaje = Session::get('mensaje')) && ($icono = Session::get('icono')))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            position: "top-end",
            icon: "{{ $icono }}",
            title: "{{ $mensaje }}",
            showConfirmButton: false,
            timer: 3000
        });
    });
</script>
@endif
@stop