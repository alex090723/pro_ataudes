@extends('adminlte::page')

@section('title', 'Generar Reporte')

@section('content_header')
    <h1 class="text-center mb-4">Generación de Reportes</h1>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white">
            <h3 class="card-title">Seleccione los parámetros para el reporte</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('generar.reporte') }}" method="GET">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="pantalla">Seleccionar Tipo de Reporte:</label>
                        <select name="pantalla" id="pantalla" class="form-control custom-select">
                            <option value="persona">Persona</option>
                            <option value="ventas">Lista de Ventas</option>
                            <option value="cuenta_por_cobrar">Cuenta por Cobrar</option>
                            <option value="plan_de_pago">Plan de Pago</option>
                            <option value="historial_de_pagos">Historial de Pagos</option>
                            <option value="inventario_materiales">Inventario de Materiales</option>
                            <option value="carrozas_funebres">Carrozas Fúnebres</option>
                            <option value="productos">Productos</option>
                            <option value="users">Usuarios</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="periodo">Seleccionar Periodo:</label>
                        <select name="periodo" id="periodo" class="form-control custom-select">
                            <option value="dia">Día</option>
                            <option value="semana">Semana</option>
                            <option value="mes">Mes</option>
                            <option value="Todos los registros">Todos los Registros</option>
                        </select>
                    </div>
                </div>

                <div class="form-row mt-4">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-file-alt"></i> Generar Reporte
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
