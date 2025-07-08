<?php
// Incluir el archivo de conexión
include '../../Modelo/ConexionBD.php';

// Crear la instancia y abrir conexión
$conexion = new ConexionBD();
if (!$conexion->abrir()) {
    echo json_encode(["error" => "Error al conectar a la base de datos"]);
    exit;
}

// Consulta para obtener casos de dinero con voluntariado
$sqlDinero = "SELECT * FROM Tbl_Casos_Dinero WHERE Caso_Voluntariado = 1";
if (!$conexion->consulta($sqlDinero)) {
    echo json_encode(["error" => "Error al consultar los casos de dinero"]);
    exit;
}
$resultadoDinero = $conexion->obtenerResult();
$voluntariadosDinero = [];
while ($fila = $resultadoDinero->fetch_assoc()) {
    $fila['tipo'] = 'dinero'; // Agregar tipo para identificar como caso de dinero
    $voluntariadosDinero[] = $fila;
}

/*// Consulta para obtener casos de recursos con voluntariado
$sqlRecursos = "SELECT * FROM Tbl_Casos_Recursos WHERE Caso_Voluntariado = 1";
if (!$conexion->consulta($sqlRecursos)) {
    echo json_encode(["error" => "Error al consultar los casos de recursos"]);
    exit;
}*/
$resultadoRecursos = $conexion->obtenerResult();
$voluntariadosRecursos = [];
while ($fila = $resultadoRecursos->fetch_assoc()) {
    $fila['tipo'] = 'recurso'; // Agregar tipo para identificar como caso de recurso
    $voluntariadosRecursos[] = $fila;
}

// Combinar ambos resultados
$voluntariados = array_merge($voluntariadosDinero, $voluntariadosRecursos);

// Devolver los resultados en formato JSON
echo json_encode($voluntariados);

// Cerrar la conexión
$conexion->cerrar();
?>



