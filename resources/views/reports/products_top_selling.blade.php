<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte - Productos más vendidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Segoe UI", Tahoma, sans-serif;
            font-size: 14px;
        }
        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }
        .report-header p {
            margin: 0;
            font-size: 14px;
            color: #555;
        }
        table {
            font-size: 14px;
        }
        thead {
            background: #0d6efd;
            color: white;
        }
        tfoot {
            font-weight: bold;
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- ENCABEZADO -->
        <div class="report-header">
            <h2>Reporte de Productos Más Vendidos</h2>
            <p>Generado el {{ date('d/m/Y H:i') }}</p>
        </div>

        <!-- TABLA DE PRODUCTOS -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad Vendida</th>
                    <th>Total Generado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $index => $p)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->category->name ?? 'N/A' }}</td>
                    <td>${{ number_format($p->price, 2) }}</td>
                    <td>{{ $p->total_vendido }}</td>
                    <td>${{ number_format($p->price * $p->total_vendido, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end">TOTAL</td>
                    <td>{{ $productos->sum('total_vendido') }}</td>
                    <td>${{ number_format($productos->sum(fn($p) => $p->price * $p->total_vendido), 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
