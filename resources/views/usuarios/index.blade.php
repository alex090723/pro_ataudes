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
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 text-right">
                <div class="dropdown p-3">
                    @can('crear-seguridad')
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalIngresarUsuario">
                        Agregar Registros
                    </button> 
                    @endcan

                </div>
            </div>
        </div>

        <div class="modal fade" id="ModalIngresarUsuario" tabindex="-1" aria-labelledby="ModalIngresarUsuarioLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content border-primary shadow-lg">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Usuario</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container mt-3">
                            <form action="{{ route('usuarios.store') }}" method="post">
                                @csrf
                                <!-- Nombre -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre Usuario</label>
                                    <input type="text" class="form-control" id="name" name="name"  required
                                    pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,50}" 
                                    title="El nombre debe contener solo letras y espacios, y tener entre 2 y 50 caracteres.">
                                </div>
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div id="emailError" class="alert alert-danger" style="display:none;">Ingrese un correo electrónico válido.</div>
                                </div>
                                <!-- Contraseña -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" 
                                    title="La contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, una minúscula, un número, y un carácter especial.">
                                    
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Rol -->
                                <div class="mb-3">
                                    <label for="roles" class="form-control">Rol</label>
                                    <select class="form-control" id="roles" name="roles[]" required>
                                        @foreach($roles as $rol)
                                            <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Estado del usuario -->
                                <div class="mb-3">
                                    <label for="estado" class="form-control">Estado del Usuario</label>
                                    <select class="form-control" id="estado" name="estado" required>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                    @error('estado')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                 <!-- Persona -->
                                <div class="mb-3">
                                    <label for="Id_empleado" class="form-control">Empleado</label>
                                    <select class="form-control" id="Id_empleado" name="Id_empleado" required>
                                        @foreach($Empleados as $empleado)
                                            <option value="{{ $empleado->Id_empleado }}">
                                                {{ $empleado->Nombre_empleado }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('Id_empleado')
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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $index => $usuario)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @if (!empty($usuario->getRoleNames()))
                                    @foreach ($usuario->getRoleNames() as $rolName)
                                        <h5><span class="badge badge-dark">{{ $rolName }}</span></h5>
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $usuario->NombreEmpleado }}</td>
                            <td>{{ $usuario->estado == '1' ? 'Activo' : 'Inactivo' }}</td>
                            <td>{{ $usuario->created_at }}</td>
                            <td>
                                <!-- Botones de acción -->
                                @can('editar-seguridad')
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalEditarUsuario{{ $usuario->id }}">
                                <i class="fas fa-edit text-dark-blue"></i> 
                            </button>
                                @endcan
                                
                                @can('borrar-seguridad')
                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este usuario?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endcan


                            </td>
                        </tr>
                        <!-- Modal para Editar Usuario -->
                        <div class="modal fade" id="ModalEditarUsuario{{ $usuario->id }}" tabindex="-1" aria-labelledby="ModalEditarUsuario{{ $usuario->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content border-primary shadow-lg">
                                    <!-- Encabezado del Modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar Usuario</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Cuerpo del Modal -->
                                    <div class="modal-body">
                                        <div class="container mt-3">
                                            <form action="{{ route('usuarios.update', $usuario->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <!-- Nombre -->
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nombre Usuario</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $usuario->name }}" required 
                                                           pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,50}" 
                                                           title="El nombre debe contener solo letras y espacios, y tener entre 2 y 50 caracteres.">
                                                    @error('name')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- Email -->
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Correo Electrónico</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required 
                                                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" 
                                                        title="Introduce una dirección de correo electrónico válida, por ejemplo, ejemplo@dominio.com.">
                                                    @error('email')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Contraseña -->
                                                <div class="mb-3">
                                                    <label for="password_edit" class="form-label">Contraseña</label>
                                                    <input type="password" class="form-control" id="password_edit" name="password" required 
                                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" 
                                                        title="La contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, una minúscula, un número, y un carácter especial.">
                                                    @error('password')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Rol -->
                                                <div class="mb-3">
                                                    <label for="roles" class="form-control">Rol</label>
                                                    <select class="form-control" id="roles" name="roles" required>
                                                        @foreach($roles as $rol)
                                                            <option value="{{ $rol->name }}" {{ $usuario->roles->pluck('name')->contains($rol->name) ? 'selected' : '' }}>{{ $rol->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('roles')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- Persona -->
  
                                                <div class="mb-3">
                                                    <label for="Id_empleado" class="form-control">Empleado</label>
                                                    <select class="form-control" id="Id_empleado" name="Id_empleado" required>
                                                        @foreach($Empleados as $empleado)
                                                            <option value="{{ $empleado->Id_empleado }}" {{ $empleado->Id_empleado == $usuario->Id_empleado ? 'selected' : '' }}>
                                                                {{ $empleado->Nombre_empleado }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('Id_empleado')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- Estado del usuario -->
                                                <div class="mb-3">
                                                    <label for="estado" class="form-control">Estado del Usuario</label>
                                                    <select class="form-control" id="estado" name="estado" required>
                                                        <option value="1" {{ $usuario->estado == '1' ? 'selected' : '' }}>Activo</option>
                                                        <option value="0" {{ $usuario->estado == '0' ? 'selected' : '' }}>Inactivo</option>
                                                    </select>
                                                    @error('estado')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Botón de Envío -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    @endforeach                        
                    </tbody>
                </table>
                {{ $usuarios->links() }}
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

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
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
                pageLength: 10, // Mostrar 10 registros por página
                lengthChange: false // Ocultar opción para cambiar el número de registros por página
            });

            // Script para rellenar el formulario de edición
            $('.btnEditar').click(function() {
                let usuarioId = $(this).data('id');
                let usuarioName = $(this).data('name');
                let usuarioEmail = $(this).data('email');
                let usuarioEstado = $(this).data('estado');
                let usuarioIdPersona = $(this).data('id_persona');
                let usuarioRoles = $(this).data('roles');

                $('#id').val(usuarioId);
                $('#name_edit').val(usuarioName);
                $('#email_edit').val(usuarioEmail);
                $('#estado_edit').val(usuarioEstado);
                $('#Id_persona_edit').val(usuarioIdPersona);

                let rolesArray = JSON.parse(usuarioRoles);
                $('#roles_edit').val(rolesArray).change();
            });
        });
    </script>
<script>
    document.getElementById('name').addEventListener('input', function (e) {
        var value = e.target.value;
        e.target.value = value.replace(/[^A-Za-z\s]/g, '');
    });
</script>

<script>
    document.getElementById('email').addEventListener('input', function (e) {
        var email = e.target.value;
        var emailError = document.getElementById('emailError');
        var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!emailPattern.test(email)) {
            emailError.style.display = 'block';
        } else {
            emailError.style.display = 'none';
        }
    });
</script>

<script>
    function validatePassword(password) {
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return passwordPattern.test(password);
    }

    document.getElementById('password').addEventListener('input', function (e) {
        const password = e.target.value;
        const passwordHelp = document.getElementById('passwordHelp');
        
        if (!validatePassword(password)) {
            passwordHelp.textContent = 'La contraseña no cumple con los requisitos de seguridad.';
            passwordHelp.style.color = 'red';
        } else {
            passwordHelp.textContent = 'La contraseña cumple con los requisitos de seguridad.';
            passwordHelp.style.color = 'green';
        }
    });
</script>




@stop
