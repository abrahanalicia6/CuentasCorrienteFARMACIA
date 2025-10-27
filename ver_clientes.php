<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clientes y Saldos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-success text-center mb-4">👥 Lista de Clientes y Cuentas Corrientes</h2>

    <table class="table table-bordered table-striped text-center align-middle">
      <thead class="table-success">
        <tr>
          <th>Nombre</th>
          <th>DNI</th>
          <th>Dirección</th>
          <th>Teléfono</th>
          <th>Saldo Actual</th>
          <th>Disponible ($300.000 máx)</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $clientes = $conexion->query("SELECT * FROM clientes");
        while($c = $clientes->fetch_assoc()) {
            $id = $c['id'];
            $res = $conexion->query("SELECT SUM(monto) AS total FROM cuentas_corrientes WHERE cliente_id=$id");
            $saldo = $res->fetch_assoc()['total'] ?? 0;
            $disponible = 300000 - $saldo;

            $colorSaldo = ($saldo > 300000) ? "text-danger fw-bold" : "text-dark";
            $colorDisp = ($disponible <= 0) ? "text-danger fw-bold" : "text-success fw-bold";

            echo "
            <tr>
              <td>{$c['nombre']}</td>
              <td>{$c['dni']}</td>
              <td>{$c['direccion']}</td>
              <td>{$c['telefono']}</td>
              <td class='$colorSaldo'>$" . number_format($saldo, 2) . "</td>
              <td class='$colorDisp'>$" . number_format($disponible, 2) . "</td>
            </tr>";
        }
        ?>
      </tbody>
    </table>

    <div class="text-center">
      <a href="index.php" class="btn btn-outline-secondary mt-3">⬅ Volver al menú</a>
    </div>
  </div>
</body>
</html>


