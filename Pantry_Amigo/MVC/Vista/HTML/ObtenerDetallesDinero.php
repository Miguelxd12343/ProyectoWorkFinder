<?php
header('Content-Type: application/json');
require_once '../../Modelo/ConexionBD.php';
require_once '../../Modelo/FuncionesCaso.php';

if (!isset($_GET['ID'])) {
    echo json_encode(['error' => 'ID no especificado']);
    exit;
}

$casoId = $_GET['ID'];

$db = new ConexionBD();

if (!$db->abrir()) {
    echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
    exit;
}

$sql = "SELECT * FROM Tbl_Casos_Dinero WHERE Caso_Id = ?";
$params = [$casoId];

if (!$db->consulta($sql, $params)) {
    echo json_encode(['error' => 'Error al ejecutar la consulta']);
    $db->cerrar();
    exit;
}

$resultado = $db->obtenerResult();

if ($resultado->num_rows === 0) {
    echo json_encode(['error' => 'Caso no encontrado']);
} else {
    echo json_encode($resultado->fetch_assoc());
}

$db->cerrar();
?>
