@extends('adminlte::page')

@section('title', 'Gestión de Permisos')

@section('content_header')
    <h1 class="text-center">Administracion de Permisos</h1>
@stop

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form id="role-form" method="POST" action="{{ route('permisos.update') }}" class="text-center">
                    @csrf
                    @method('PUT')
                   
                    @if(session('success'))
                      <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      </div>
                    @endif
                    
                    @if(session('error'))
                      <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      </div>
                    @endif

                    <div class="form-group">
                        <label for="role-select" class="control-label">Nombre del Rol</label>
                        <select id="role-select" class="form-control mx-auto" style="max-width: 300px;" name="role_id">
                            <option value="">Selecciona un rol</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Permisos -->
                    <h4 class="mt-4">Permisos</h4>
                    <div id="permissions-container" class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Módulo</th>
                                    <th>Ver</th>
                                    <th>Crear</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody id="permissions-list">
                                @foreach ($permissions->groupBy(function($item) {
                                    return explode('-', $item->name)[1];
                                }) as $module => $perms)
                                    <tr data-module="{{ $module }}">
                                        <td>{{ ucfirst($module) }}</td>
                                        @foreach (['ver', 'crear', 'editar'] as $action)
                                            @php
                                                $permName = $action . '-' . $module;
                                                $permission = $perms->firstWhere('name', $permName);
                                            @endphp
                                            <td>
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer justify-content-center">
                        @can('editar-seguridad')
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#role-select').change(function() {
            var roleId = $(this).val();
            if (roleId) {
                loadPermissions(roleId);
            } else {
                $('#permissions-list input[type=checkbox]').prop('checked', false);
            }
        });

        function loadPermissions(roleId) {
            $.get('/roles/' + roleId + '/permissions', function(data) {
                $('#permissions-list input[type=checkbox]').each(function() {
                    var permName = $(this).val();
                    $(this).prop('checked', data.permissions.includes(permName));
                });
            });
        }
    });
</script>
@stop
