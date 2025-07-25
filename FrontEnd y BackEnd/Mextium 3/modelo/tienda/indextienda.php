<?php
session_start();
include '../Usuario/config.php';

// Si no hay sesión de tienda, redirige al login de tienda
if (!isset($_SESSION['tienda_id'])) {
    header("Location: ingretienda.php");
    exit;
}

// Obtiene el nombre de la tienda desde la base de datos
$nombreTienda = '';
$tienda_id = $_SESSION['tienda_id'];
$sql = "SELECT nombre FROM tiendas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tienda_id);
$stmt->execute();
$stmt->bind_result($nombreTienda);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Mextium | Panel de Tienda</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, rgb(79, 22, 211) 0%, #e3e7ff 100%) !important;
            font-family: 'Roboto', Arial, sans-serif;
        }
        .panel-header {
            background: linear-gradient(90deg, #1800ad 0%, #1800ad 100%);
            color: #fff;
            border-radius: 0 0 24px 24px;
            padding: 2.5rem 0 1.5rem 0;
            text-align: center;
            margin-bottom: 2rem;
            box-shadow: 0 4px 24px rgba(24,0,173,0.10);
        }
        .panel-header .logo-mex,
        .panel-header .logo-tium {
            display: none;
        }
        .panel-header .logo-img {
            height: 54px;
            max-width: 180px;
            object-fit: contain;
            display: inline-block;
            margin-bottom: 0.5rem;
        }
        .panel-header .slogan {
            color: #e3e7ff;
            font-size: 1.2rem;
            margin-top: 10px;
            letter-spacing: 1px;
        }
        .panel-header .nombre-tienda {
            font-size: 1.7rem;
            font-weight: bold;
            color: #fff;
            margin-top: 10px;
            letter-spacing: 1px;
            text-shadow: 0 2px 8px #1800ad44;
        }
        .card-panel {
            border: none;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(24,0,173,0.10);
            transition: transform .15s;
        }
        .card-panel:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 8px 32px rgba(24,0,173,0.18);
        }
        .card-panel .card-title {
            color: #1800ad;
            font-weight: bold;
        }
        .card-panel .btn-primary {
            background: #1800ad !important;
            border: none;
            color: #fff;
            font-weight: bold;
        }
        .card-panel .btn-primary:hover {
            background: #12007a !important;
            color: #fff;
        }
        .card-panel i {
            color: #1800ad !important;
        }
        .footer-mex {
            background: linear-gradient(90deg, #1800ad 0%, #1800ad 100%);
            color: #fff;
            border-radius: 18px 18px 0 0;
            margin-top: 50px;
            padding: 30px 0 10px 0;
        }
        .footer-mex a { color: #e3e7ff; }
        .footer-mex a:hover { color: #fff; text-decoration: underline; }
    </style>
</head>
<body>
    <!-- Encabezado moderno -->
    <div class="panel-header">
        <img src="../../img/logo.png" alt="Mextium" class="logo-img">
        <div class="slogan">Panel de control de tu tienda: administra, analiza y crece</div>
        <div class="nombre-tienda">
            <?php echo htmlspecialchars($nombreTienda); ?>
        </div>
    </div>

    <!-- Panel principal -->
    <div class="container mt-4">
        <h2 class="text-center mb-4" style="color:#1800ad;">Bienvenido al Panel de tu Tienda</h2>
        <p class="text-center mb-5">Desde aquí puedes administrar tus productos, ver pedidos, configurar tu tienda y analizar el rendimiento.</p>
        <div class="row g-4">
            <div class="col-md-3 mb-4">
                <div class="card card-panel text-center h-100">
                    <div class="card-body">
                        <i class="fa fa-box fa-2x mb-3"></i>
                        <h5 class="card-title">Productos</h5>
                        <p class="card-text">Gestiona los productos de tu tienda.</p>
                        <a href="productos.php" class="btn btn-primary w-100">Ver productos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card card-panel text-center h-100">
                    <div class="card-body">
                        <i class="fa fa-shopping-basket fa-2x mb-3"></i>
                        <h5 class="card-title">Pedidos</h5>
                        <p class="card-text">Consulta y gestiona los pedidos recibidos.</p>
                        <a href="#" class="btn btn-primary w-100">Ver pedidos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card card-panel text-center h-100">
                    <div class="card-body">
                        <i class="fa fa-cogs fa-2x mb-3"></i>
                        <h5 class="card-title">Configuración</h5>
                        <p class="card-text">Actualiza la información y preferencias de tu tienda.</p>
                        <a href="conftienda.php" class="btn btn-primary w-100">Configurar tienda</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card card-panel text-center h-100">
                    <div class="card-body">
                        <i class="fa fa-chart-line fa-2x mb-3"></i>
                        <h5 class="card-title">Dashboard</h5>
                        <p class="card-text">Visualiza estadísticas y el resumen de tu tienda.</p>
                        <a href="#" class="btn btn-primary w-100">Ir al Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer moderno -->
    <footer class="footer-mex text-center mt-5">
        <div class="container">
            <div class="mb-2">
                <a href="../index.html" class="text-white me-3">Inicio</a>
                <a href="../shop.html" class="text-white me-3">Tienda</a>
                <a href="../cart.html" class="text-white me-3">Carrito</a>
                <a href="../Usuario/registro.html" class="text-white me-3">Registro</a>
                <a href="../Usuario/ingreso.html" class="text-white me-3">Ingreso</a>
                <a href="../encabezados/acerca.html" class="text-white me-3">Acerca de</a>
                <a href="../encabezados/FAQs.html" class="text-white me-3">FAQs</a>
                <a href="../encabezados/ayuda.html" class="text-white me-3">Ayuda</a>
                <a href="../encabezados/contactos.html" class="text-white me-3">Contactos</a>
            </div>
            &copy; 2025 <img src="../../img/logo.png" alt="Mextium" style="height:24px;vertical-align:middle;">. Todos los derechos reservados.
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>
</html>