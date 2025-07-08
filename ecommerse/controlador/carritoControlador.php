<?php
session_start();
require_once "../modelo/Carrito.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../vistas/usuarios/login.php");
    exit;
}

$carrito = new Carrito();
$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agregar'])) {
        $producto_id = $_POST['producto_id'];
        $cantidad = $_POST['cantidad'];

        $carrito->agregar($usuario_id, $producto_id, $cantidad);
        header("Location: ../vistas/carrito.php");
        exit;
    }

    if (isset($_POST['eliminar'])) {
        $producto_id = $_POST['producto_id'];

        $carrito->eliminar($usuario_id, $producto_id);
        header("Location: ../vistas/carrito.php");
        exit;
    }

    if (isset($_POST['vaciar'])) {
        $carrito->vaciar($usuario_id);
        header("Location: ../vistas/carrito.php");
        exit;
    }
}
