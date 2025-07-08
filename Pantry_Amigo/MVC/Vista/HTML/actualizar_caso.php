<?php
// Incluir el archivo de conexión
include '../Pantry_Amigo/MVC/Modelo/ConexionBD.php';

// Crear instancia de la clase y abrir la conexión
$conexionObj = new ConexionBD();
if ($conexionObj->abrir() === 0) {
    die("Error de conexión a la base de datos.");
}
$conexion = $conexionObj->getConexion();

// Verificar si se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar datos para evitar inyección SQL
    $caso_id = mysqli_real_escape_string($conexion, $_POST['caso_id']);
    $caso_nombre = mysqli_real_escape_string($conexion, $_POST['caso_nombre']);
    $caso_descripcion = mysqli_real_escape_string($conexion, $_POST['caso_descripcion']);
    $caso_estado = mysqli_real_escape_string($conexion, $_POST['caso_estado']);
    $caso_fecha_inicio = mysqli_real_escape_string($conexion, $_POST['caso_fecha_inicio']);
    $caso_fecha_fin = mysqli_real_escape_string($conexion, $_POST['caso_fecha_fin']);

    // Preparar la consulta SQL para actualizar el caso
    $query = "UPDATE tbl_casos_recursos SET 
                Caso_Nombre_Caso = '$caso_nombre', 
                Caso_Descripcion = '$caso_descripcion', 
                Caso_Estado = '$caso_estado', 
                Caso_Fecha_Inicio = '$caso_fecha_inicio', 
                Caso_Fecha_Fin = '$caso_fecha_fin' 
              WHERE Caso_Id = '$caso_id'";

    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => "El caso #$caso_id ha sido actualizado exitosamente."
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "Error al actualizar el caso: " . mysqli_error($conexion)
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => "Método de solicitud no válido."
    ]);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
