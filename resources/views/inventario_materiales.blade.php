

@extends('adminlte::page')

@section('title', 'Inventario de Materiales')

@section('content_header')
    <h2>Inventario de Materiales</h2>
@endsection
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
            <div class="dropdown p-3">
                @can('crear-inventario')
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalIngresarMaterial">
                    Agregar Material
                </button>
                @endcan

            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
        {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    <div class="card">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Proveedor</th>
                        <th>Tipo de Material</th>
                        <th>Cantidad Disponible</th>
                        <th>Fecha de Adquisición</th>
                        <th>Precio Unitario</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($Materiales as $material)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $material->Nombre_proveedor }}</td>
                        <td>{{ $material->Tipo_material }}</td>
                        <td>{{ $material->Cantidad_disponible }}</td>
                        <td>{{ $material->Fecha_Adquisicion }}</td>
                        <td>{{ $material->Precio_unitario }}</td>
                        <td>{{ $material->Ubicacion }}</td>
                        <td>{{ $material->Estado_material }}</td>
                        <td>
                            @can('editar-inventario')
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editMaterialModal-{{ $material->Id_inventario }}">
                            <i class="fas fa-edit"></i> 
                        </button>
                            @endcan
                            
                        </td>
                    </tr>
                    <!-- Modal de Edición -->
                    @if(isset($material->Id_inventario))
                        <div class="modal fade" id="editMaterialModal-{{ $material->Id_inventario }}" tabindex="-1" aria-labelledby="editMaterialModalLabel-{{ $material->Id_inventario }}" aria-hidden="true">
                        <<div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content border-primary shadow-lg">
                                    <!-- Encabezado del Modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar Material</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Cuerpo del Modal -->
                                    <div class="modal-body">
                                        <div class="container mt-3">
                                            <form action="{{ route('Materiales.update', $material->Id_inventario) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="Id_proveedor" class="form-label">Proveedor</label>
                                                    <select class="form-control" id="Id_proveedor" name="Id_proveedor" required>
                                                        @foreach($Proveedores as $proveedor)
                                                            <option value="{{ $proveedor->Id_proveedor }}" {{ isset($material) && $proveedor->Id_proveedor == $material->Id_proveedor ? 'selected' : '' }}>
                                                                {{ $proveedor->Nombre_proveedor }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('Id_proveedor')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

<!-- Tipo de Material -->
<div class="mb-3">
    <label for="tipo_material" class="form-label">Tipo de Material</label>
    <input type="text" class="form-control" id="tipo_material" name="tipo_material" required oninput="validateMaterialType(this)">
    @error('tipo_material')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateMaterialType(input) {
    // Elimina caracteres no deseados (cualquier cosa que no sea una letra o un espacio)
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                                                <!-- Cantidad Disponible -->
                                                <div class="mb-3">
                                                    <label for="cantidad_disponible" class="form-label">Cantidad Disponible</label>
                                                    <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible" required>
                                                    @error('cantidad_disponible')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- Fecha de Adquisición -->
                                                <div class="mb-3">
                                                    <label for="fecha_adquisicion" class="form-label">Fecha de Adquisición</label>
                                                    <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" required>
                                                    @error('fecha_adquisicion')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- Precio Unitario -->
                                                <div class="mb-3">
                                                    <label for="precio_unitario" class="form-label">Precio Unitario</label>
                                                    <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" step="0.01" required>
                                                    @error('precio_unitario')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
    <label for="ubicacion" class="form-label">Ubicación</label>
    <input type="text" class="form-control" id="ubicacion" name="ubicacion" required oninput="validateUbicacion(this)">
    @error('ubicacion')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateUbicacion(input) {
    // Elimina caracteres no deseados (cualquier cosa que no sea una letra o un espacio)
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                                              <!-- Estado -->
<div class="mb-3">
    <label for="estado_material" class="form-label">Estado</label>
    <input type="text" class="form-control" id="estado_material" name="estado_material" required oninput="validateEstado(this)">
    @error('estado_material')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateEstado(input) {
    // Elimina caracteres no deseados (cualquier cosa que no sea una letra o un espacio)
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                                                <!-- Botón de Envío -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para Agregar Material -->
<div class="modal fade" id="ModalIngresarMaterial" tabindex="-1" aria-labelledby="ModalIngresarMaterialLabel" aria-hidden="true">
<<div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content border-primary shadow-lg">
            <!-- Encabezado del Modal -->
            <div class="modal-header">
                <h4 class="modal-title">Agregar Material</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <div class="container mt-3">
                    <form action="{{ route('Materiales.store') }}" method="post">
                        @csrf
                  
                        <!-- Para el formulario de agregar -->
                        <div class="mb-3">
                            <label for="Id_proveedor" class="form-label">Proveedor</label>
                            <select class="form-control" id="Id_proveedor" name="Id_proveedor" required>
                                @foreach($Proveedores as $proveedor)
                                    <option value="{{ $proveedor->Id_proveedor }}">
                                        {{ $proveedor->Nombre_proveedor }}
                                    </option>
                                @endforeach
                            </select>
                            @error('Id_proveedor')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                     <!-- Tipo de Material -->
<div class="mb-3">
    <label for="tipo_material" class="form-label">Tipo de Material</label>
    <input type="text" class="form-control" id="tipo_material" name="tipo_material" required oninput="validateMaterialType(this)">
    @error('tipo_material')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<script>
function validateMaterialType(input) {
    // Elimina caracteres no deseados (cualquier cosa que no sea una letra o un espacio)
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                        <!-- Cantidad Disponible -->
                        <div class="mb-3">
                            <label for="cantidad_disponible" class="form-label">Cantidad Disponible</label>
                            <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible" required>
                            @error('cantidad_disponible')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Fecha de Adquisición -->
                        <div class="mb-3">
                            <label for="fecha_adquisicion" class="form-label">Fecha de Adquisición</label>
                            <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" required>
                            @error('fecha_adquisicion')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Precio Unitario -->
                        <div class="mb-3">
                            <label for="precio_unitario" class="form-label">Precio Unitario</label>
                            <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" step="0.01" required>
                            @error('precio_unitario')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Ubicación -->
                        <div class="mb-3">
    <label for="ubicacion" class="form-label">Ubicación</label>
    <input type="text" class="form-control" id="ubicacion" name="ubicacion" required oninput="validateUbicacion(this)">
    @error('ubicacion')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateUbicacion(input) {
    // Elimina caracteres no deseados (cualquier cosa que no sea una letra o un espacio)
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                  <!-- Estado -->
<div class="mb-3">
    <label for="estado_material" class="form-label">Estado</label>
    <input type="text" class="form-control" id="estado_material" name="estado_material" required oninput="validateEstado(this)">
    @error('estado_material')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateEstado(input) {
    // Elimina caracteres no deseados (cualquier cosa que no sea una letra o un espacio)
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                            <!-- Botón de Envío -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Agregar Material</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                    </form>
                    </form>
                </div>
            </div>
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
    <script>
    $(document).ready(function() {
        $('.table').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                lengthMenu: "Mostrar MENU",
                zeroRecords: "Nada encontrado - disculpas",
                info: "Página PAGE de PAGES",
                infoEmpty: "No records available",
                infoFiltered: "(Filtrado de MAX registros totales)",
                search: 'Buscar:',
                paginate: {
                    next: 'Siguiente',
                    previous: 'Anterior'
                }
            },
            pageLength: 5, // Mostrar 5 registros por página
            lengthChange: false // Ocultar opción para cambiar el número de registros por página
        });

        // Script para rellenar el formulario de edición
        $('.btnEditar').click(function() {
            let tipoMaterial = $(this).data('tipo_material');
            let cantidadDisponible = $(this).data('cantidad_disponible');
            let precioUnitario = $(this).data('precio_unitario');
            let ubicacion = $(this).data('ubicacion');
            let estado = $(this).data('estado');

            $('#tipo_material_edit').val(tipoMaterial);
            $('#cantidad_disponible_edit').val(cantidadDisponible);
            $('#precio_unitario_edit').val(precioUnitario);
            $('#ubicacion_edit').val(ubicacion);
            $('#estado_edit').val(estado);
        });
    });
</script>

@stop

