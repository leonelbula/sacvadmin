<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte - Productos más vendidos por día</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: "Segoe UI", Tahoma, sans-serif; font-size: 14px; }
        .report-header { text-align: center; margin-bottom: 20px; }
        .report-header h2 { margin: 0; font-size: 22px; font-weight: bold; }
        thead { background: #0d6efd; color: white; }
        tfoot { font-weight: bold; background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="report-header">
            <h2>Reporte de Productos Más Vendidos por Día</h2>
            <p>Del {{ $fechaInicio }} al {{ $fechaFin }}</p>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad Vendida</th>
                    <th>Total Generado</th>
                </tr>
            </thead>
            <tbody>
                @php $totalGlobal = 0; @endphp
                @foreach($productos->groupBy('fecha') as $fecha => $items)
                    <tr>
                        <td colspan="6" class="table-secondary"><strong>{{ $fecha }}</strong></td>
                    </tr>
                    @foreach($items as $index => $p)
                        <tr>
                            <td></td>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $p->name }}</td>
                            <td>${{ number_format($p->price, 2) }}</td>
                            <td>{{ $p->total_vendido }}</td>
                            <td>${{ number_format($p->price * $p->total_vendido, 2) }}</td>
                        </tr>
                        @php $totalGlobal += $p->price * $p->total_vendido; @endphp
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-end">TOTAL GENERAL</td>
                    <td>${{ number_format($totalGlobal, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
