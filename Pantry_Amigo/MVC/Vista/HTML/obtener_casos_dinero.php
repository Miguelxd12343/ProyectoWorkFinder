<?php
header('Content-Type: application/json; charset=utf-8');
include '../../Modelo/ConexionBD.php';
$conn = (new ConexionBD())->conexion;

try {
    $sql = "
      SELECT 
        Caso_Id,
        Caso_Nombre,
        Caso_Descripcion,
        Caso_Monto_Meta,
        Caso_Monto_Recaudado,
        Caso_Fecha_Inicio,
        Caso_Fecha_Fin,
        Caso_Estado,
        Caso_Imagen,
        Caso_Voluntariado,
        Caso_Fund_Id,
        Caso_Cat_Nombre
      FROM tbl_casos_dinero
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
