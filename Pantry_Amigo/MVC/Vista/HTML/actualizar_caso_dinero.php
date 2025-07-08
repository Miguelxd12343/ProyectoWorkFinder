<?php
// Habilitar reporte de errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Indicar que la respuesta será en formato JSON
header('Content-Type: application/json');

// Incluir la conexión a la base de datos
include_once '../../Modelo/ConexionBD.php';

$response = ['success' => false, 'message' => 'Error desconocido al actualizar.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que los datos necesarios existen
    $required_fields = ['id', 'Caso_Nombre', 'Caso_Descripcion', 'Caso_Monto_Meta', 'Caso_Cat_Id', 'Caso_Fecha_Inicio', 'Caso_Fecha_Fin'];
    // ... (puedes añadir la misma validación de campos que en el de registro)

    $conn = new ConexionBD();
    $conexion = $conn->abrir();

    // Asignar variables desde POST
    $id = $_POST['id'];
    $nombre = $_POST['Caso_Nombre'];
    $descripcion = $_POST['Caso_Descripcion'];
    $meta = $_POST['Caso_Monto_Meta'];
    $categoria_id = $_POST['Caso_Cat_Id'];
    $fecha_inicio = $_POST['Caso_Fecha_Inicio'];
    $fecha_fin = $_POST['Caso_Fecha_Fin'];

    $sql = "UPDATE caso_de_dinero SET Caso_Nombre = ?, Caso_Descripcion = ?, Caso_Monto_Meta = ?, Caso_Fecha_Inicio = ?, Caso_Fecha_Fin = ?, Caso_Cat_Id = ? WHERE Caso_Id = ?";
    
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssdssii", $nombre, $descripcion, $meta, $fecha_inicio, $fecha_fin, $categoria_id, $id);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = '¡Caso actualizado con éxito!';
            } else {
                $response['success'] = true; // No es un error si no se cambió nada
                $response['message'] = 'No se realizaron cambios o el caso no fue encontrado.';
            }
        } else {
            $response['message'] = 'Error al ejecutar la actualización: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = 'Error al preparar la actualización: ' . $conexion->error;
    }
    $conn->cerrar();
} else {
    $response['message'] = 'Método de solicitud no válido.';
}

echo json_encode($response);
exit();
?>