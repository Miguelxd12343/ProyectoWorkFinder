<?php
include '../Usuario/config.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $numero = trim($_POST['numero']);

    // Validación básica
    if (empty($correo) || empty($numero)) {
        $mensaje = "Por favor, ingresa tu correo y número de contacto.";
    } else {
        // Buscar tienda por correo y teléfono
        $sql = "SELECT * FROM tiendas WHERE correo = ? AND telefono = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $correo, $numero);
        $stmt->execute();
        $result = $stmt->get_result();
        $tienda = $result->fetch_assoc();

        if ($tienda) {
            session_start();
            $_SESSION['tienda_id'] = $tienda['id'];
            $_SESSION['tienda_nombre'] = $tienda['nombre'];
            header("Location: indextienda.php");
            exit;
        } else {
            $mensaje = "Datos incorrectos. Verifica tu correo y número.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso a Tienda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, rgb(79, 22, 211) 0%, #e3e7ff 100%) !important;
        }
        .ingreso-box {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 0 24px #1800ad22;
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 400px;
            margin: 60px auto;
        }
        .mextium-header {
            background: linear-gradient(90deg, #1800ad 0%, #1800ad 100%);
            color: #fff;
            padding: 24px 0 16px 0;
            margin-bottom: 24px;
            border-radius: 0 0 18px 18px;
            text-align: center;
        }
        .mextium-header .logo-img {
            height: 54px;
            max-width: 180px;
            object-fit: contain;
            display: inline-block;
            margin-bottom: 0.5rem;
        }
        .mextium-header .titulo {
            font-size: 1.2rem;
            color: #e3e7ff;
            margin-top: 0.5rem;
        }
        .btn-mextium {
            background: #1800ad !important;
            color: #fff !important;
            border: none;
            font-weight: 600;
        }
        .btn-mextium:hover {
            background: #12007a !important;
            color: #fff !important;
        }
        .form-group label {
            color: #1800ad;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="mextium-header">
        <img src="../../img/logo.png" alt="Mextium" class="logo-img">
        <div class="titulo">Ingreso a tu Tienda</div>
    </div>
    <div class="ingreso-box">
        <h4 class="text-center mb-4 text-primary"><i class="fas fa-store"></i> Accede a tu Tienda</h4>
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-danger"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="correo"><i class="fas fa-envelope"></i> Correo de la tienda</label>
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo registrado" required>
            </div>
            <div class="form-group">
                <label for="numero"><i class="fas fa-phone"></i> Número de contacto</label>
                <input type="text" class="form-control" id="numero" name="numero" placeholder="Número registrado" required>
            </div>
            <button type="submit" class="btn btn-mextium btn-block mt-3">Ingresar</button>
        </form>
    </div>
</body>
</html>