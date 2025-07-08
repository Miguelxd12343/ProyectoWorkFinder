<?php
// Habilitar errores para depuración (puedes deshabilitarlo en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir la clase de conexión (ajusta la ruta según la ubicación de tu archivo)
require_once '/xampp/htdocs/Pantry-Amigo/MVC/Modelo/ConexionBD.php';

// Verificar que se haya enviado el parámetro "caso_id"
if (isset($_GET['caso_id'])) {
    $caso_id = $_GET['caso_id'];

    // Crear instancia y abrir la conexión
    $conexion = new ConexionBD();
    $conexion->abrir();

    // Preparar y ejecutar la consulta de eliminación
    $sql = "DELETE FROM tbl_casos_recursos WHERE Caso_Id = '$caso_id'";
    $conexion->consulta($sql);

    // Verificar si se afectó alguna fila (es decir, se eliminó el registro)
    if ($conexion->obtenerFilasAfectadas() > 0) {
        echo json_encode(['success' => true, 'message' => 'Caso eliminado correctamente.']);
    } else {
        // Puede ser que no se encuentre el caso o existan restricciones (integridad referencial)
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el caso. No se encontró el caso o existen registros relacionados.']);
    }
    $conexion->cerrar();
} else {
    echo json_encode(['success' => false, 'message' => 'ID de caso no proporcionado.']);
}
?>
