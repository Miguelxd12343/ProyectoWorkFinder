<?php require_once "../../Controlador/voluntarioControlador.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Voluntario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Buscar Voluntario por Cédula</h2>
    <form method="POST">
        <label for="cedula">Cédula:</label>
        <input type="text" name="cedula" required>
        <button type="submit">Buscar</button>
    </form>

    <?php if (isset($voluntario) && $voluntario): ?>
        <h3>Resultados:</h3>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($voluntario['Vol_Nombre']) ?></p>
        <p><strong>Apellido:</strong> <?= htmlspecialchars($voluntario['Vol_Apellido']) ?></p>
        <p><strong>Correo:</strong> <?= htmlspecialchars($voluntario['Vol_Correo']) ?></p>
        <p><strong>Celular:</strong> <?= htmlspecialchars($voluntario['Vol_Celular']) ?></p>
        <p><strong>Caso ID:</strong> <?= htmlspecialchars($voluntario['Vol_Caso_Id']) ?></p>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No se encontró ningún voluntario con esa cédula.</p>
    <?php endif; ?>
</body>
</html>
