<?php
// Habilitar reporte de errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Indicar que la respuesta será en formato JSON
header('Content-Type: application/json');

// Incluir la conexión a la base de datos
include_once '../../Modelo/ConexionBD.php';

$response = ['success' => false, 'message' => 'Error desconocido.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que los datos necesarios existen
    $required_fields = ['Caso_Nombre', 'Caso_Descripcion', 'Caso_Monto_Meta', 'Caso_Cat_Id', 'Caso_Fecha_Inicio', 'Caso_Fecha_Fin'];
    $missing_fields = [];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        $response['message'] = 'Faltan campos requeridos: ' . implode(', ', $missing_fields);
    } else {
        $conn = new ConexionBD();
        $conexion = $conn->abrir();

        // Asignar variables desde POST
        $nombre = $_POST['Caso_Nombre'];
        $descripcion = $_POST['Caso_Descripcion'];
        $meta = $_POST['Caso_Monto_Meta'];
        $categoria_id = $_POST['Caso_Cat_Id'];
        $fecha_inicio = $_POST['Caso_Fecha_Inicio'];
        $fecha_fin = $_POST['Caso_Fecha_Fin'];
        
        // Asumimos un estado inicial 'Activo' y recaudado en 0
        $estado = 'Activo'; 
        $recaudado = 0;
        
        // Aquí debes obtener el Fund_Id de la sesión
        session_start();
        $fundacion_id = $_SESSION['Fund_Id'] ?? null; // Asegúrate de que 'Fund_Id' esté en la sesión

        if ($fundacion_id) {
            $sql = "INSERT INTO caso_de_dinero (Caso_Nombre, Caso_Descripcion, Caso_Monto_Meta, Caso_Monto_Recaudado, Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Cat_Id, Caso_Fund_Id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conexion->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssdissiii", $nombre, $descripcion, $meta, $recaudado, $fecha_inicio, $fecha_fin, $estado, $categoria_id, $fundacion_id);
                
                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = '¡Caso creado con éxito!';
                } else {
                    $response['message'] = 'Error al ejecutar la consulta: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $response['message'] = 'Error al preparar la consulta: ' . $conexion->error;
            }
        } else {
            $response['message'] = 'Error: No se pudo identificar la fundación. Inicie sesión de nuevo.';
        }
        $conn->cerrar();
    }
} else {
    $response['message'] = 'Método de solicitud no válido.';
}

echo json_encode($response);
exit();
?>