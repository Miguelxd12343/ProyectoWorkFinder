<?php
session_start();
if(!isset($_SESSION["usuario"])){
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION["usuario"];
echo "Bienvenido, {$usuario['nombre']} {$usuario['apellido']} <br>";
echo "Rol: " . ($usuario["rol"] == 1 ? "cliente" : ($usuario["rol"] == 2 ? "vendedor" : "administrador")) . "<br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/styles.css">
    <title>login</title>
</head>
<body>
    <div>
        <button type="submit" value="cerrar cesion"><a href="../index.php?logout=1">Cerrar Sesion</a></button>
    </div>
</body>
</html>