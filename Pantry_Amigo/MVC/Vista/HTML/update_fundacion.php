<?php
header('Content-Type: application/json; charset=utf-8');
include '../../Modelo/ConexionBD.php';
$conn = (new ConexionBD())->conexion;

try {
    $id        = $_POST['id'];
    $nombre    = $_POST['Nombre'];
    $correo    = $_POST['Correo'];
    $telefono  = $_POST['Telefono'];
    $direccion = $_POST['Direccion'];
    $casos     = $_POST['CasosActivos'];

    $sql = "UPDATE tbl_fundaciones
            SET Fund_Username      = :nombre,
                Fund_Correo        = :correo,
                Fund_Telefono      = :telefono,
                Fund_Direccion     = :direccion,
                Fund_Casos_Activos = :casos
            WHERE Fund_Id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre',    $nombre);
    $stmt->bindParam(':correo',    $correo);
    $stmt->bindParam(':telefono',  $telefono);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':casos',     $casos, PDO::PARAM_INT);
    $stmt->bindParam(':id',        $id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['success'=>true, 'message'=>'Fundación actualizada correctamente']);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
