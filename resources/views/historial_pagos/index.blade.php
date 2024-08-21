@extends('adminlte::page')

@section('title', 'Historial de Pagos')

@section('content_header')
    <h1>Lista de Historial de Pagos</h1>
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
        <!-- Formulario para seleccionar el nombre y generar la impresión -->
        <div class="row mb-3">
            <div class="col-md-12">
                <form method="GET" action="{{ route('historial_pagos.imprimir') }}" target="_blank">
                    <div class="input-group">
                        <input type="text" name="nombre_persona" class="form-control" placeholder="Nombre del cliente" required>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">Imprimir</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de Historial de Pagos -->
        <div class="card">
            <div class="col-md-12">
                <table class="table table-striped table-bordered" id="historialPagosTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Fecha de Pago</th>
                            <th>Total Pagado</th>
                            <th>Metodo de Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historialDePagos as $index => $pago)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pago->nombre_persona }}</td>
                                <td>{{ $pago->fecha_pago ? date('d/m/Y', strtotime($pago->fecha_pago)) : 'N/A' }}</td>
                                <td>{{ number_format($pago->monto_pago, 2) }}</td>
                                <td>{{ $pago->forma }}</td>
                                <td>
                                    <!-- Aquí puedes añadir botones para otras acciones -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
            $('#historialPagosTable').DataTable({
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
