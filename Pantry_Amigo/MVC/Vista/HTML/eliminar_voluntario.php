<?php
header('Content-Type: application/json; charset=utf-8');
include '../../Modelo/ConexionBD.php';
if (!isset($_GET['cedula'])) {
    echo json_encode(['success' => false, 'message' => 'Falta cédula']);
    exit;
}
$conn = (new ConexionBD())->conexion;
try {
    $stmt = $conn->prepare("DELETE FROM tbl_voluntarios WHERE Vol_Cedula = ?");
    $stmt->execute([ $_GET['cedula'] ]);
    echo json_encode(['success' => true, 'message' => 'Voluntario eliminado']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
