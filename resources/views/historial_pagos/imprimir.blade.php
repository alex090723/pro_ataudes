<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impresión Historial de Pagos - {{ $nombrePersona }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ffffff; /* Fondo blanco */
            color: #000000; /* Texto negro */
            font-family: Arial, sans-serif;
            position: relative;
        }
        @media print {
            .no-print { display: none; }
            .container { margin: 0; }
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: #000000; /* Texto negro en la tabla */
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #000000; /* Bordes negros */
            color: #000000; /* Texto negro */
        }
        th {
            background-color: #f8f9fa; /* Color ligeramente gris para el encabezado */
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }
        .header img {
            position: absolute;
            top: 10px;
            left: 1100px; /* Posición original de la imagen */
            width: 250px; /* Tamaño original de la imagen */
            height: auto; /* Mantiene la proporción de la imagen */
        }
        .form-control, .btn {
           
            border-color: #000000; /* Bordes de los campos de formulario y botones en negro */
            color: #000000; /* Texto negro en los campos de formulario */
        }
        .btn-primary {
            position: absolute;
            bottom: -50px;
            background-color: #002942; /* Color de fondo del botón */
            border-color: #002942; /* Color del borde del botón */
            color: #ffffff; /* Texto del botón en blanco */
        }
        .btn-primary:hover {
            background-color: #001f3f; /* Color más oscuro para el botón al pasar el cursor */
            border-color: #001f3f; /* Color del borde del botón al pasar el cursor */
            color: #ffffff; /* Texto del botón en blanco */
        }
        .btn-primary:focus, .btn-primary:active {
            box-shadow: none; /* Eliminar sombra en el foco y el estado activo */
            border-color: #ffffff; /* Borde blanco en el estado activo */
        }
        .form-control:focus {
            border-color: #000000; /* Bordes de los campos de formulario al enfocar en negro */
            box-shadow: none;
            color: #000000; /* Texto negro en los campos de formulario */
        }
        .input-group .form-control, .input-group .btn {
            color: #000000; /* Texto negro en los campos de formulario y botón en el grupo de entrada */
        }
        .header, .no-print {
            background-color: #002942; /* Color de fondo para la parte superior del formulario */
        }
        .header h1, .no-print button {
            color: #ffffff; /* Texto blanco */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logotransparente.png') }}" alt="Logo">
            <h1>Historial de Pagos de {{ $nombrePersona }}</h1>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Pago</th>
                    <th>Fecha de Pago</th>
                    <th>Monto Pagado</th>
                    <th>Metodo de Pago</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historialDePagos as $pago)
                    <tr>
                        <td>{{ $pago->id_pago }}</td>
                        <td>{{ $pago->fecha_pago ? date('d/m/Y', strtotime($pago->fecha_pago)) : 'N/A' }}</td>
                        <td>{{ number_format($pago->monto_pago, 2) }}</td>
                        <td>{{ $pago->forma }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="no-print text-center mt-4">
            <button class="btn btn-primary" onclick="window.print();">Imprimir</button>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
