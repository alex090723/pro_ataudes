@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1>Lista de Roles</h1>
@stop

<style>
  .modal-content {
    background-color: #f8f9fa; /* Color de fondo */
    border-radius: 0.5rem; /* Bordes redondeados */
  }
  .form-control {
    border-radius: 0.25rem; /* Bordes redondeados en los campos */
  }
  .btn-primary {
    background-color: #007bff; /* Color de fondo del botón primario */
    border-color: #007bff; /* Color del borde del botón primario */
  }
  .btn-secondary {
    background-color: #6c757d; /* Color de fondo del botón secundario */
    border-color: #6c757d; /* Color del borde del botón secundario */
  }
  .modal-header {
    background-color: #007bff; /* Color de fondo del encabezado del modal */
    color: #fff; /* Color del texto del encabezado del modal */
  }
  .modal-footer {
    background-color: #f1f1f1; /* Color de fondo del pie de página del modal */
  }

</style>

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 text-right">
                <!-- Botón de Agregar Registros -->
                <div class="dropdown p-3">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalIngresarRol">
                        Agregar Registros
                    </button>
                </div>
            </div>
        </div>
        <!-- Modal para Ingresar Rol -->
        <div class="modal fade" id="ModalIngresarRol" tabindex="-1" aria-labelledby="ModalIngresarRolLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content border-primary shadow-lg">
                    <!-- Encabezado del Modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Rol</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Cuerpo del Modal -->
                    <div class="modal-body">
                        <div class="container mt-3">
                            <form action="{{ route('rol.store') }}" method="post">
                                @csrf
                                <!-- Nombre del Rol -->
                                <div class="mb-3">
                                    <label for="rol" class="form-label">Nombre Rol</label>
                                    <input type="text" class="form-control" id="rol" name="rol" required>
                                    @error('rol')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Descripción -->
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                                    @error('descripcion')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Estado del Rol -->
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
                                <!-- Botón de Envío -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Guardar Rol</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="col-md-12">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Rol</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha Creación</th>
                            <th>Fecha Modificacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $index => $rol)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $rol->rol }}</td>
                                <td>{{ $rol->descripcion }}</td>
                                <td>{{ $rol->estado == '1' ? 'Activo' : 'Inactivo' }}</td>
                                <td>{{ $rol->created_at }}</td>
                                <td>{{ $rol->updated_at }}</td>
                                <td>
                                    <!-- Botones de acción -->
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editRolModal-{{ $rol->id_rol }}">Editar</button>
                                    <!-- Otros botones -->
                                </td>
                            </tr>
                            <!-- Modal de edición de rol -->
                            <div class="modal fade" id="editRolModal-{{ $rol->id_rol }}" tabindex="-1" role="dialog" aria-labelledby="editRolModalLabel-{{ $rol->id_rol }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content border-primary shadow-lg">
                                            <h5 class="modal-title" id="editRolModalLabel-{{ $rol->id_rol }}">Editar Rol</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('rol.update', ['id' => $rol->id_rol]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <!-- Campos del formulario de edición -->
                                                <div class="mb-3">
                                                    <label for="rol" class="form-label">Nombre Rol</label>
                                                    <input type="text" class="form-control" id="rol" name="rol" value="{{ $rol->rol }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="descripcion" name="descripcion" required>{{ $rol->descripcion }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="estado" class="form-label">Estado</label>
                                                    <select class="form-select" id="estado" name="estado" required>
                                                        <option value="1" {{ $rol->estado == '1' ? 'selected' : '' }}>Activo</option>
                                                        <option value="0" {{ $rol->estado == '0' ? 'selected' : '' }}>Inactivo</option>
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
    <strong>Copyright &copy; 2024 <a href="">Ataudes Josue 1:9</a>.</strong> Todos los derechos reservados.
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
                    lengthMenu: "Mostrar _MENU_",
                    zeroRecords: "Nada encontrado - disculpas",
                    info: "Página _PAGE_ de _PAGES_",
                    infoEmpty: "No records available",
                    infoFiltered: "(Filtrado de _MAX_ registros totales)",
                    search: 'Buscar:',
                    paginate: {
                      next: 'Siguiente',
                      previous: 'Anterior'
                    }
                },
                pageLength: 5, // Mostrar 10 registros por página
                lengthChange: false // Ocultar opción para cambiar el número de registros por página
            });
        });
    </script>
@stop
