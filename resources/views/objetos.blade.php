@extends('adminlte::page')

@section('title', 'Objetos')

@section('content_header')
    <h1>Lista de Objetos</h1>
@stop

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 text-right">
                <!-- Botón de Agregar Registros -->
                <div class="dropdown p-3">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalIngresarObjeto">
                        Agregar Registros
                    </button>
                </div>
            </div>
        </div>
        <!-- Modal para Ingresar Objeto -->
        <div class="modal fade" id="ModalIngresarObjeto" tabindex="-1" aria-labelledby="ModalIngresarObjetoLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Encabezado del Modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Objeto</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Cuerpo del Modal -->
                    <div class="modal-body">
                        <div class="container mt-3">
                            <form action="{{ route('objeto.store') }}" method="post">
                                @csrf
                                <!-- Nombre del Objeto -->
                                <div class="mb-3">
                                    <label for="objeto" class="form-label">Nombre Objeto</label>
                                    <input type="text" class="form-control" id="objeto" name="objeto" required>
                                    @error('objeto')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Tipo de Objeto -->
                                <div class="mb-3">
                                    <label for="tipo_objeto" class="form-label">Tipo de Objeto</label>
                                    <input type="text" class="form-control" id="tipo_objeto" name="tipo_objeto" required>
                                    @error('tipo_objeto')
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
                                <!-- Estado del Objeto -->
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
                                    <button type="submit" class="btn btn-primary">Guardar Objeto</button>
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
                            <th>Objeto</th>
                            <th>Tipo de Objeto</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha Creación</th>
                            <th>Fecha Modificacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($objetos as $objeto)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $objeto->objeto }}</td>
                                <td>{{ $objeto->tipo_objeto }}</td>
                                <td>{{ $objeto->descripcion }}</td>
                                <td>{{ $objeto->estado == '1' ? 'Activo' : 'Inactivo' }}</td>
                                <td>{{ $objeto->created_at }}</td>
                                <td>{{ $objeto->updated_at }}</td>
                                <td>
                                    <!-- Botones de acción -->
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editObjetoModal-{{ $objeto->id_objeto }}">Editar</button>
                                    <!-- Otros botones -->
                                </td>
                            </tr>
                            <!-- Modal de edición de objeto -->
                            <div class="modal fade" id="editObjetoModal-{{ $objeto->id_objeto }}" tabindex="-1" role="dialog" aria-labelledby="editObjetoModalLabel-{{ $objeto->id_objeto }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editObjetoModalLabel-{{ $objeto->id_objeto }}">Editar Objeto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('objeto.update', ['id' => $objeto->id_objeto]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <!-- Campos del formulario de edición -->
                                                <div class="mb-3">
                                                    <label for="objeto" class="form-label">Nombre Objeto</label>
                                                    <input type="text" class="form-control" id="objeto" name="objeto" value="{{ $objeto->objeto }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tipo_objeto" class="form-label">Tipo de Objeto</label>
                                                    <input type="text" class="form-control" id="tipo_objeto" name="tipo_objeto" value="{{ $objeto->tipo_objeto }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="descripcion" name="descripcion" required>{{ $objeto->descripcion }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="estado" class="form-label">Estado</label>
                                                    <select class="form-select" id="estado" name="estado" required>
                                                        <option value="1" {{ $objeto->estado == '1' ? 'selected' : '' }}>Activo</option>
                                                        <option value="0" {{ $objeto->estado == '0' ? 'selected' : '' }}>Inactivo</option>
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
