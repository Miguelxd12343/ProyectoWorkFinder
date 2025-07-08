<?php
require_once '../Modelo/Caso.php';
require_once '../Modelo/ConexionBD.php';

$caso = new Caso();

$nombre = "Caso Test Unitario";
$descripcion = "Este es un caso de prueba unitaria";
$montoMeta = 5000;
$montoRecaudado = 0;
$fechaInicio = date('Y-m-d');
$fechaFin = date('Y-m-d', strtotime('+30 days'));
$estado = "Activo";
$imagen = null;
$voluntariado = 1;
$fundacionId = 13;
$categoriaNombre = "Salud";



$insertado = $caso->registrarCasoDinero(
    $nombre,
    $descripcion,
    $montoMeta,
    $montoRecaudado,
    $fechaInicio,
    $fechaFin,
    $estado,
    $imagen,
    $voluntariado,
    $fundacionId,
    $categoriaNombre
);

if ($insertado) {
    echo " Se insertó un nuevo caso de donacion (dinero).\n";

    // Paso 2: Verificar si el caso realmente se guardó
    $conexion = new ConexionBD();
    if ($conexion->abrir()) {
        $sql = "SELECT * FROM tbl_casos_dinero WHERE Caso_Nombre = '$nombre'";
        $resultado = $conexion->consulta($sql);


        $conexion->cerrar();
    } 
}
?>
