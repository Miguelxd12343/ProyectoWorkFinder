<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../../Modelo/ConexionBD.php';

$conn = (new ConexionBD())->conexion;

// Sólo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success'=>false,'message'=>'Método no permitido']);
    exit;
}

// Parámetros esperados
$citacion     = $_POST['Hora_Citacion']     ?? null;
$localizacion = $_POST['Hora_Localizacion'] ?? null;
$cedula       = $_POST['Hora_Vol_Cedula']   ?? null;

if (!$citacion || !$localizacion || !$cedula) {
    echo json_encode(['success'=>false,'message'=>'Faltan datos']);
    exit;
}

try {
    // NO incluimos Hora_Id en el INSERT
    $stmt = $conn->prepare("
      INSERT INTO tbl_horarios_voluntarios
        (Hora_Citacion, Hora_Localizacion, Hora_Vol_Cedula)
      VALUES (?, ?, ?)
    ");
    $stmt->execute([$citacion, $localizacion, $cedula]);

    echo json_encode(['success'=>true,'message'=>'Horario asignado correctamente']);
} catch (PDOException $e) {
    echo json_encode(['success'=>false,'message'=>$e->getMessage()]);
}
