@extends('adminlte::page')

@section('title', 'Carrozas Fúnebres')

@section('content_header')
    <h2>CARROZAS FÚNEBRES</h2>
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
                <!-- Botón de Agregar Carroza -->
                <div class="dropdown p-3">
                    @can('crear-inventario')
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalIngresarCarroza">
                        Agregar Carroza
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
                            <th>Sucursal</th>
                            <th>Placa</th>
                            <th>Cantidad Disponible</th>
                            <th>Fecha de Entrada</th>
                            <th>Detalle</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($carrozas as $carroza)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $carroza->nombre_sucursal }}</td>
                            <td>{{ $carroza->placa }}</td>
                            <td>{{ $carroza->cantidad_disponible }}</td>
                            <td>{{ $carroza->fecha_entrada }}</td>
                            <td>{{ $carroza->detalle_carroza }}</td>
                            <td>{{ $carroza->precio_carroza }}</td>
                            <td>
                                @can('editar-inventario')
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCarrozaModal-{{ $carroza->id_carroza }}">
                                <i class="fas fa-edit text-dark-blue"></i>
                                </button>
                                @endcan
                                
                                <!-- Otros botones -->
                            </td>
                        </tr>
                        <!-- Modal de Edición -->
                        @if(isset($carroza->id_carroza))
                          <div class="modal fade" id="editCarrozaModal-{{ $carroza->id_carroza }}" tabindex="-1" aria-labelledby="editCarrozaModalLabel-{{ $carroza->id_carroza }}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content border-primary shadow-lg">
                                    <!-- Encabezado del Modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar Carroza</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Cuerpo del Modal -->
                                    <div class="modal-body">
                                        <div class="container mt-3">
                                            <form action="{{ route('Carrozas.update', $carroza->id_carroza) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                 <!-- SUCURSAL -->
                                <div class="mb-3">
                                    <label for="Id_sucursal" class="form-label">sucursal</label>
                                    <select class="form-select" id="Id_sucursal" name="Id_sucursal" required>
                                        @foreach($sucursales as $sucursal)
                                            <option value="{{ $sucursal->Id_sucursal }}">{{ $sucursal->Nombre_sucursal }}</option>
                                        @endforeach
                                    </select>
                                    @error('Id_sucursal')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
    <label for="placa" class="form-label">Placa</label>
    <input type="text" class="form-control" id="placa" name="placa" value="{{ $carroza->placa }}" required oninput="validatePlaca(this)">
    @error('placa')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validatePlaca(input) {
    // Permite solo letras y números
    input.value = input.value.replace(/[^A-Za-z0-9]/g, '');
}
</script>

                                                <!-- Cantidad Disponible -->
                                                <div class="mb-3">
                                                    <label for="cantidad_disponible" class="form-label">Cantidad Disponible</label>
                                                    <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible" value="{{ $carroza->cantidad_disponible }}" required>
                                                    @error('cantidad_disponible')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
<!-- Detalle -->
<div class="mb-3">
    <label for="detalle_carroza" class="form-label">Detalle</label>
    <textarea class="form-control" id="detalle_carroza" name="detalle_carroza" required oninput="validateDetalle(this)">{{ $carroza->detalle_carroza }}</textarea>
    @error('detalle_carroza')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateDetalle(input) {
    // Permite solo letras y espacios
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>

                                                <!-- Precio -->
                                                <div class="mb-3">
                                                    <label for="precio_carroza" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="precio_carroza" name="precio_carroza" step="0.01" value="{{ $carroza->precio_carroza }}" required>
                                                    @error('precio_carroza')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- Botón de Envío -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Actualizar Carroza</button>
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

    <!-- Modal para Ingresar Carroza -->
    <div class="modal fade" id="ModalIngresarCarroza" tabindex="-1" aria-labelledby="ModalIngresarCarrozaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content border-primary shadow-lg">
                <!-- Encabezado del Modal -->
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Carroza</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Cuerpo del Modal -->
                <div class="modal-body">
                    <div class="container mt-3">
                        <form method="POST" action="{{ route('Carrozas.store') }}">
                            @csrf
                                            <!-- SUCURSAL -->
                                            <div class="mb-3">
                                    <label for="Id_sucursal" class="form-label">sucursal</label>
                                    <select class="form-select" id="Id_sucursal" name="Id_sucursal" required>
                                        @foreach($sucursales as $sucursal)
                                            <option value="{{ $sucursal->Id_sucursal }}">{{ $sucursal->Nombre_sucursal }}</option>
                                        @endforeach
                                    </select>
                                    @error('Id_sucursal')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
    <label for="placa" class="form-label">Placa</label>
    <input type="text" class="form-control" id="placa" name="placa" value="{{ $carroza->placa }}" required oninput="validatePlaca(this)">
    @error('placa')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validatePlaca(input) {
    // Permite solo letras y números
    input.value = input.value.replace(/[^A-Za-z0-9]/g, '');
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
<!-- Detalle -->
<div class="mb-3">
    <label for="detalle_carroza" class="form-label">Detalle</label>
    <textarea class="form-control" id="detalle_carroza" name="detalle_carroza" required oninput="validateDetalle(this)">{{ $carroza->detalle_carroza }}</textarea>
    @error('detalle_carroza')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
function validateDetalle(input) {
    // Permite solo letras y espacios
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
</script>


                            <!-- Precio -->
                            <div class="mb-3">
                                <label for="precio_carroza" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="precio_carroza" name="precio_carroza" step="0.01" required>
                                @error('precio_carroza')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Botón de Envío -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Agregar Carroza</button>
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
@stop
