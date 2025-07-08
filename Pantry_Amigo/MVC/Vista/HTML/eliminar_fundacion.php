<?php
header('Content-Type: application/json; charset=utf-8');
include '../../Modelo/ConexionBD.php';
$conn = (new ConexionBD())->conexion;

if (isset($_GET['id'])) {
    try {
        // Fíjate en usar el nombre real de la columna:
        $stmt = $conn->prepare("DELETE FROM tbl_fundaciones WHERE Fund_Id = ?");
        $stmt->execute([$_GET['id']]);
        echo json_encode(['success' => true, 'message' => 'Fundación eliminada correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
}
?>
