<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-success text-center mb-4">➕ Registrar Nuevo Cliente</h2>

    <form method="POST" class="mx-auto" style="max-width:500px;">
      <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">DNI</label>
        <input type="text" name="dni" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="direccion" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control">
      </div>
      <button type="submit" name="guardar" class="btn btn-success w-100">Guardar Cliente</button>
      <div class="text-center mt-3">
        <a href="index.php" class="btn btn-outline-secondary">⬅ Volver al menú</a>
      </div>
    </form>

    <?php
    if (isset($_POST['guardar'])) {
      $nombre = $_POST['nombre'];
      $dni = $_POST['dni'];
      $direccion = $_POST['direccion'];
      $telefono = $_POST['telefono'];

      $sql = "INSERT INTO clientes (nombre, dni, direccion, telefono)
              VALUES ('$nombre', '$dni', '$direccion', '$telefono')";
      if ($conexion->query($sql)) {
          echo "<div class='alert alert-success mt-4 text-center'>✅ Cliente agregado correctamente.</div>";
      } else {
          echo "<div class='alert alert-danger mt-4 text-center'>❌ Error: " . $conexion->error . "</div>";
      }
    }
    ?>
  </div>
</body>
</html>
