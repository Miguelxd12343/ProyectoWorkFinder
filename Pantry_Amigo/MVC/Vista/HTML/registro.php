<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="../CSS/styleee.css">
</head>
<body>
<div class="container">
    <h1>Registrate</h1>
    <form action="../../Controlador/usuarioControlador.php" method="POST">
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="email" name="correo" placeholder="Correo" required>
        <select name="tipo">
            <option value="Usuario">Usuario</option>
            <option value="Administrador">Administrador</option>
        </select>
        <button type="submit" name="register">Registrarse</button>
    </form>
    </div>
</body>
</html>