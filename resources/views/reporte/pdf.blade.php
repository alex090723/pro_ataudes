<!DOCTYPE html>
<html>
<head>
    <title>Reporte</title>
    <style>
        /* Estilos personalizados para el PDF */
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 10px 0;
            text-align: center;
            flex: 1;
        }
        .header p {
            margin: 0;
            text-align: right;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px; /* Ajusta el tamaño del texto aquí */
            font-weight: bold; /* Si deseas que el texto sea negrita */
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        .table thead th {
            background-color: #007bff;
            color: #fff;
            padding: 8px;
            text-align: left;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .table, .th, .td {
            border: 1px solid #dee2e6;
        }
        .table td, .table th {
            padding: 8px;
            text-align: left;
            font-size: 10px; /* Ajusta el tamaño de la fuente */
        }
        .table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        @page {
            size: landscape; /* Configura la orientación horizontal para el PDF */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado del reporte -->
        <div class="header">
            <h1>Ataudes Josue 1:9</h1>
            <p>Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>

        <!-- Título del reporte -->
        <h1 class="title">Reporte de {{ ucfirst($pantalla) }}</h1>
        <p><strong>Periodo:</strong> {{ ucfirst($periodo) }}</p>

        <!-- Tabla del reporte -->
        <table class="table">
            <thead>
                <tr>
                    @if ($pantalla == 'persona')
                        <th>#</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Sexo</th>
                        <th>Edad</th>
                        <th>Estado Civil</th>
                        <th>Tipo</th>
                        <th>Usuario Registro</th>
                        <th>Fecha Registro</th>
                    @elseif ($pantalla == 'ventas')
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
                    @elseif ($pantalla == 'cuenta_por_cobrar')
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Factura</th>
                        <th>Fecha Factura</th>
                        <th>Monto Total</th>
                    @elseif ($pantalla == 'plan_de_pago')
                        <th>ID Plan Pago</th>
                        <th>Número de Factura</th>
                        <th>Nombre Cliente</th>
                        <th>Saldo Pendiente</th>
                        <th>Número de Cuotas</th>
                        <th>Monto por Cuota</th>
                        <th>Monto Abono</th>
                        <th>Fecha Vencimiento Cuotas</th>
                        <th>Estatus</th>
                    @elseif ($pantalla == 'historial_de_pagos')
                        <th>ID Pago</th>
                        <th>Cliente</th>
                        <th>Fecha de Pago</th>
                        <th>Total Pagado</th>
                        <th>Metodo de Pago</th>
                    @elseif ($pantalla == 'inventario_materiales')
                        <th>#</th>
                        <th>Proveedor</th>
                        <th>Tipo de Material</th>
                        <th>Cantidad Disponible</th>
                        <th>Fecha de Adquisición</th>
                        <th>Precio Unitario</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                    @elseif ($pantalla == 'carrozas_funebres')
                        <th>#</th>
                        <th>Sucursal</th>
                        <th>Placa</th>
                        <th>Cantidad Disponible</th>
                        <th>Fecha de Entrada</th>
                        <th>Detalle</th>
                        <th>Precio</th>
                    @elseif ($pantalla == 'productos')
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
                    @elseif ($pantalla == 'users')
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Fecha Creación</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $index => $dato)
                <tr>
                    @if ($pantalla == 'persona')
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $dato->Nombre_persona }}</td>
                        <td>{{ $dato->DNI_persona }}</td>
                        <td>{{ $dato->Sexo_persona }}</td>
                        <td>{{ $dato->Edad_persona }}</td>
                        <td>{{ $dato->Estado_Civil }}</td>
                        <td>{{ $dato->Tipo_persona }}</td>
                        <td>{{ $dato->Usuario_registro }}</td>
                        <td>{{ \Carbon\Carbon::parse($dato->Fecha_registro)->format('d/m/Y') }}</td>
                    @elseif ($pantalla == 'ventas')
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $dato->nombre_cliente }}</td>
                        <td>{{ $dato->nombre_producto }}</td>
                        <td>{{ $dato->nombre_empleado }}</td>
                        <td>{{ \Carbon\Carbon::parse($dato->fecha_venta)->format('d/m/Y') }}</td>
                        <td>{{ $dato->descripcion_tipo_venta }}</td>
                        <td>{{ $dato->cantidad }}</td>
                        <td>{{ $dato->precio }}</td>
                        <td>{{ $dato->descuento }}</td>
                        <td>{{ $dato->ISV }}</td>
                        <td>{{ $dato->total }}</td>
                    @elseif ($pantalla == 'cuenta_por_cobrar')
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $dato->nombre_cliente }}</td>
                        <td>{{ $dato->numero_factura }}</td>
                        <td>{{ \Carbon\Carbon::parse($dato->fecha_factura)->format('d/m/Y') }}</td>
                        <td>{{ $dato->monto_total }}</td>
                    @elseif ($pantalla == 'plan_de_pago')
                        <td>{{ $dato->id_plan_pago }}</td>
                        <td>{{ $dato->numero_factura }}</td>
                        <td>{{ $dato->nombre_cliente }}</td>
                        <td>{{ $dato->saldo_pendiente }}</td>
                        <td>{{ $dato->numero_cuotas }}</td>
                        <td>{{ $dato->monto_cuotas }}</td>
                        <td>{{ $dato->monto_abono }}</td>
                        <td>{{ $dato->fecha_vencimiento_cuotas }}</td>
                        <td>{{ $dato->estatus }}</td>
                    @elseif ($pantalla == 'historial_de_pagos')
                        <td>{{ $dato->id_pago }}</td>
                        <td>{{ $dato->nombre_persona }}</td>
                        <td>{{ \Carbon\Carbon::parse($dato->fecha_pago)->format('d/m/Y') }}</td>
                        <td>{{ $dato->monto_pago }}</td>
                        <td>{{ $dato->forma }}</td>

                    @elseif ($pantalla == 'inventario_materiales')
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $dato->Nombre_proveedor }}</td>
                        <td>{{ $dato->Tipo_material }}</td>
                        <td>{{ $dato->Cantidad_disponible }}</td>
                        <td>{{ \Carbon\Carbon::parse($dato->Fecha_Adquisicion)->format('d/m/Y') }}</td>
                        <td>{{ $dato->Precio_unitario }}</td>
                        <td>{{ $dato->Ubicacion }}</td>
                        <td>{{ $dato->Estado_material }}</td>

                    @elseif ($pantalla == 'carrozas_funebres')
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $dato->nombre_sucursal }}</td>
                        <td>{{ $dato->placa }}</td>
                        <td>{{ $dato->cantidad_disponible }}</td>
                        <td>{{ \Carbon\Carbon::parse($dato->fecha_entrada)->format('d/m/Y') }}</td>
                        <td>{{ $dato->detalle_carroza }}</td>
                        <td>{{ $dato->precio_carroza }}</td>
                    @elseif ($pantalla == 'productos')
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $dato->nombre_sucursal }}</td>
                        <td>{{ $dato->tipo_producto }}</td>
                        <td>{{ $dato->nombre_producto }}</td>
                        <td>{{ $dato->descripcion }}</td>
                        <td>{{ $dato->precio }}</td>
                        <td>{{ $dato->cantidad_disponible }}</td>
                        <td>{{ $dato->categoria }}</td>
                        <td>{{ $dato->tamaño }}</td>
                        <td>{{ $dato->modelo }}</td>
                        <td>{{ \Carbon\Carbon::parse($dato->created_at)->format('d/m/Y') }}</td>
                    @elseif ($pantalla == 'users')
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $dato->name }}</td>
                        <td>{{ $dato->email }}</td>
                        <td>{{ \Carbon\Carbon::parse($dato->created_at)->format('d/m/Y') }}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
