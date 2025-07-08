<?php
require_once "../modelo/Producto.php";
session_start();

$producto = new Producto();
$productos = $producto->obtenerTodos();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Productos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .producto {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            max-width: 400px;
        }
        .producto h2 {
            margin: 0;
        }
    </style>
</head>
<body>
    <h1>Bienvenido a Mextium</h1>
    <a href="carrito.php">🛒 Ver Carrito</a> | 
    <?php if (isset($_SESSION['usuario_id'])): ?>
        <a href="../index.php?logout=1">Cerrar sesión</a>
    <?php else: ?>
        <a href="usuarios/login.php">Iniciar sesión</a>
    <?php endif; ?>
    <hr>

    <?php foreach ($productos as $prod): ?>
        <div class="producto">
            <h2><?= htmlspecialchars($prod['nombre']) ?></h2>
            <p><?= htmlspecialchars($prod['descripcion']) ?></p>
            <p>$<?= number_format($prod['precio'], 2) ?></p>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <form method="POST" action="../controladores/carritoControlador.php">
                    <input type="hidden" name="producto_id" value="<?= $prod['id'] ?>">
                    <input type="number" name="cantidad" value="1" min="1">
                    <button type="submit" name="agregar">Agregar al carrito</button>
                </form>
            <?php else: ?>
                <a href="usuarios/login.php">Inicia sesión para comprar</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
