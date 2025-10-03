<select name="departamento" id="select_estado" class="form-control" required>
    <option value="">Seleccione un departamento</option>
    @foreach($estados as $estado)
    <option value="{{ $estado->id }}">{{ $estado->name }}</option>
    @endforeach
</select>