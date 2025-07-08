<?php
// Conexión a la base de datos
include '../../Modelo/ConexionBD.php';

// Consulta para obtener casos de dinero activos
$sqlDinero = "SELECT * FROM CasosDinero WHERE Caso_Estado = 'Activo'";
$resultDinero = $conn->query($sqlDinero);

$casosDinero = [];
if ($resultDinero->num_rows > 0) {
    while ($row = $resultDinero->fetch_assoc()) {
        $casosDinero[] = $row;
    }
}

// Consulta para obtener casos de recursos activos
$sqlRecursos = "SELECT * FROM CasosRecursos WHERE Caso_Estado = 'Activo'";
$resultRecursos = $conn->query($sqlRecursos);

$casosRecursos = [];
if ($resultRecursos->num_rows > 0) {
    while ($row = $resultRecursos->fetch_assoc()) {
        $casosRecursos[] = $row;
    }
}

// Devolver los datos como JSON
echo json_encode([
    'casosDinero' => $casosDinero,
    'casosRecursos' => $casosRecursos
]);
?>
