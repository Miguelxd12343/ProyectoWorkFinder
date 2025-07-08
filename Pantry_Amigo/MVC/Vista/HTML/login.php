<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/styleee.css">
</head>

<body>
    <div class="bienvenida">Bienvenidos
    </div>
    <div class="container">
        <h1>Inicia Sesion</h1>
        <form action="../../Controlador/usuarioControlador.php" method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
                <span class="toggle-password" id="toggleIcon" onclick="togglePassword()">👁️</span>
            </div>
            <button type="submit" name="login">Iniciar Sesión</button>
            <div class="link-container">
                <a class="link" href="registro.php">Registrarse</a>
                <a class="link" href="recuperar.php">¿Olvidaste tu contraseña?</a>
            </div>
        </form>
    </div>
</body>
<script>
    function validarFormulario() {
        let password = document.getElementById("password").value;
        if (password.length < 6) {
            alert("La contraseña debe tener al menos 6 caracteres");
            return false;
        }
        return true;
    }

    function togglePassword() {
        let passwordField = document.getElementById("password");
        let icon = document.getElementById("toggleIcon");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.textContent = "🙈";
        } else {
            passwordField.type = "password";
            icon.textContent = "👁️";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        let inputs = document.querySelectorAll("input");
        inputs.forEach(input => {
            input.addEventListener("focus", function() {
                this.style.borderColor = "#007bff";
            });
            input.addEventListener("blur", function() {
                this.style.borderColor = "#ccc";
            });
        });
    });
</script>

</html>