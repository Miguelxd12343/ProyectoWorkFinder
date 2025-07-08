<?php
// /Pantry_Amigo/MVC/Vista/HTML/manejador_casos.php

ini_set('display_errors', 1); error_reporting(E_ALL);
header('Content-Type: application/json');

include_once '../../Modelo/ConexionBD.php';
session_start();

$response = ['success' => false, 'message' => 'Acción no válida o faltan datos.'];

if (!isset($_SESSION['Fund_Id'])) {
    $response['message'] = 'Error de Sesión: ID de fundación no encontrado.';
    echo json_encode($response);
    exit();
}
$fundacion_id = $_SESSION['Fund_Id'];

$conn = new ConexionBD();
$conexion = $conn->abrir();

// Función para obtener el ID de la categoría a partir del nombre
function getCategoriaId($nombreCategoria, $conexion) {
    $sql = "SELECT Caso_Cat_Id FROM caso_categoria WHERE Caso_Cat_Nombre = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $nombreCategoria);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($fila = $resultado->fetch_assoc()) {
        return $fila['Caso_Cat_Id'];
    }
    return 1; // ID por defecto si no se encuentra
}

if (isset($_POST['action'])) {
    // Campos comunes
    $nombre = $_POST['caso_nombre'] ?? null;
    $descripcion = $_POST['caso_descripcion'] ?? null;
    $meta = $_POST['caso_meta'] ?? null;
    $fecha_inicio = $_POST['caso_fecha_inicio'] ?? null;
    $fecha_fin = $_POST['caso_fecha_fin'] ?? null;
    $estado = $_POST['caso_estado'] ?? 'Activo';
    $categoria_nombre = $_POST['caso_categoria'] ?? null;
    $cat_id = getCategoriaId($categoria_nombre, $conexion);

    // Valores por defecto (no están en tus formularios)
    $imagen = 'default.jpg';
    $voluntariado = 0;

    if ($_POST['action'] === 'crear') {
        $recaudado = 0;
        $sql = "INSERT INTO caso_de_dinero (Caso_Nombre, Caso_Descripcion, Caso_Monto_Meta, Caso_Monto_Recaudado, Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Imagen, Caso_Voluntariado, Caso_Fund_Id, Caso_Cat_Id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssdissisiii", $nombre, $descripcion, $meta, $recaudado, $fecha_inicio, $fecha_fin, $estado, $imagen, $voluntariado, $fundacion_id, $cat_id);
    } 
    elseif ($_POST['action'] === 'actualizar') {
        $id = $_POST['caso_id'] ?? null;
        if ($id) {
            $sql = "UPDATE caso_de_dinero SET Caso_Nombre=?, Caso_Descripcion=?, Caso_Monto_Meta=?, Caso_Fecha_Inicio=?, Caso_Fecha_Fin=?, Caso_Cat_Id=?, Caso_Estado=? WHERE Caso_Id=? AND Caso_Fund_Id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssdssisii", $nombre, $descripcion, $meta, $fecha_inicio, $fecha_fin, $cat_id, $estado, $id, $fundacion_id);
        }
    }

    if (isset($stmt)) {
        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Operación realizada con éxito.'];
        } else {
            $response['message'] = 'Error en la base de datos: ' . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->cerrar();
echo json_encode($response);
?>