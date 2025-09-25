<form action="{{ route('ventas.reporte') }}" method="GET" target="_blank">
    <div>
        <label>Fecha Inicio</label>
        <input type="date" name="fecha_inicio" required>
    </div>
    <div>
        <label>Fecha Fin</label>
        <input type="date" name="fecha_fin" required>
    </div>
    <div>
        <label>Usuario</label>
        <select name="user_id">
            <option value="">Todos</option>
            @foreach($usuarios as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit">Generar Reporte</button>
</form>
