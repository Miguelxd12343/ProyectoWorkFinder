<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/styles.css">
    <title>Registro</title>
</head>

<body>
    <div class="container">
        <h1>Registro de Usuarios</h1>
        <form id="registroForm" method="POST" action="../../controlador/LoginControlador.php" >
            <input type="text" name="nombre" placeholder="nombre" id="nombre" required>
            <input type="text" name="apellido"  id="apellido" placeholder="apellido" required>
            <input type="number" name="cedula" placeholder="cedula" id="cedula" required>
            <input type="email" name="email" placeholder="correo electronico" id="email" required>
            <input type="number" name="telefono" placeholder="telefono" id="telefono" required>
            <input type="text" name="direccion" placeholder="direccion" id="direccion" required>
            <input type="password" name="password" placeholder="contraseña" id="password" required>
            <select name="rol" id="rol" required>
                <option value="">rol</option>
                <option value="1">cliente</option>
                <option value="2">vendedor</option>
                <option value="3">administrador</option>
            </select>
            <input type="submit" value="registrar" class="btn btn-primary" id="registrar">
        </form>
        <p><a href="login.php">ya tienes cuanta?</a></p>
    </div>

    <script src="../../public/js/registro.js"></script>
</body>

</html>