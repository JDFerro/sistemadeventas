@extends('adminlte::master')

@php
$authType = $authType ?? 'login';
$dashboardUrl = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home');

if (config('adminlte.use_route_url', false)) {
$dashboardUrl = $dashboardUrl ? route($dashboardUrl) : '';
} else {
$dashboardUrl = $dashboardUrl ? url($dashboardUrl) : '';
}

$bodyClasses = "{$authType}-page";

if (! empty(config('adminlte.layout_dark_mode', null))) {
$bodyClasses .= ' dark-mode';
}
@endphp

@section('adminlte_css')
@stack('css')
@yield('css')
@stop

@section('classes_body'){{ $bodyClasses }}@stop

@section('body')
<div class="container">


    <br>
    <center>
        <img src="{{asset('/images/logo.png')}}" width="250px" alt="">
    </center>

    <br>

    <div class="row">
        <div class="col-md-12">
            {{-- Card Box --}}
            <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}"
                style="box-shadow: 5px 5px 5px 5px #cccccc">


                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                    <h3 class="card-title float-none text-center">
                        <b>Registro de una nueva empresa</b>
                    </h3>
                </div>


                {{-- Card Body --}}
                <div class="card-body {{ $authType }}-card-body {{ config('adminlte.classes_auth_body', '') }}">

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

                    <form action="{{url('crear-empresa/create')}}" method="post" enctype="multipart/form-data" id="empresa-form">
                        @csrf
                        <div class="form">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="logo">Logo</label>
                                        <input type="file" id="file" name="logo" accept=".png, .jpg, .jpeg" class="form-control" required>
                                        @error('logo')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                        <br>
                                        <center><output id="list"></output></center>

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
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pais">País</label>
                                                <select name="pais" id="select_pais" class="form-control">
                                                    <option value="">Seleccione un país</option>
                                                    @foreach($paises as $paise)
                                                    <option value="{{$paise->id}}">{{$paise->name}}</option>
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
                                                        <option value="">Primero seleccione un departamento</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre_empresa">Nombre de Empresa</label>
                                                <input type="text" value="{{old('nombre_empresa')}}" name="nombre_empresa" class="form-control" placeholder="Nombre de la empresa" required>
                                                @error('nombre_empresa')
                                                <small style="color: red;">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tipo_empresa">Tipo de Empresa</label>
                                                <input type="text" value="{{old('tipo_empresa')}}" name="tipo_empresa" class="form-control" placeholder="Tipo de empresa" required>
                                                @error('tipo_empresa')
                                                <small style="color: red;">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nit">NIT</label>
                                                <input type="text" value="{{old('nit')}}" name="nit" class="form-control" placeholder="NIT de la empresa" required>
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
                                                <select name="moneda" value="{{old('moneda')}}" id="" class="form-control" required>
                                                    @foreach($monedas as $moneda)
                                                    <option value="{{$moneda->symbol}}">{{$moneda->symbol}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre_impuesto">Nombre del Impuesto</label>
                                                <input type="text" value="{{old('nombre_impuesto')}}" name="nombre_impuesto" class="form-control" placeholder="Nombre del impuesto" required>
                                                @error('nombre_impuesto')
                                                <small style="color: red;">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cantidad_impuestos">Cantidad de Impuestos</label>
                                                <input type="number" value="{{old('cantidad_impuestos')}}" name="cantidad_impuestos" class="form-control" placeholder="Cantidad de impuestos" required>
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
                                                <select name="codigo_postal" id="" class="form-control" required>
                                                    @foreach($paises as $paise)
                                                    <option value="{{$paise->phone_code}}">{{$paise->phone_code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="telefono">Teléfonos de la Empresa</label>
                                                <input type="text" value="{{old('telefono')}}" name="telefono" class="form-control" placeholder="Teléfonos de la empresa" required>
                                                @error('telefono')
                                                <small style="color: red;">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="correo">Correo de la Empresa</label>
                                                <input type="email" value="{{old('correo')}}" name="correo" class="form-control" placeholder="Correo de la empresa" required>
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
                                                <input type="text" id="map_search" value="{{old('direccion')}}" name="direccion" class="form-control" placeholder="Buscar ubicación en el mapa..." required>
                                                @error('direccion')
                                                <small style="color: red;">{{ $message }}</small>
                                                @enderror
                                                <input type="hidden" name="latitud" id="latitud">
                                                <input type="hidden" name="longitud" id="longitud">
                                                <br>
                                                <div id="map" style="width: 100%; height: 400px; border: 1px solid #ccc; border-radius: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-lg btn-primary btn-block" id="submit-btn">Crear empresa</button>

                                        </div>
                                    </div>
                                </div>
                    </form>
                </div>
            </div>

            {{-- Card Footer --}}
            @hasSection('auth_footer')
            <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                @yield('auth_footer')
            </div>
            @endif

        </div>
    </div>

</div>



</div>
@stop

@section('adminlte_js')
@stack('js')
@yield('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('MAP_KEY')}}&libraries=places&callback=initAutocomplete"
    async defer></script>

<script>
    let map;
    let marker;
    let searchBox;

    function initAutocomplete() {
        // Crear el mapa centrado en una ubicación por defecto
        const defaultLocation = {
            lat: -16.290154,
            lng: -63.588653
        }; // Santa Cruz, Bolivia

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: defaultLocation,
            mapTypeControl: false,
            panControl: false,
            zoomControl: true,
            streetViewControl: false
        });

        // Crear marcador
        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true,
            title: "Arrastra para ajustar la ubicación"
        });

        // Crear SearchBox para el buscador
        const input = document.getElementById('map_search');
        searchBox = new google.maps.places.SearchBox(input);

        // Listener para cuando se busca una dirección
        searchBox.addListener('places_changed', function() {
            const places = searchBox.getPlaces();

            if (places.length === 0) {
                return;
            }

            // Para cada lugar encontrado
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("No se encontró información geográfica para: " + place.name);
                    return;
                }

                // Ajustar el mapa a la nueva ubicación
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                // Mover el marcador a la nueva posición
                marker.setPosition(place.geometry.location);
            });
        });

        // Listener para cuando se arrastra el marcador
        marker.addListener('dragend', function() {
            const position = marker.getPosition();

            // Geocodificación inversa para obtener la dirección
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                location: position
            }, function(results, status) {
                if (status === 'OK' && results[0]) {
                    document.getElementById('map_search').value = results[0].formatted_address;
                }
            });
        });

        // Centrar el mapa cuando cambie el viewport
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#select_pais').on('change', function() {
            var id_pais = $(this).val();
            console.log('País seleccionado:', id_pais);

            if (id_pais) {
                $.ajax({
                    url: "{{url('/crear-empresa/')}}" + '/' + id_pais,
                    type: "GET",
                    beforeSend: function() {
                        $('#respuesta_pais').html('<select name="departamento" class="form-control" required><option value="">Cargando estados...</option></select>');
                    },
                    success: function(data) {
                        console.log('Respuesta recibida:', data);
                        $('#respuesta_pais').html(data);
                        // Limpiar ciudades cuando cambia el país
                        $('#respuesta_estado').html('<select name="ciudad" class="form-control" required><option value="">Primero seleccione un departamento</option></select>');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error AJAX:', error);
                        $('#respuesta_pais').html('<select name="departamento" class="form-control" required><option value="">Error al cargar los estados</option></select>');
                    }
                });
            } else {
                $('#respuesta_pais').html('<select name="departamento" class="form-control" required><option value="">Seleccione un departamento</option></select>');
                $('#respuesta_estado').html('<select name="ciudad" class="form-control" required><option value="">Primero seleccione un departamento</option></select>');
            }
        });

        // Evento para cargar ciudades cuando se selecciona un estado
        $(document).on('change', '#select_estado', function() {
            var id_estado = $(this).val();
            console.log('Estado seleccionado:', id_estado);

            if (id_estado) {
                $.ajax({
                    url: "{{url('/buscar-ciudades/')}}" + '/' + id_estado,
                    type: "GET",
                    beforeSend: function() {
                        $('#respuesta_estado').html('<select name="ciudad" class="form-control" required><option value="">Cargando ciudades...</option></select>');
                    },
                    success: function(data) {
                        console.log('Ciudades recibidas:', data);
                        $('#respuesta_estado').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error AJAX ciudades:', error);
                        $('#respuesta_estado').html('<select name="ciudad" class="form-control" required><option value="">Error al cargar ciudades</option></select>');
                    }
                });
            } else {
                $('#respuesta_estado').html('<select name="ciudad" class="form-control" required><option value="">Seleccione una ciudad</option></select>');
            }
        });

        // Debug del formulario
        $('#empresa-form').on('submit', function(e) {
            console.log('Formulario enviado');
            console.log('Action:', $(this).attr('action'));
            console.log('Method:', $(this).attr('method'));

            // Log todos los datos del formulario
            var formData = new FormData(this);
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            // Verificar que todos los campos requeridos tengan valor
            let valid = true;
            $(this).find('[required]').each(function() {
                if (!$(this).val()) {
                    console.log('Campo vacío:', $(this).attr('name'));
                    valid = false;
                }
            });

            if (!valid) {
                alert('Por favor complete todos los campos requeridos');
                e.preventDefault();
                return false;
            }
        });
    });
</script>

@stop