@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
    <h1>Lista de Ventas</h1>
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
                <!-- Botón de Agregar Venta -->
                @can('crear-venta')
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalAgregarVenta">
                    Agregar Venta
                </button>
                @endcan

            </div>
        </div>

        <!-- Tabla de Ventas -->
        <div class="card">
            <div class="col-md-12">
                <table class="table table-striped table-bordered" id="ventasTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Empleado</th>
                            <th>Fecha Venta</th>
                            <th>Descripción Tipo Venta</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Descuento</th>
                            <th>ISV</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas as $index => $venta)
                            <tr>
                                <td>{{ $index + 1}}</td>
                                <td>{{ $venta->nombre_cliente }}</td>
                                <td>{{ $venta->nombre_producto }}</td>
                                <td>{{ $venta->nombre_empleado }}</td>
                                <td>{{ date('d/m/Y', strtotime($venta->fecha_venta)) }}</td>
                                <td>{{ $venta->descripcion_tipo_venta }}</td>
                                <td>{{ $venta->cantidad }}</td>
                                <td>{{ $venta->precio }}</td>
                                <td>{{ $venta->descuento }}</td>
                                <td>{{ $venta->ISV }}</td>
                                <td>{{ $venta->total }}</td>
                                <td>
                                   <!-- Botón para Editar Venta -->
                                    @can('editar-venta')
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#ModalEditarVenta"
                                    data-id="{{ $venta->id_venta }}"
                                    data-cantidad="{{ $venta->cantidad }}"
                                    data-precio="{{ $venta->precio }}"
                                    data-descuento="{{ $venta->descuento }}"
                                    data-isv="{{ $venta->ISV }}"
                                    data-descripcion_tipo_venta="{{ $venta->descripcion_tipo_venta }}"
                                    data-fecha_venta="{{ $venta->fecha_venta }}">
                                    <i class="fas fa-edit"></i> 
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para Agregar Venta -->
    <div class="modal fade" id="ModalAgregarVenta" tabindex="-1" aria-labelledby="ModalAgregarVentaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content border-primary shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalAgregarVentaLabel">Agregar Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ventas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="id_cliente" class="form-label">Cliente</label>
                            <select class="form-control" id="id_cliente" name="id_cliente" required>
                                <option value="" disabled selected>Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id_cliente }}">{{ $cliente->nombre_cliente }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_producto" class="form-label">Producto</label>
                            <select class="form-control" id="id_producto" name="id_producto" required>
                                <option value="" disabled selected>Seleccione un producto</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id_producto }}" data-precio="{{ $producto->precio }}">{{ $producto->nombre_producto }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_empleado" class="form-label">Empleado</label>
                            <select class="form-control" id="id_empleado" name="id_empleado" required>
                                <option value="" disabled selected>Seleccione un empleado</option>
                                @foreach($empleados as $empleado)
                                    <option value="{{ $empleado->id_empleado }}">{{ $empleado->nombre_empleado }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_venta" class="form-label">Fecha de Venta</label>
                            <input type="date" class="form-control" id="fecha_venta" name="fecha_venta" required>
                        </div>
                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="descuento" class="form-label">Descuento</label>
                            <input type="number" step="0.01" class="form-control" id="descuento" name="descuento" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="isv" class="form-label">ISV (%)</label>
                            <input type="number" step="0.01" class="form-control" id="isv" name="isv" min="0" value="15">
                        </div>
                        <div class="mb-3">
                            <label for="descripcion_tipo_venta" class="form-label">Descripción Tipo Venta</label>
                            <select class="form-control" id="descripcion_tipo_venta" name="descripcion_tipo_venta" required>
                                <option value="" disabled selected>Seleccione un tipo de venta</option>
                                <option value="Contado">Contado</option>
                                <option value="Credito">Credito</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Venta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Modal para Editar Venta -->
<div class="modal fade" id="ModalEditarVenta" tabindex="-1" aria-labelledby="ModalEditarVentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content border-primary shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditarVentaLabel">Editar Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ventas.update', 'venta_id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-select-id_cliente" class="form-label">Cliente</label>
                        <select class="form-control" id="edit-select-id_cliente" name="id_cliente" required>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id_cliente }}">{{ $cliente->nombre_cliente }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-select-id_producto" class="form-label">Producto</label>
                        <select class="form-control" id="edit-select-id_producto" name="id_producto" required>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id_producto }}">{{ $producto->nombre_producto }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-select-id_empleado" class="form-label">Empleado</label>
                        <select class="form-control" id="edit-select-id_empleado" name="id_empleado" required>
                            @foreach($empleados as $empleado)
                                <option value="{{ $empleado->id_empleado }}">{{ $empleado->nombre_empleado }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="edit-cantidad" name="cantidad" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-precio" class="form-label">Precio</label>
                        <input type="number" step="0.01" class="form-control" id="edit-precio" name="precio" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-descuento" class="form-label">Descuento</label>
                        <input type="number" step="0.01" class="form-control" id="edit-descuento" name="descuento" min="0">
                    </div>
                    <div class="mb-3">
                        <label for="edit-isv" class="form-label">ISV</label>
                        <input type="number" step="0.01" class="form-control" id="edit-isv" name="isv" min="0">
                    </div>
                    <div class="mb-3">
                        <label for="edit-descripcion_tipo_venta" class="form-label">Tipo de Venta</label>
                        <select class="form-control" id="edit-descripcion_tipo_venta" name="descripcion_tipo_venta" required>
                            <option value="Contado">Contado</option>
                            <option value="Credito">Crédito</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Venta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Versión</b> 1.0
    </div>
    <strong>&copy; 2024 <a href="#">Ataudes Josue 1:9</a>.</strong> Todos los derechos reservados.
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
    $('#ventasTable').DataTable({
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

    // Manejo del modal de edición
    $('#ModalEditarVenta').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id');
        var idCliente = button.data('id_cliente');
        var idProducto = button.data('id_producto');
        var idEmpleado = button.data('id_empleado');
        var cantidad = button.data('cantidad');
        var precio = button.data('precio');
        var descuento = button.data('descuento');
        var isv = button.data('isv');
        var descripcionTipoVenta = button.data('descripcion_tipo_venta');

        var modal = $(this);
        modal.find('form').attr('action', '/ventas/' + id); // Actualiza la URL del formulario
        modal.find('#edit-id').val(id);
        modal.find('#edit-select-id_cliente').val(idCliente);
        modal.find('#edit-select-id_producto').val(idProducto);
        modal.find('#edit-select-id_empleado').val(idEmpleado);
        modal.find('#edit-cantidad').val(cantidad);
        modal.find('#edit-precio').val(precio);
        modal.find('#edit-descuento').val(descuento);
        modal.find('#edit-isv').val(isv);
        modal.find('#edit-descripcion_tipo_venta').val(descripcionTipoVenta);
    });
});

    </script>
@stop
