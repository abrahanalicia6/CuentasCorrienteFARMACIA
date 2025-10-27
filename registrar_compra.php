<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Compra</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-success text-center mb-4">🧾 Registrar Compra</h2>

    <form method="POST" class="mx-auto" style="max-width:500px;">
      <div class="mb-3">
        <label class="form-label">Cliente</label>
        <select name="cliente_id" class="form-select" required>
          <option value="">Seleccionar...</option>
          <?php
          $clientes = $conexion->query("SELECT * FROM clientes");
          while($c = $clientes->fetch_assoc()) {
              echo "<option value='{$c['id']}'>{$c['nombre']} (DNI: {$c['dni']})</option>";
          }
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Monto</label>
        <input type="number" name="monto" class="form-control" step="0.01" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Descripción</label>
        <input type="text" name="descripcion" class="form-control">
      </div>
      <button type="submit" name="registrar" class="btn btn-success w-100">Registrar Compra</button>
      <div class="text-center mt-3">
        <a href="index.php" class="btn btn-outline-secondary">⬅ Volver al menú</a>
      </div>
    </form>

    <?php
    if (isset($_POST['registrar'])) {
      $cliente_id = $_POST['cliente_id'];
      $monto = $_POST['monto'];
      $descripcion = $_POST['descripcion'];

      $resultado = $conexion->query("SELECT SUM(monto) AS total FROM cuentas_corrientes WHERE cliente_id=$cliente_id");
      $saldo_actual = $resultado->fetch_assoc()['total'] ?? 0;
      $nuevo_saldo = $saldo_actual + $monto;

      if ($nuevo_saldo > 300000) {
          echo "<div class='alert alert-danger mt-4 text-center'>
                  ⚠️ No se puede registrar: el cliente supera el límite de $300.000.<br>
                  <b>Saldo actual:</b> $" . number_format($nuevo_saldo, 2) . "
                </div>";
      } else {
          $sql = "INSERT INTO cuentas_corrientes (cliente_id, fecha, monto, descripcion)
                  VALUES ($cliente_id, NOW(), $monto, '$descripcion')";
          $conexion->query($sql);
          echo "<div class='alert alert-success mt-4 text-center'>
                  ✅ Compra registrada correctamente.<br>
                  <b>Nuevo saldo:</b> $" . number_format($nuevo_saldo, 2) . "
                </div>";
      }
    }
    ?>
  </div>
</body>
</html>

