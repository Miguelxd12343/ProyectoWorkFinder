<?php
require_once "../modelo/Carrito.php";
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: usuarios/login.php");
    exit;
}

$carrito = new Carrito();
$items = $carrito->obtenerItems($_SESSION['usuario_id']);
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mi Carrito</title>
</head>
<body>
    <h1>Carrito de Compras</h1>
    <a href="productos.php">← Volver a Productos</a> |
    <a href="../index.php?logout=1">Cerrar sesión</a>
    <hr>

    <?php if (empty($items)): ?>
        <p>No tienes productos en el carrito.</p>
    <?php else: ?>
        <form method="POST" action="../controladores/carritoControlador.php">
            <input type="hidden" name="vaciar" value="1">
            <button type="submit">Vaciar Carrito</button>
        </form>
        <br>

        <?php foreach ($items as $item): ?>
            <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                <h3><?= htmlspecialchars($item['nombre']) ?></h3>
                <p>Precio: $<?= number_format($item['precio'], 2) ?></p>
                <p>Cantidad: <?= $item['cantidad'] ?></p>
                <p>Subtotal: $<?= number_format($item['precio'] * $item['cantidad'], 2) ?></p>
                <form method="POST" action="../controladores/carritoControlador.php">
                    <input type="hidden" name="producto_id" value="<?= $item['producto_id'] ?>">
                    <button type="submit" name="eliminar">Eliminar</button>
                </form>
            </div>
            <?php $total += $item['precio'] * $item['cantidad']; ?>
        <?php endforeach; ?>

        <h2>Total: $<?= number_format($total, 2) ?></h2>
    <?php endif; ?>
</body>
</html>
