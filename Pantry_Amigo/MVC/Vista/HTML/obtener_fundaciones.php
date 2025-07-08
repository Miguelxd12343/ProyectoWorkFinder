<?php
header('Content-Type: application/json; charset=utf-8');
include '../../Modelo/ConexionBD.php';

$conexion = new ConexionBD();
$conn = $conexion->conexion;

try {
    $sql = "
      SELECT
        Fund_Id             AS ID,
        Fund_Correo         AS Correo,
        Fund_Username       AS Nombre,
        Fund_Direccion      AS Direccion,
        Fund_Casos_Activos  AS CasosActivos,
        Fund_Telefono       AS Telefono
      FROM tbl_fundaciones
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $fundaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($fundaciones);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
