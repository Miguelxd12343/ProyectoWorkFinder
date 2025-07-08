<?php
session_start();
include '../Usuario/config.php';

// Validar ID de tienda recibido por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../../index.php");
    exit;
}
$tienda_id = intval($_GET['id']);

// Obtener datos de la tienda
$sql = "SELECT nombre, descripcion, categoria, imagen FROM tiendas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tienda_id);
$stmt->execute();
$stmt->bind_result($nombre_tienda, $descripcion_tienda, $categoria_tienda, $imagen_tienda);
$stmt->fetch();
$stmt->close();

if (empty($nombre_tienda)) {
    header("Location: ../../index.php");
    exit;
}

// Obtener productos de la tienda
$productos = [];
$sql = "SELECT nombre, descripcion, precio, stock, imagen, estado FROM productos WHERE tienda_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tienda_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}
$stmt->close();

// Asigna una clase de fondo según la categoría
switch (strtolower($categoria_tienda)) {
    case 'videojuegos':
    case 'consolas':
    case 'videojuegos y consolas':
        $bg_class = 'bg-videojuegos';
        break;
    case 'ropa de mujer':
        $bg_class = 'bg-ropa-mujer';
        break;
    case 'tecnología':
        $bg_class = 'bg-tecnologia';
        break;
    // Agrega más categorías si quieres
    default:
        $bg_class = 'bg-default';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($nombre_tienda); ?> - Mextium</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(120deg, rgb(79, 22, 211) 0%, #e3e7ff 100%) !important; }
        .tienda-header {
            background: linear-gradient(90deg, #1800ad 0%, #1800ad 100%);
            color: #fff;
            padding: 30px 0 20px 0;
            margin-bottom: 30px;
            text-align: center;
            border-radius: 0 0 24px 24px;
        }
        .tienda-header .logo-mex,
        .tienda-header .logo-tium {
            display: none;
        }
        .tienda-header .logo-img {
            height: 54px;
            max-width: 180px;
            object-fit: contain;
            display: inline-block;
            margin-bottom: 0.5rem;
        }
        .tienda-img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #1800ad;
            background: #fff;
            margin-bottom: 10px;
        }
        .card-producto {
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(24,0,173,0.10);
            border: none;
            transition: box-shadow .2s;
        }
        .card-producto:hover {
            box-shadow: 0 8px 32px rgba(24,0,173,0.18);
        }
        .preview-img {
            max-width: 180px;
            max-height: 180px;
            border-radius: 10px;
            margin: 0 auto 10px auto;
            display: block;
            object-fit: cover;
        }
        .badge.bg-primary {
            background: #1800ad !important;
        }
        .badge.bg-secondary {
            background: #e3e7ff !important;
            color: #1800ad !important;
        }
        .badge.bg-info {
            background: #e3e7ff !important;
            color: #1800ad !important;
        }
        .text-primary {
            color: #1800ad !important;
        }
        .btn-warning {
            background: #1800ad !important;
            color: #fff !important;
            border: none;
            font-weight: bold;
        }
        .btn-warning:hover {
            background: #12007a !important;
            color: #fff !important;
        }
        .card {
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(24,0,173,0.10);
            border: none;
        }
        .card-body .text-success {
            color: #1800ad !important;
        }
        .card-body .text-muted {
            color: #6c757d !important;
        }
        .card-body .text-white {
            color: #fff !important;
        }
        .card-body .text-dark {
            color: #1800ad !important;
        }
        .card-body .fw-bold.text-primary {
            color: #1800ad !important;
        }
        .card-body .text-warning {
            color: #ffc107 !important;
        }
        .card-body .text-secondary {
            color: #e3e7ff !important;
        }
        .card-body .lead {
            color: #e3e7ff !important;
        }
        .card-body .badge {
            font-size: 0.95em;
        }
        .card-body .mb-2 {
            margin-bottom: 0.5rem !important;
        }
        .card-body .mb-0 {
            margin-bottom: 0 !important;
        }
        .card-body .mb-1 {
            margin-bottom: 0.25rem !important;
        }
        .card-body .mt-2 {
            margin-top: 0.5rem !important;
        }
        .card-body .mt-3 {
            margin-top: 1rem !important;
        }
        .card-body .mt-4 {
            margin-top: 1.5rem !important;
        }
        .card-body .mt-5 {
            margin-top: 3rem !important;
        }
        .card-body .mb-3 {
            margin-bottom: 1rem !important;
        }
        .card-body .mb-4 {
            margin-bottom: 1.5rem !important;
        }
        .card-body .mb-5 {
            margin-bottom: 3rem !important;
        }
        .card-body .fw-bold {
            font-weight: bold !important;
        }
        .card-body .text-center {
            text-align: center !important;
        }
        .card-body .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .card-body .small {
            font-size: 0.875em;
        }
        .card-body .lead {
            font-size: 1.25em;
        }
        .card-body .text-muted {
            color: #6c757d !important;
        }
        .card-body .text-success {
            color: #1800ad !important;
        }
        .card-body .text-warning {
            color: #ffc107 !important;
        }
        .card-body .text-secondary {
            color: #e3e7ff !important;
        }
        .card-body .text-white {
            color: #fff !important;
        }
        .card-body .text-dark {
            color: #1800ad !important;
        }
        .card-body .fw-bold.text-primary {
            color: #1800ad !important;
        }
        .card-body .text-warning {
            color: #ffc107 !important;
        }
        .card-body .text-secondary {
            color: #e3e7ff !important;
        }
        .card-body .lead {
            color: #e3e7ff !important;
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
    <div class="tienda-header">
        <img src="../../img/logo.png" alt="Mextium" class="logo-img">
        <div class="mt-2">
            <?php if (!empty($imagen_tienda)): ?>
                <img src="../../img/tiendas/<?php echo htmlspecialchars($imagen_tienda); ?>" class="tienda-img" alt="Logo tienda">
            <?php endif; ?>
            <h2 class="fw-bold mt-2 mb-1"><?php echo htmlspecialchars($nombre_tienda); ?></h2>
            <div class="mb-2">
                <span class="badge bg-info"><?php echo htmlspecialchars($categoria_tienda); ?></span>
            </div>
            <p class="lead mb-0"><?php echo htmlspecialchars($descripcion_tienda); ?></p>
        </div>
    </div>
    <div class="container mb-5">
        <h3 class="mb-4 text-primary text-center">Productos de la tienda</h3>
        <div class="row g-4">
            <?php if (empty($productos)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center p-5 rounded shadow-sm">
                        <i class="fa fa-box-open fa-2x mb-2 text-primary"></i>
                        <h4 class="mb-2">¡Esta tienda aún no tiene productos publicados!</h4>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($productos as $prod): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card card-producto h-100 shadow-sm border-0">
                        <img src="<?php echo !empty($prod['imagen']) ? '../../img/productos/' . htmlspecialchars($prod['imagen']) : '../../img/no-image.png'; ?>"
                             class="preview-img mt-3"
                             alt="<?php echo htmlspecialchars($prod['nombre']); ?>"
                             onerror="this.onerror=null;this.src='../../img/no-image.png';">
                        <div class="card-body text-center">
                            <h6 class="card-title text-truncate mb-1"><?php echo htmlspecialchars($prod['nombre']); ?></h6>
                            <div class="mb-2">
                                <span class="badge bg-primary text-white">Stock: <?php echo htmlspecialchars($prod['stock']); ?></span>
                                <span class="badge bg-secondary"><?php echo htmlspecialchars($prod['estado']); ?></span>
                            </div>
                            <h5 class="text-success mb-0">$<?php echo htmlspecialchars($prod['precio']); ?></h5>
                            <p class="small mt-2 text-muted"><?php echo htmlspecialchars($prod['descripcion']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Espacio para reseñas de la tienda -->
        <div class="mt-5">
            <h4 class="text-primary mb-3"><i class="fa fa-star text-warning me-2"></i>Reseñas de la tienda</h4>
            <div class="card shadow-sm mb-3">
                <div class="card-body" id="resenas-tienda">
                    <!-- Aquí se mostrarán las reseñas -->
                    <?php
                    // Ejemplo de reseñas estáticas, reemplaza por consulta a BD si tienes
                    $resenas = [
                        ['usuario' => 'Ana G.', 'texto' => 'Excelente atención y productos.', 'estrellas' => 5],
                        ['usuario' => 'Luis P.', 'texto' => 'Todo llegó en buen estado, recomendado.', 'estrellas' => 4],
                        ['usuario' => 'Sofía R.', 'texto' => 'Muy buena variedad y precios.', 'estrellas' => 5],
                    ];
                    if (empty($resenas)) {
                        echo '<div class="text-muted text-center">Aún no hay reseñas para esta tienda.</div>';
                    } else {
                        foreach ($resenas as $r) {
                            echo '<div class="mb-3">';
                            echo '<div class="fw-bold text-primary">'.$r['usuario'].'</div>';
                            echo '<div class="text-warning mb-1">'.str_repeat('★', $r['estrellas']).str_repeat('☆', 5-$r['estrellas']).'</div>';
                            echo '<div class="text-muted">'.$r['texto'].'</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Fin espacio reseñas -->

        <div class="text-center mt-4">
            <a href="../../index.php" class="btn btn-warning px-4 py-2"><i class="fa fa-arrow-left me-2"></i>Volver al inicio</a>
        </div>
    </div>
    <footer class="footer-mex text-center py-3 mt-4">
        &copy; 2025 <img src="../../img/logo.png" alt="Mextium" style="height:24px;vertical-align:middle;">. Todos los derechos reservados.
    </footer>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>