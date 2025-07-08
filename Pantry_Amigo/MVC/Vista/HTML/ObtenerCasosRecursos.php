<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '/xampp/htdocs/Pantry_Amigo/MVC/Modelo/ConexionBD.php'; // Asegúrate de que la ruta sea correcta
header('Content-Type: application/json'); // Devuelve JSON

$conexion = new ConexionBD();
if (!$conexion->abrir()) {
    die(json_encode(["error" => "Error de conexión a la base de datos"]));
}
$metodo = $_SERVER['REQUEST_METHOD']; // Obtiene el método HTTP (GET, POST, etc.)

// Manejo de solicitudes
switch ($metodo) {
    case 'GET':
        // Leer casos activos
        if ($conexion->abrir()) {
            $sql = "SELECT * FROM tbl_casos_recursos WHERE Caso_Estado = 'Activo'";
            $conexion->consulta($sql);
            $result = $conexion->obtenerResult();
            $casos = [];
            while ($fila = $result->fetch_assoc()) {
                $casos[] = $fila;
            }
            echo json_encode($casos);
            $conexion->cerrar();
        } else {
            echo json_encode(["error" => "Error al conectar a la base de datos"]);
        }
        break;

    case 'POST':
        // Crear un nuevo caso
        $datos = json_decode(file_get_contents('php://input'), true);
        if ($conexion->abrir()) {
            $sql = "INSERT INTO tbl_casos_dinero (Caso_Nombre, Caso_Descripcion, Caso_Monto_Meta, Caso_Monto_Recaudado, Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Imagen, Caso_Voluntariado, Caso_Fund_Id, Caso_Cat_Nombre) 
                    VALUES ('{$datos['nombre']}', '{$datos['descripcion']}', {$datos['monto_meta']}, 0, '{$datos['fecha_inicio']}', '{$datos['fecha_fin']}', '{$datos['estado']}', '{$datos['imagen']}', {$datos['voluntariado']}, {$datos['fundacion_id']}, '{$datos['categoria']}')";
            $conexion->consulta($sql);
            echo json_encode(["mensaje" => "Caso creado correctamente"]);
            $conexion->cerrar();
        } else {
            echo json_encode(["error" => "Error al conectar a la base de datos"]);
        }
        break;

    case 'PUT':
        // Actualizar un caso existente
        $datos = json_decode(file_get_contents('php://input'), true);
        if ($conexion->abrir()) {
            $sql = "UPDATE tbl_casos_dinero 
                    SET Caso_Nombre = '{$datos['nombre']}', 
                        Caso_Descripcion = '{$datos['descripcion']}', 
                        Caso_Monto_Meta = {$datos['monto_meta']},
                        Caso_Fecha_Inicio = '{$datos['fecha_inicio']}', 
                        Caso_Fecha_Fin = '{$datos['fecha_fin']}', 
                        Caso_Estado = '{$datos['estado']}', 
                        Caso_Imagen = '{$datos['imagen']}',
                        Caso_Voluntariado = {$datos['voluntariado']},
                        Caso_Fund_Id = {$datos['fundacion_id']}, 
                        Caso_Cat_Nombre = '{$datos['categoria']}' 
                    WHERE Caso_Id = {$datos['id']}";
            $conexion->consulta($sql);
            echo json_encode(["mensaje" => "Caso actualizado correctamente"]);
            $conexion->cerrar();
        } else {
            echo json_encode(["error" => "Error al conectar a la base de datos"]);
        }
        break;

    case 'DELETE':
        // Eliminar un caso
        $id = $_GET['id']; // Obtén el ID del caso desde la URL
        if ($conexion->abrir()) {
            $sql = "DELETE FROM tbl_casos_dinero WHERE Caso_Id = $id";
            $conexion->consulta($sql);
            echo json_encode(["mensaje" => "Caso eliminado correctamente"]);
            $conexion->cerrar();
        } else {
            echo json_encode(["error" => "Error al conectar a la base de datos"]);
        }
        break;

    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>