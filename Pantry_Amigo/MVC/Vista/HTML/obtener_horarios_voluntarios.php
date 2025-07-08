<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../../Modelo/ConexionBD.php';

$conn = (new ConexionBD())->conexion;

try {
    $sql = "
      SELECT
        Hora_Id,
        Hora_Citacion,
        Hora_Localizacion,
        Hora_Vol_Cedula
      FROM tbl_horarios_voluntarios
      ORDER BY Hora_Id DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $horas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($horas);
} catch (PDOException $e) {
    echo json_encode(['error'=>$e->getMessage()]);
}
