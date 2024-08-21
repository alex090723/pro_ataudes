@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
    <h1>Lista de Permisos</h1>
@stop

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 text-right">
                <!-- Botón de Agregar Registros -->
                <div class="dropdown p-3">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalIngresarPermiso">
                        Agregar Registros
                    </button>
                </div>
            </div>
        </div>
        <!-- Modal para Ingresar Permiso -->
        <div class="modal fade" id="ModalIngresarPermiso" tabindex="-1" aria-labelledby="ModalIngresarPermisoLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Encabezado del Modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Permiso</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Cuerpo del Modal -->
                    <div class="modal-body">
                        <div class="container mt-3">
                            <form action="{{ route('permisos.store') }}" method="post">
                                @csrf
                                <!-- Rol -->
                                <div class="mb-3">
                                    <label for="id_rol" class="form-label">Rol</label>
                                    <select class="form-select" id="id_rol" name="id_rol" required>
                                        @foreach($roles as $rol)
                                            <option value="{{ $rol->id_rol }}">{{ $rol->rol }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_rol')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Objeto -->
                                <div class="mb-3">
                                    <label for="id_objeto" class="form-label">Objeto</label>
                                    <select class="form-select" id="id_objeto" name="id_objeto" required>
                                        @foreach($objetos as $objeto)
                                            <option value="{{ $objeto->id_objeto }}">{{ $objeto->objeto }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_objeto')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Estado -->
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                    @error('estado')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Permisos -->
                                <div class="mb-3">
                                    <label for="insertar" class="form-label">Insertar</label>
                                    <select class="form-select" id="insertar" name="insertar" required>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                    @error('insertar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="modificar" class="form-label">Modificar</label>
                                    <select class="form-select" id="modificar" name="modificar" required>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                    @error('modificar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="eliminar" class="form-label">Eliminar</label>
                                    <select class="form-select" id="eliminar" name="eliminar" required>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                    @error('eliminar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="consultar" class="form-label">Consultar</label>
                                    <select class="form-select" id="consultar" name="consultar" required>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                    @error('consultar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Botón de Envío -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Guardar Permiso</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Numero</th>
                            <th>Rol</th>
                            <th>Objeto</th>
                            <th>Estado</th>
                            <th>Insertar</th>
                            <th>Modificar</th>
                            <th>Eliminar</th>
                            <th>Consultar</th>
                            <th>Fecha Creación</th>
                            <th>Fecha Modificación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permisos as $permiso)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permiso->rol }}</td>
                                <td>{{ $permiso->objeto }}</td>
                                <td>{{ $permiso->estado == '1' ? 'Activo' : 'Inactivo' }}</td>
                                <td>{{ $permiso->insertar == '1' ? 'Sí' : 'No' }}</td>
                                <td>{{ $permiso->modificar == '1' ? 'Sí' : 'No' }}</td>
                                <td>{{ $permiso->eliminar == '1' ? 'Sí' : 'No' }}</td>
                                <td>{{ $permiso->consultar == '1' ? 'Sí' : 'No' }}</td>
                                <td>{{ $permiso->created_at }}</td>
                                <td>{{ $permiso->updated_at }}</td>
                                <td>
                                    <!-- Botones de acción -->
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPermisoModal-{{ $permiso->id_rol }}-{{ $permiso->id_objeto }}">Editar</button>
                                    <!-- Otros botones -->
                                </td>
                            </tr>
                            <!-- Modal de edición de permiso -->
                            <div class="modal fade" id="editPermisoModal-{{ $permiso->id_rol }}-{{ $permiso->id_objeto }}" tabindex="-1" role="dialog" aria-labelledby="editPermisoModalLabel-{{ $permiso->id_rol }}-{{ $permiso->id_objeto }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPermisoModalLabel-{{ $permiso->id_rol }}-{{ $permiso->id_objeto }}">Editar Permiso</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('permisos.update', ['id_rol' => $permiso->id_rol, 'id_objeto' => $permiso->id_objeto]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <!-- Campos del formulario de edición -->
                                                <div class="mb-3">
                                                    <label for="id_rol" class="form-label">Rol</label>
                                                    <select class="form-select" id="id_rol" name="id_rol" required>
                                                        @foreach($roles as $rol)
                                                            <option value="{{ $rol->id_rol }}" {{ $rol->id_rol == $permiso->id_rol ? 'selected' : '' }}>{{ $rol->nombre_rol }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="id_objeto" class="form-label">Objeto</label>
                                                    <select class="form-select" id="id_objeto" name="id_objeto" required>
                                                        @foreach($objetos as $objeto)
                                                            <option value="{{ $objeto->id_objeto }}" {{ $objeto->id_objeto == $permiso->id_objeto ? 'selected' : '' }}>{{ $objeto->nombre_objeto }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="estado" class="form-label">Estado</label>
                                                    <select class="form-select" id="estado" name="estado" required>
                                                        <option value="1" {{ $permiso->estado == '1' ? 'selected' : '' }}>Activo</option>
                                                        <option value="0" {{ $permiso->estado == '0' ? 'selected' : '' }}>Inactivo</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="insertar" class="form-label">Insertar</label>
                                                    <select class="form-select" id="insertar" name="insertar" required>
                                                        <option value="1" {{ $permiso->insertar == '1' ? 'selected' : '' }}>Sí</option>
                                                        <option value="0" {{ $permiso->insertar == '0' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="modificar" class="form-label">Modificar</label>
                                                    <select class="form-select" id="modificar" name="modificar" required>
                                                        <option value="1" {{ $permiso->modificar == '1' ? 'selected' : '' }}>Sí</option>
                                                        <option value="0" {{ $permiso->modificar == '0' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="eliminar" class="form-label">Eliminar</label>
                                                    <select class="form-select" id="eliminar" name="eliminar" required>
                                                        <option value="1" {{ $permiso->eliminar == '1' ? 'selected' : '' }}>Sí</option>
                                                        <option value="0" {{ $permiso->eliminar == '0' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="consultar" class="form-label">Consultar</label>
                                                    <select class="form-select" id="consultar" name="consultar" required>
                                                        <option value="1" {{ $permiso->consultar == '1' ? 'selected' : '' }}>Sí</option>
                                                        <option value="0" {{ $permiso->consultar == '0' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2024 <a href="">Nombre de la Empresa</a>.</strong> Todos los derechos reservados.
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop
