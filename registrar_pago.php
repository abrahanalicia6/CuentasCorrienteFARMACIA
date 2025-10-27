<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Pago</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-success text-center mb-4">💵 Registrar Pago del Cliente</h2>

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
        <label class="form-label">Monto del Pago</label>
        <input type="number" name="monto" class="form-control" step="0.01" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Descripción (opcional)</label>
        <input type="text" name="descripcion" class="form-control">
      </div>

      <button type="submit" name="registrar" class="btn btn-success w-100">Registrar Pago</button>

      <div class="text-center mt-3">
        <a href="index.php" class="btn btn-outline-secondary">⬅ Volver al menú</a>
      </div>
    </form>

    <?php
    if (isset($_POST['registrar'])) {
      $cliente_id = $_POST['cliente_id'];
      $monto = $_POST['monto'];
      $descripcion = $_POST['descripcion'];

      // Guardar el pago (resta al saldo)
      $sql = "INSERT INTO cuentas_corrientes (cliente_id, fecha, monto, descripcion, tipo)
              VALUES ($cliente_id, NOW(), -$monto, '$descripcion', 'pago')";
      if ($conexion->query($sql)) {
          echo "<div class='alert alert-success mt-4 text-center'>
                  ✅ Pago registrado correctamente.<br>
                  <b>Monto:</b> $" . number_format($monto, 2) . "
                </div>";
      } else {
          echo "<div class='alert alert-danger mt-4 text-center'>❌ Error: " . $conexion->error . "</div>";
      }
    }
    ?>
  </div>
</body>
</html>
