<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? null;
    $email = $_POST['email'] ?? null;
    $contrasena = isset($_POST['contrasena']) ? password_hash($_POST['contrasena'], PASSWORD_DEFAULT) : null;
    $rol = $_POST['rol'] ?? null;

    if ($nombre && $email && $contrasena && $rol) {
        try {
            $stmt = $pdo->prepare("INSERT INTO usuario (Nombre, Email, Contrasena, IdRol) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombre, $email, $contrasena, $rol]);
            echo "¡Registro exitoso!";
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo "Error: El correo ya está registrado.";
            } else {
                echo "Error en el registro: " . $e->getMessage();
            }
        }
    } else {
        echo "Faltan datos del formulario.";
    }
} else {
    echo "Acceso no permitido.";
}
?>