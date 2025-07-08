<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '/xampp/htdocs/Pantry_Amigo/MVC/Modelo/ConexionBD.php';
header('Content-Type: application/json');

$conexion = new ConexionBD();
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        // Leer casos
        if ($conexion->abrir()) {
            // Selecciona solo los campos necesarios y los renombra para que coincidan con el frontend
            $sql = "SELECT 
                        Caso_Id,
                        Caso_Nombre_Caso AS Caso_Nombre,
                        Caso_Descripcion,
                        Caso_Fecha_Inicio,
                        Caso_Fecha_Fin,
                        CASE 
                            WHEN Caso_Estado = 1 THEN 'Activo' 
                            ELSE 'Inactivo' 
                        END AS Caso_Estado,
                        Caso_Punto_Recoleccion
                    FROM tbl_casos_recursos";

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
            $sql = "INSERT INTO tbl_casos_recursos (
                        Caso_Nombre_Caso, 
                        Caso_Descripcion, 
                        Caso_Fecha_Inicio, 
                        Caso_Fecha_Fin, 
                        Caso_Estado, 
                        Caso_Punto_Recoleccion,
                        Caso_Fund_Id, 
                        Caso_Acep_Vol
                    ) VALUES (
                        '{$datos['nombre']}', 
                        '{$datos['descripcion']}', 
                        '{$datos['fecha_inicio']}', 
                        '{$datos['fecha_fin']}', 
                        '{$datos['estado']}', 
                        '{$datos['punto_recoleccion']}',
                        {$datos['fundacion_id']}, 
                        {$datos['acepta_voluntarios']}
                    )";

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
            $sql = "UPDATE tbl_casos_recursos 
                    SET 
                        Caso_Nombre_Caso = '{$datos['nombre']}', 
                        Caso_Descripcion = '{$datos['descripcion']}', 
                        Caso_Fecha_Inicio = '{$datos['fecha_inicio']}', 
                        Caso_Fecha_Fin = '{$datos['fecha_fin']}', 
                        Caso_Estado = '{$datos['estado']}', 
                        Caso_Punto_Recoleccion = '{$datos['punto_recoleccion']}',
                        Caso_Fund_Id = {$datos['fundacion_id']}, 
                        Caso_Acep_Vol = {$datos['acepta_voluntarios']} 
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
        $id = $_GET['id'] ?? null;
        if ($id && $conexion->abrir()) {
            $sql = "DELETE FROM tbl_casos_recursos WHERE Caso_Id = $id";
            $conexion->consulta($sql);
            echo json_encode(["mensaje" => "Caso eliminado correctamente"]);
            $conexion->cerrar();
        } else {
            echo json_encode(["error" => "Error al eliminar el caso o ID inválido"]);
        }
        break;

    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
