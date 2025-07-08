<?php
session_start();

// Validar sesión
if (!isset($_SESSION['Usu_Id'])) {
    die("Error: Usuario no autenticado.");
}

// Incluir modelo
include_once '../../MVC/Modelo/ConexionBD.php';
include_once '../../MVC/Modelo/fundacionModelo.php';

// Abrir conexión
$conn = new ConexionBD();
$conn->abrir();

$usuarioId = $_SESSION['Usu_Id'];
$modelo = new FundacionModelo($conn);

// Manejo de imagen
$imagen = $modelo->obtenerPorUsuario($usuarioId)['Fund_Imagen'] ?? null;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $nombreOriginal = basename($_FILES['foto']['name']);
    $nombreUnico = uniqid("img_", true) . "_" . $nombreOriginal;
    
    // Ruta absoluta para la carpeta de imágenes
    $uploadDir = 'C:/xampp/htdocs/Pantry_Amigo/MVC/Vista/imagenes/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $rutaDestino = $uploadDir . $nombreUnico;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
        // Eliminar imagen anterior si no es default.png
        $datosActuales = $modelo->obtenerPorUsuario($usuarioId);
        $imagenAnterior = $datosActuales['Fund_Imagen'] ?? '';
        if ($imagenAnterior && $imagenAnterior !== 'default.png') {
            $rutaAnterior = $uploadDir . $imagenAnterior;
            if (file_exists($rutaAnterior)) unlink($rutaAnterior);
        }

        $imagen = $nombreUnico;
    } else {
        die("Error al subir la imagen.");
    }
}

// Recoger datos del formulario
$datos = [
    'username'   => trim($_POST['Fund_Username']),
    'correo'     => trim($_POST['Fund_Correo']),
    'direccion'  => trim($_POST['Fund_Direccion']),
    'casos'      => intval($_POST['Fund_Casos_Activos']),
    'telefono'   => trim($_POST['Fund_Telefono']),
    'usuarioId'  => $usuarioId,
];

if ($imagen) {
    $datos['imagen'] = $imagen;
}

// Registrar o actualizar
$registroExistente = $modelo->obtenerPorUsuario($usuarioId);

if ($registroExistente) {
    $resultado = $modelo->actualizar($datos);
    $mensaje = $resultado ? "Datos actualizados correctamente." : "Error al actualizar.";
} else {
    $datos['imagen'] = $imagen ?: 'default.png';
    $resultado = $modelo->registrar($datos);
    $mensaje = $resultado ? "Registro exitoso." : "Error al registrar.";
}

// Guardar mensaje en sesión para mostrarlo en el dashboard
$_SESSION['mensaje'] = $mensaje;

// Redirigir al dashboard
header("Location: ../../MVC/Vista/HTML/Fundacion_Dashboard.php");
exit;
?>