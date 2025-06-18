<?php
require_once(__DIR__ . '/conexion.php'); // Asegúrate que conexion.php esté bien configurado

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? null;
    $email = $_POST['email'] ?? null;
    $contrasena = isset($_POST['contrasena']) ? password_hash($_POST['contrasena'], PASSWORD_DEFAULT) : null;
    $rol = $_POST['rol'] ?? null;

    if ($nombre && $email && $contrasena && $rol) {
        try {
            $stmt = $pdo->prepare("INSERT INTO usuario (Nombre, Email, Contrasena, IdRol) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombre, $email, $contrasena, $rol]);

            // Redirige correctamente al HTML de éxito
            header("Location: ../HTML/RegistroExitoso.html");
            exit;

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
