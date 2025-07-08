<!DOCTYPE html>
<html>
<head>
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../CSS/styleee.css">
</head>
<body>
<div class="container">
    <h1>Recupera Contraseña</h1>
    <form action="../../Controlador/usuarioControlador.php" method="POST">
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="password" name="new_password" placeholder="Nueva Contraseña" required>
        <button type="submit" name="reset_password">Restablecer Contraseña</button>
    </form>
    </div>
</body>
</html>