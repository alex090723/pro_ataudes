@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h2>PRODUCTOS</h2>
    @endsection
    @section('content')
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
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 text-right">
                <!-- Botón de Agregar Producto -->
                <div class="dropdown p-3">

                    @can('crear-inventario')
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalIngresarProducto">
                        Agregar Producto
                    </button>
                    @endcan

                </div>
            </div>
        </div>
        

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
        <div class="card">
            <div class="col-md-12">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sucursal</th>
                            <th>Tipo Producto</th>
                            <th>Nombre Producto</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad Disponible</th>
                            <th>Categoría</th>
                            <th>Tamaño</th>
                            <th>Modelo</th>
                            <th>Fecha Ingreso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($Productos as $producto)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $producto->nombre_sucursal }}</td>
                            <td>{{ $producto->tipo_producto }}</td>
                            <td>{{ $producto->nombre_producto }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>{{ $producto->precio }}</td>
                            <td>{{ $producto->cantidad_disponible }}</td>
                            <td>{{ $producto->categoria }}</td>
                            <td>{{ $producto->tamaño }}</td>
                            <td>{{ $producto->modelo }}</td>
                            <td>{{ $producto->created_at }}</td>
                            <td>
                                <!-- Botones de acción -->
                                @can('editar-inventario')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProductoModal-{{ $producto->id_producto }}"
    data-id="{{ $producto->id_producto }}"
    data-tipo="{{ $producto->tipo_producto }}"
    data-nombre="{{ $producto->nombre_producto }}"
    data-descripcion="{{ $producto->descripcion }}"
    data-precio="{{ $producto->precio }}"
    data-cantidad="{{ $producto->cantidad_disponible }}"
    data-categoria="{{ $producto->categoria }}"
    data-modelo="{{ $producto->modelo }}"
    data-estado="{{ $producto->estado }}">
    <i class="fas fa-edit"></i> 
</button>

                                @endcan
                               
                            </td>
                        </tr>
                        <!-- Modal de Edición -->
                        @if(isset($producto->id_producto))
                            <div class="modal fade" id="editProductoModal-{{ $producto->id_producto }}" tabindex="-1" aria-labelledby="editProductoModalLabel-{{ $producto->id_producto }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content border-primary shadow-lg">
                                        <!-- Encabezado del Modal -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Editar Producto</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <!-- Cuerpo del Modal -->
                                        <div class="modal-body">
                                            <div class="container mt-3">
                                                <form action="{{ route('Productos.update', $producto->id_producto) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- SUCURSAL -->
                                                    <div class="mb-3">
                                                        <label for="Id_sucursal" class="form-label">Sucursal</label>
                                                        <select class="form-control" id="Id_sucursal" name="Id_sucursal" required>
                                                            @foreach($sucursales as $sucursal)
                                                                <option value="{{ $sucursal->Id_sucursal }}">{{ $sucursal->Nombre_sucursal }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('Id_sucursal')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
    <label for="tipo_producto" class="form-label">Tipo Producto</label>
    <select class="form-control" id="tipo_producto" name="tipo_producto" required>
        <option value="" disabled selected>Seleccione el tipo de producto</option>
        <option value="Ataúd">Ataúd</option>
        <option value="Mortaja">Mortaja</option>
        <!-- Agrega más opciones aquí si es necesario -->
    </select>
    @error('tipo_producto')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
</script>

                                                   <!-- Nombre del Producto -->
<div class="mb-3">
    <label for="nombre_producto" class="form-label">Nombre Producto</label>
    <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required oninput="validateNombreProducto(this)">
    @error('nombre_producto')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateNombreProducto(input) {
    // Permite solo letras y espacios
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                                                    <!-- Descripción -->
<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea class="form-control" id="descripcion" name="descripcion" oninput="validateDescripcion(this)"></textarea>
    @error('descripcion')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateDescripcion(input) {
    // Permite solo letras, números, espacios y saltos de línea
    input.value = input.value.replace(/[^A-Za-z0-9\s\n]/g, '');
}
</script>

                                                    <!-- Precio -->
                                                    <div class="mb-3">
                                                        <label for="precio" class="form-label">Precio</label>
                                                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                                                        @error('precio')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <!-- Cantidad Disponible -->
                                                    <div class="mb-3">
                                                        <label for="cantidad_disponible" class="form-label">Cantidad Disponible</label>
                                                        <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible" required>
                                                        @error('cantidad_disponible')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                  <!-- Categoría -->
<div class="mb-3">
    <label for="categoria" class="form-label">Categoría</label>
    <input type="text" class="form-control" id="categoria" name="categoria" required oninput="validateCategoria(this)">
    @error('categoria')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateCategoria(input) {
    // Permite solo letras y espacios
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                                                  <!-- Tamaño -->
<div class="mb-3">
    <label for="tamaño" class="form-label">Tamaño</label>
    <input type="text" class="form-control" id="tamaño" name="tamaño" required oninput="validateTamaño(this)">
    @error('tamaño')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateTamaño(input) {
    // Permite letras, números y espacios
    input.value = input.value.replace(/[^A-Za-z0-9\s]/g, '');
}
</script>

                                                  <!-- Modelo -->
<div class="mb-3">
    <label for="modelo" class="form-label">Modelo</label>
    <input type="text" class="form-control" id="modelo" name="modelo" required oninput="validateModelo(this)">
    @error('modelo')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateModelo(input) {
    // Permite solo letras y espacios
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                                                    <!-- Estado -->
<div class="mb-3">
    <label for="estado" class="form-label">Estado</label>
    <input type="text" class="form-control" id="estado" name="estado" required oninput="validateEstado(this)">
    @error('estado')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateEstado(input) {
    // Permite solo letras y espacios
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                                                    <!-- Botón de Envío -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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

    <!-- Modal para Ingresar Producto -->
    <div class="modal fade" id="ModalIngresarProducto" tabindex="-1" aria-labelledby="ModalIngresarProductoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content border-primary shadow-lg">
                <!-- Encabezado del Modal -->
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Producto</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Cuerpo del Modal -->
                <div class="modal-body">
                    <div class="container mt-3">
                        <form method="POST" action="{{ route('Productos.store') }}">
                            @csrf
                            <!-- SUCURSAL -->
                            <div class="mb-3">
                                <label for="Id_sucursal" class="form-label">Sucursal</label>
                                <select class="form-control" id="Id_sucursal" name="Id_sucursal" required>
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{ $sucursal->Id_sucursal }}">{{ $sucursal->Nombre_sucursal }}</option>
                                    @endforeach
                                </select>
                                @error('Id_sucursal')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Tipo de Producto -->
<div class="mb-3">
    <label for="tipo_producto" class="form-label">Tipo Producto</label>
    <select class="form-control" id="tipo_producto" name="tipo_producto" required>
        <option value="" disabled selected>Seleccione el tipo de producto</option>
        <option value="Ataúd">Ataúd</option>
        <option value="Mortaja">Mortaja</option>
        <!-- Agrega más opciones aquí si es necesario -->
    </select>
    @error('tipo_producto')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

                            <!-- Nombre del Producto -->
<div class="mb-3">
    <label for="nombre_producto" class="form-label">Nombre Producto</label>
    <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required oninput="validateNombreProducto(this)">
    @error('nombre_producto')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateNombreProducto(input) {
    // Permite solo letras y espacios
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                          <!-- Descripción -->
<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea class="form-control" id="descripcion" name="descripcion" oninput="validateDescripcion(this)"></textarea>
    @error('descripcion')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateDescripcion(input) {
    // Permite solo letras, números, espacios y saltos de línea
    input.value = input.value.replace(/[^A-Za-z0-9\s\n]/g, '');
}
</script>

                            <!-- Precio -->
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                                @error('precio')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Cantidad Disponible -->
                            <div class="mb-3">
                                <label for="cantidad_disponible" class="form-label">Cantidad Disponible</label>
                                <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible" required>
                                @error('cantidad_disponible')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Categoría -->
<div class="mb-3">
    <label for="categoria" class="form-label">Categoría</label>
    <input type="text" class="form-control" id="categoria" name="categoria" required oninput="validateCategoria(this)">
    @error('categoria')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateCategoria(input) {
    // Permite solo letras y espacios
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                            <!-- Tamaño -->
<div class="mb-3">
    <label for="tamaño" class="form-label">Tamaño</label>
    <input type="text" class="form-control" id="tamaño" name="tamaño" required oninput="validateTamaño(this)">
    @error('tamaño')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateTamaño(input) {
    // Permite letras, números y espacios
    input.value = input.value.replace(/[^A-Za-z0-9\s]/g, '');
}
</script>

                            <!-- Modelo -->
<div class="mb-3">
    <label for="modelo" class="form-label">Modelo</label>
    <input type="text" class="form-control" id="modelo" name="modelo" required oninput="validateModelo(this)">
    @error('modelo')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateModelo(input) {
    // Permite solo letras y espacios
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                            <!-- Estado -->
<div class="mb-3">
    <label for="estado" class="form-label">Estado</label>
    <input type="text" class="form-control" id="estado" name="estado" required oninput="validateEstado(this)">
    @error('estado')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateEstado(input) {
    // Permite solo letras y espacios
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                            <!-- Botón de Envío -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Agregar Producto</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
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
        <script>
    $(document).ready(function() {
        // Cuando se hace clic en cualquier botón de edición
        $('button[data-bs-target^="#editProductoModal"]').on('click', function() {
            // Extraer los valores de los atributos data-* del botón
            var id = $(this).data('id');
            var tipo = $(this).data('tipo');
            var nombre = $(this).data('nombre');
            var descripcion = $(this).data('descripcion');
            var precio = $(this).data('precio');
            var cantidad = $(this).data('cantidad');
            var categoria = $(this).data('categoria');
            var tamano = $(this).data('tamaño');
            var modelo = $(this).data('modelo');
            var estado = $(this).data('estado');

            // Asignar los valores a los campos del formulario en el modal
            var modal = $('#editProductoModal-' + id); // Seleccionar el modal específico por ID
            modal.find('#Id_sucursal').val(id); // Si hay campo de sucursal
            modal.find('#tipo_producto').val(tipo);
            modal.find('#nombre_producto').val(nombre);
            modal.find('#descripcion').val(descripcion);
            modal.find('#precio').val(precio);
            modal.find('#cantidad_disponible').val(cantidad);
            modal.find('#categoria').val(categoria);
        
            modal.find('#modelo').val(modelo);
            modal.find('#estado').val(estado);
        });
    });
</script>





@stop
