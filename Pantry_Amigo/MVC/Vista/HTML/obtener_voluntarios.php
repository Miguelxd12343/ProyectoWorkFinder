<?php
header('Content-Type: application/json; charset=utf-8');
include '../../Modelo/ConexionBD.php';

$conn = (new ConexionBD())->conexion;

try {
    $sql = "
      SELECT
        Vol_Nombre,
        Vol_Cedula,
        Vol_Apellido,
        Vol_Correo,
        Vol_Celular,
        Vol_Caso_Id,
        Vol_Caso_Tipo
      FROM tbl_voluntarios
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
