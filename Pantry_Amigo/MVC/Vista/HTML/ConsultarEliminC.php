<?php
include 'conexionBD.php'; // Archivo de conexión a la BD
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Casos y Donaciones</title>
    <link rel="stylesheet" href="styles.css"> <!-- Archivo de estilos -->
</head>
<body>
    <h2>Consultar y Eliminar Casos</h2>
    <form method="POST" action="">
        <label for="caso_id">ID del Caso:</label>
        <input type="text" name="caso_id" required>
        <button type="submit" name="consultar">Consultar</button>
        <button type="submit" name="eliminar">Eliminar</button>
    </form>
    
    <?php
    if (isset($_POST['consultar'])) {
        $caso_id = $_POST['caso_id'];
        $query = "SELECT * FROM Tbl_Caso_Donacion WHERE Caso_Id = '$caso_id'";
        $result = mysqli_query($conn, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            echo "<p>Nombre: " . $row['Caso_Nombre_Caso'] . "</p>";
            echo "<p>Descripción: " . $row['Caso_Descripcion'] . "</p>";
        } else {
            echo "<p>No se encontró el caso.</p>";
        }
    }

    if (isset($_POST['eliminar'])) {
        $caso_id = $_POST['caso_id'];
        $delete_query = "DELETE FROM Tbl_Caso_Donacion WHERE Caso_Id = '$caso_id'";
        if (mysqli_query($conn, $delete_query)) {
            echo "<p>Caso eliminado correctamente.</p>";
        } else {
            echo "<p>Error al eliminar el caso.</p>";
        }
    }
    ?>

    <h2>Consultar Donaciones</h2>
    <form method="POST" action="">
        <button type="submit" name="ver_donaciones">Ver Donaciones</button>
    </form>

    <?php
    if (isset($_POST['ver_donaciones'])) {
        $query = "SELECT * FROM Tbl_Donacion_Recursos";
        $result = mysqli_query($conn, $query);
        echo "<table border='1'><tr><th>ID</th><th>Donante</th><th>Cantidad</th><th>Descripción</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['Rec_Id']}</td><td>{$row['Rec_Nombre_Donante']} {$row['Rec_Apellido_Donante']}</td><td>{$row['Rec_Cantidad']}</td><td>{$row['Rec_Descripcion']}</td></tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>
