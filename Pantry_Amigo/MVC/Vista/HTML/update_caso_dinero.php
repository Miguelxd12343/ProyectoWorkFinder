<?php
session_start();

// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../Modelo/ConexionBD.php';

// Validar método y sesión
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['id_fundacion'])) {
    echo json_encode(['success' => false, 'message' => 'Inválido: método no permitido o sesión no iniciada']);
    exit;
}

$conn = (new ConexionBD())->conexion;
$d = $_POST;

// Validar que todos los campos requeridos estén presentes
$campos_requeridos = [
    'Caso_Id',
    'Caso_Nombre',
    'Caso_Descripcion',
    'Caso_Monto_Meta',
    'Caso_Monto_Recaudado',
    'Caso_Fecha_Inicio',
    'Caso_Fecha_Fin',
    'Caso_Estado',
    'Caso_Cat_Nombre'
];

foreach ($campos_requeridos as $campo) {
    if (!isset($d[$campo])) {
        echo json_encode(['success' => false, 'message' => "Falta el campo requerido: $campo"]);
        exit;
    }
}

// Preparar y ejecutar la consulta UPDATE
try {
    $stmt = $conn->prepare("
        UPDATE tbl_casos_dinero SET
            Caso_Nombre = ?, 
            Caso_Descripcion = ?, 
            Caso_Monto_Meta = ?, 
            Caso_Monto_Recaudado = ?,
            Caso_Fecha_Inicio = ?, 
            Caso_Fecha_Fin = ?, 
            Caso_Estado = ?, 
            Caso_Imagen = ?,
            Caso_Voluntariado = ?, 
            Caso_Cat_Nombre = ?
        WHERE 
            Caso_Id = ? 
            AND Caso_Fund_Id = ?
    ");

    $stmt->execute([
        $d['Caso_Nombre'],
        $d['Caso_Descripcion'],
        $d['Caso_Monto_Meta'],
        $d['Caso_Monto_Recaudado'],
        $d['Caso_Fecha_Inicio'],
        $d['Caso_Fecha_Fin'],
        $d['Caso_Estado'],
        $d['Caso_Imagen'] ?? '',
        $d['Caso_Voluntariado'] ?? 0,
        $d['Caso_Cat_Nombre'],
        $d['Caso_Id'],
        $_SESSION['id_fundacion']
    ]);

    echo json_encode(['success' => true, 'message' => 'Caso de dinero actualizado correctamente']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $e->getMessage()]);
}
