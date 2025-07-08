<?php
include 'Controlador.php';

$casos = [];
$mostrar_tabla = false;
$mensaje = "";

if (isset($_GET['buscar_caso']) && !empty($_GET['buscar_caso'])) {
    $caso_id = $_GET['buscar_caso'];
    $sql = "SELECT * FROM Tbl_Caso_Donacion WHERE Caso_Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$caso_id]);
    $casos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($casos)) {
        $mostrar_tabla = true;
    } else {
        $mensaje = "No se encontró un caso con ID '{$caso_id}'.";
    }
}

// Eliminar el caso si se envía la solicitud
if (isset($_POST['eliminar_caso'])) {
    $caso_id_eliminar = $_POST['caso_id'];
    $sql_delete = "DELETE FROM Tbl_Caso_Donacion WHERE Caso_Id = ?";
    $stmt_delete = $conn->prepare($sql_delete);

    if ($stmt_delete->execute([$caso_id_eliminar])) {
        $mensaje = "El caso con ID '{$caso_id_eliminar}' ha sido eliminado.";
        $mostrar_tabla = false;
    } else {
        $mensaje = "Error al eliminar el caso.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Caso de Donación</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">
    <h1>Eliminar Caso de Donación</h1>
    
    <h2>Consultar Caso</h2>
    <p>Ingresa el ID del caso de donación para buscarlo y eliminarlo.</p>
    
    <form action="ConsultarCasos.php" method="GET">
        <input type="text" name="buscar_caso" placeholder="Buscar por Caso_Id" required>
        <button type="submit">Buscar</button>
    </form>

    <?php if (!empty($mensaje)) : ?>
        <p class="mensaje"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <?php if ($mostrar_tabla) : ?>
        <h2>Detalles del Caso</h2>
        <table border ="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Monto Meta</th>
                <th>Descripción</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
            <?php foreach ($casos as $caso) : ?>
                <tr>
                    <td><?php echo $caso['Caso_Id']; ?></td>
                    <td><?php echo $caso['Caso_Nombre_Caso']; ?></td>
                    <td><?php echo $caso['Caso_Monto_Meta']; ?></td>
                    <td><?php echo $caso['Caso_Descripcion']; ?></td>
                    <td><?php echo $caso['Caso_Fecha_Inicio']; ?></td>
                    <td><?php echo $caso['Caso_Fecha_Fin']; ?></td>
                    <td><?php echo $caso['Caso_Estado']; ?></td>
                    <td>
                        <form action="index.php" method="POST">
                            <input type="hidden" name="caso_id" value="<?php echo $caso['Caso_Id']; ?>">
                            <button type="submit" name="eliminar_caso" onclick="return confirm('¿Seguro que deseas eliminar este caso?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
