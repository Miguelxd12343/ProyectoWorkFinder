<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '/xampp/htdocs/Pantry_Amigo/MVC/Modelo/ConexionBD.php';
header('Content-Type: application/json');

$conexion = new ConexionBD();
$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET' && isset($_GET['ID'])) { // Debe coincidir con el nombre en la URL
    $id = $_GET['ID']; // No usar intval() porque es VARCHAR

    if ($conexion->abrir()) {
        // Usar consulta preparada para evitar SQL Injection
        $sql = "SELECT * FROM tbl_caso_donacion WHERE Caso_Id = :id LIMIT 1";
        $stmt = $conexion->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        
        $caso = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($caso) {
            echo json_encode($caso);
        } else {
            echo json_encode(["error" => "Caso no encontrado"]);
        }

        $conexion->cerrar();
    } else {
        echo json_encode(["error" => "Error al conectar a la base de datos"]);
    }
} else {
    echo json_encode(["error" => "Solicitud no válida"]);
}
?>
