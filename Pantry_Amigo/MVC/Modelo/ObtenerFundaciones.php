<?php
include_once "../Modelo/ConexionBD.php"; // ajusta según tu estructura

$sql = "SELECT Usu_Id, Usu_Username, Usu_Correo FROM tbl_Usuario WHERE Usu_Tipo = 'Usuario'";
$result = mysqli_query($conn, $sql);

$fundaciones = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $fundaciones[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($fundaciones);
?>
