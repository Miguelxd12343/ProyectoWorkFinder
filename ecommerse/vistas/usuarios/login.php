

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/styles.css">
    <title>login</title>
</head>

<body>
    <div class="form-container">
        <h1>Inicion de Sesion</h1>
        <form id="loginForm" action="../../controlador/LoginControlador.php" method="POST">
            <input type="email" name="email" id="email" placeholder="Correo Electronico" required>
            <input type="password" name="Contraseña" id="password" placeholder="Contraseña">
            <input type="submit" name="login" value="ingresar">
        </form>
        <p><a href="registro.php">no tienes cuenta?</a></p>
    </div>

    <script src="../../public/js/login.js"></script>
</body>

</html>