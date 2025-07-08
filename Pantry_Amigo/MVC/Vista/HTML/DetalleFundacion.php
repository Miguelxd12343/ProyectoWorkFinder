<?php
include '../../Modelo/ConexionBD.php';

// Obtener el ID de la fundación desde la URL
if (isset($_GET['id'])) {
  $fundacionId = $_GET['id'];

  // Conexión a la base de datos
  $conexion = new ConexionBD();
  $conn = $conexion->conexion;

  try {
    // Consulta para obtener los detalles de la fundación por ID
    $sql = "
            SELECT
                Fund_Id             AS ID,
                Fund_Correo         AS Correo,
                Fund_Username       AS Nombre,
                Fund_Direccion      AS Direccion,
                Fund_Descripcion  AS Descripcion,
                Fund_Telefono       AS Telefono
            FROM tbl_fundaciones
            WHERE Fund_Usu_Id = :id
        ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $fundacionId, PDO::PARAM_INT);
    $stmt->execute();

    $fundacion = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no se encuentra la fundación
    if (!$fundacion) {
      echo "<p>Fundación no encontrada.</p>";
      exit;
    }
  } catch (PDOException $e) {
    echo "<p>Error al cargar los detalles de la fundación: " . $e->getMessage() . "</p>";
    exit;
  }
} else {
  echo "<p>El ID de la fundación no está disponible.</p>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Detalles de la Fundación</title>
  <link rel="stylesheet" href="../CSS/estilosDetallesFundacion.css" />
</head>
<body>

  <header>
    <nav>
      este es el navegador
    </nav>
  </header>

  <main class="container">

  <div class="cards">
    <div class="profile-card">

    <div class="fundacion-detalles">

      <h2><?php echo htmlspecialchars($fundacion['Nombre']); ?></h2>
      <p><strong>Correo:</strong> <?php echo htmlspecialchars($fundacion['Correo']); ?></p>
      <p><strong>Dirección:</strong> <?php echo htmlspecialchars($fundacion['Direccion']); ?></p>
      <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($fundacion['Telefono']); ?></p>
      <p><strong>Descripcion: </strong> <?php echo htmlspecialchars($fundacion['Descripcion']); ?></p>
    </div>

    </div>

    <div class="cases-card">

    </div>

    </div>

    <a href="Fundaciones.php" class="volver-btn">Explorar mas fundaciones</a>
  </main>
</body>

</html>