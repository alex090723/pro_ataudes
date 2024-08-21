@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Lista de Usuarios</h1>
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
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalIngresarUsuario">
                        Agregar Registros
                    </button>
                </div>
            </div>
        </div>
        <!-- Modal para Ingresar Usuario -->
        <div class="modal fade" id="ModalIngresarUsuario" tabindex="-1" aria-labelledby="ModalIngresarUsuarioLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content border-primary shadow-lg">
                    <!-- Encabezado del Modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Usuario</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Cuerpo del Modal -->
                    <div class="modal-body">
                        <div class="container mt-3">
                            <form action="{{ route('usuario.store') }}" method="post">
                                @csrf
                                <!-- Nombre -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre Usuario</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Contraseña -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>                                
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
                                <!-- Persona -->
                                <div class="mb-3">
                                    <label for="Id_persona" class="form-label">Persona:</label>
                                    <select class="form-select" id="Id_persona" name="Id_persona" required>
                                        @foreach($personas as $persona)
                                            <option value="{{ $persona->Id_persona }}">{{ $persona->Nombre_persona }}</option>
                                        @endforeach
                                    </select>
                                    @error('Id_persona')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>    
                                <!-- estado del usuario -->
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado del Usuario</label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                    @error('estado')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>                                                            
                                <!-- Token de Recuerdo -->
                                <div class="mb-3">
                                    <label for="remember_token" class="form-label">Token de Recuerdo</label>
                                    <input type="text" class="form-control" id="remember_token" name="remember_token">
                                    @error('remember_token')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Botón de Envío -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
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
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Persona</th>
                            <th>Estado</th>
                            <th>Fecha Creación</th>
                            <th>Fecha Modificacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->rol }}</td>
                                <td>{{ $user->Nombre_persona }}</td>
                                <td>{{ $user->estado == '1' ? 'Activo' : 'Inactivo' }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td>
                                    <!-- Botones de acción -->
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">Editar</button>
                                    <!-- Otros botones -->
                                </td>
                            </tr>
                            <!-- Modal de edición de usuario -->
                            <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUserModalLabel-{{ $user->id }}">Editar Usuario</h5>
                                            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">    <span aria-hidden="true">&times;</span>
                                            </button>-->
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('usuario.update', ['id' => $user->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <!-- Campos del formulario de edición -->
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nombre Usuario</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Correo Electrónico</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Contraseña</label>
                                                    <input type="password" class="form-control" id="password" name="password">
                                                </div>                                                
                                                <div class="mb-3">
                                                    <label for="id_rol" class="form-label">Rol</label>
                                                    <select class="form-select" id="id_rol" name="id_rol" required>
                                                        @foreach($roles as $rol)
                                                            <option value="{{ $rol->id_rol }}" {{ $user->id_rol == $rol->id_rol ? 'selected' : '' }}>{{ $rol->rol }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="Id_persona" class="form-label">Persona:</label>
                                                    <select class="form-select" id="Id_persona" name="Id_persona" required>
                                                        @foreach($personas as $persona)
                                                            <option value="{{ $persona->Id_persona }}" {{ $user->Id_persona == $persona->Id_persona ? 'selected' : '' }}>{{ $persona->Nombre_persona }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="estado" class="form-label">Estado del Usuario</label>
                                                    <select class="form-select" id="estado" name="estado" required>
                                                        <option value="1" {{ $user->estado == '1' ? 'selected' : '' }}>Activo</option>
                                                        <option value="0" {{ $user->estado == '0' ? 'selected' : '' }}>Inactivo</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="remember_token" class="form-label">Token de Recuerdo</label>
                                                    <input type="text" class="form-control" id="remember_token" name="remember_token" value="{{ $user->remember_token }}">
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
                }
                pageLength: 5, // Mostrar 10 registros por página
                lengthChange: false // Ocultar opción para cambiar el número de registros por página
            });
        });
    </script>
@stop
