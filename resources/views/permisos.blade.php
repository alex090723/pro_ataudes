@extends('adminlte::page')

@section('title', 'Editar Rol')

@section('content_header')
    <h1>Editar Rol</h1>
@stop

@section('content')
    <div class="container mt-3">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Selección de Roles -->
            <div class="mb-3">
                <label for="roles" class="form-label">Selecciona los Roles</label>
                <div>
                    @foreach($allRoles as $availableRole)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="role_{{ $availableRole->id }}" name="roles[]" value="{{ $availableRole->name }}"
                                {{ $role->name == $availableRole->name ? 'checked' : '' }}>
                            <label class="form-check-label" for="role_{{ $availableRole->id }}">{{ $availableRole->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Permisos -->
            <div class="mb-3">
                <label for="permissions" class="form-label">Permisos para este Rol</label>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Módulo</th>
                            <th>Ver</th>
                            <th>Crear</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions->groupBy(function($item) {
                            return explode('-', $item->name)[1];  // Agrupa permisos por módulo
                        }) as $module => $perms)
                            <tr>
                                <td>{{ ucfirst($module) }}</td>
                                @foreach (['ver', 'crear', 'editar'] as $action)
                                    @php
                                        $permName = $action . '-' . $module;
                                        $permission = $perms->firstWhere('name', $permName);
                                    @endphp
                                    <td>
                                        <input type="checkbox" name="permissions[]" value="{{ $permName }}" 
                                        {{ $role->permissions->contains('name', $permName) ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
@stop
