<?php
include 'conexionBD.php';

if (isset($_GET['id'])) {
    $fundacionID = $_GET['id'];

    $sql = "SELECT * FROM Tbl_Fundacion WHERE Fund_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $fundacionID);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $fundacion = $resultado->fetch_assoc();
    } else {
        echo "Fundación no encontrada.";
        exit;
    }
} else {
    echo "ID de fundación no proporcionado.";
    exit;
}
?>
