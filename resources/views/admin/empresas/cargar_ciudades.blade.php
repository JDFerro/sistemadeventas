<select name="ciudad" id="select_ciudad" class="form-control" required>
    <option value="">Seleccione una ciudad</option>
    @foreach($ciudades as $ciudad)
    <option value="{{ $ciudad->name }}">{{ $ciudad->name }}</option>
    @endforeach
</select>