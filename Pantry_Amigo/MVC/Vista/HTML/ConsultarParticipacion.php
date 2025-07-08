<?php
require_once '../../../MVC/Modelo/conexionBDD.php';
require_once '../../../MVC/Modelo/donacionModelo.php';

$conexion = new ConexionBD();
$conn = $conexion->getConexion();
$modelo = new DonacionModelo($conn);

$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : null;
$donaciones = $modelo->obtenerDonaciones($cedula);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Donaciones</title>
    <link rel="stylesheet" href="../CSS/prueba.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> 
</head>
<body>

<!-- Header -->
<header>
    <div class="navbar section-content">
        <a href="#" class="nav-logo">
            <img src="../IMG/logosinfondo.png" alt="Logo">
            <h2 class="logo-text">PANTRY</h2>
        </a>
        <ul class="nav-menu">
            <button id="menu-close-button" class=""></button>
            <li class="nav-item">
                <a href="../HTML/index.Php" class="nav-link">HOME</a>
            </li>
            <li class="nav-item">
                <a href="#sobre-nosotros" class="nav-link">ABOUT US</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">ACOUNT</a>
                <ul class="submenu">
                    <li><a href="../HTML/registro.php">SIGN UP</a></li>
                    <li><a href="../HTML/login.php">LOGIN</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="../HTML/ConsultarFundacion.php" class="nav-link">COLABORATORS</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">INFO</a>
            </li>
        </ul>
       <button id="menu-open-button" class=""></button>
    </div>
</header>

<!-- Sección de búsqueda -->
<section class="search-section">
    <div class="container">
        <h2 class="section-title">Buscar Donaciones</h2>
        <form id="frmConsultar" method="GET" class="search-form">
            <input type="text" name="cedula" placeholder="Ingrese CC del donante" class="search-input">
            <button type="submit" class="btn-submit">Buscar</button>
            <?php if (!empty($donaciones)): ?>
                <button type="button" onclick="window.location.href='consultarparticipacion.php?generar_pdf=1&cedula=<?= urlencode($cedula ?? '') ?>'" class="btn-pdf">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </button>
            <?php endif; ?>
        </form>
    </div>
</section>

<!-- Resultados -->
<section class="results-section">
    <div class="container">
        <?php if (!empty($donaciones)): ?>
            <table class="results-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Monto</th>
                        <th>Categoría</th>
                        <th>Correo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donaciones as $don): ?>
                        <tr>
                            <td><?= htmlspecialchars($don['Don_Nombre_Donante'] . ' ' . $don['Don_Apellido_Donante']) ?></td>
                            <td><?= htmlspecialchars($don['Don_Cedula_Donante']) ?></td>
                            <td>$<?= number_format($don['Don_Monto'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($don['Don_Cat_Nombre']) ?></td>
                            <td><?= htmlspecialchars($don['Don_Correo']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-results">No se encontraron donaciones.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        &copy; <?= date('Y') ?> PANTRY - Todos los derechos reservados
    </div>
</footer>

</body>
</html>