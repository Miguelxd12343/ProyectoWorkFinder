<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantry-Amigo</title>
    <link rel="stylesheet" href="../CSS/FormulaCaso.css">

    <body>
        <header>
            <nav>
                <div class="logo">
                    <img src="../IMG/Logo.png" alt="Logo">
                </div>
                <div class="menu">
                    <div class="menu-item-ubi">INICIO</div>
                    <div class="menu-item">CUENTA
                        <ul class="submenu">
                            <li><button><a href="../../../MVC/Vista/HTML/registrofrom.php">SIGN UP</a></button></li>
                            <li><button><a href="../../../MVC/Vista/HTML/IniciarSesionFrom.php">LOGIN</a></button></li>
                            
                        </ul>
                    </div>
                    <div class="menu-item">PARTICIPAR
                        <ul class="submenu">
                            <li>Casos</li>
                            <li>Donar</li>
                            <li>Fundaciones</li>
                            <li>Voluntariados</li>
                        </ul>
                    </div>
                    <div class="menu-item">INFO
                        <ul class="submenu">
                            <li>SOBRE NOSOTROS</li>
                            <li>FAQ</li>
                            <li>AYUDA</li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

<script>
    function showConfirmation(event) {
        event.preventDefault();
        document.getElementById('confirmationMessage').style.display = 'block';
    }
</script>
<body>
<div class="container">
    <h2>REGISTRO</h2>
    <form onsubmit="showConfirmation(event)">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" required>
        
        <label for="direccion">Dirección</label>
        <input type="text" id="direccion" name="direccion" required>
        
        <label for="cantidad">Cantidad</label>
        <input type="number" id="cantidad" name="cantidad" required>
        
        <button type="submit">ACEPTAR</button>
    </form>
 
</div>
</body>
</html>

