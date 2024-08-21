<!-- resources/views/personas/edit.blade.php -->

<form action="{{ route('personas.update', $persona->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Campos de la persona -->
    <input type="text" name="Nombre_persona" value="{{ $persona->Nombre_persona }}">
    <input type="text" name="DNI_persona" value="{{ $persona->DNI_persona }}">
    <input type="text" name="Sexo_persona" value="{{ $persona->Sexo_persona }}">
    <input type="number" name="Edad_persona" value="{{ $persona->Edad_persona }}">
    <select name="Estado_Civil">
        <option value="SOLTERO" {{ $persona->Estado_Civil == 'SOLTERO' ? 'selected' : '' }}>Soltero</option>
        <option value="CASADO" {{ $persona->Estado_Civil == 'CASADO' ? 'selected' : '' }}>Casado</option>
        <option value="DIVORCIADO" {{ $persona->Estado_Civil == 'DIVORCIADO' ? 'selected' : '' }}>Divorciado</option>
        <option value="VIUDO" {{ $persona->Estado_Civil == 'VIUDO' ? 'selected' : '' }}>Viudo</option>
    </select>
    <input type="text" name="Tipo_persona" value="{{ $persona->Tipo_persona }}">

    <!-- Campos de la dirección -->
    <input type="text" name="Pais" value="{{ $persona->direccion->Pais ?? '' }}">
    <input type="text" name="Departamento" value="{{ $persona->direccion->Departamento ?? '' }}">
    <input type="text" name="Municipio" value="{{ $persona->direccion->Municipio ?? '' }}">
    <input type="text" name="Colonia" value="{{ $persona->direccion->Colonia ?? '' }}">

    <!-- Campos del email -->
    <input type="email" name="Email" value="{{ $persona->email->Email ?? '' }}">

    <!-- Campos del teléfono -->
    <input type="text" name="Numero_Telefono" value="{{ $persona->telefono->Numero_Telefono ?? '' }}">
    <input type="text" name="Tipo_Telefono" value="{{ $persona->telefono->Tipo_Telefono ?? '' }}">

    <!-- Botón de actualización -->
    <button type="submit">Actualizar</button>
</form>
