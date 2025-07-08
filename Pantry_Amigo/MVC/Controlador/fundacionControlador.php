<?php
// MVC/Controlador/fundacionControlador.php
session_start();

// 1) Incluimos la conexión y el modelo usando rutas absolutas relativas a este archivo
require_once __DIR__ . '/../Modelo/ConexionBD.php';
require_once __DIR__ . '/../Modelo/fundacionModelo.php';

// 2) Validamos que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    // Redirigimos al login si no hay sesión activa
    header('Location: /Pantry_Amigo/MVC/Vista/HTML/login.php');
    exit;
}

//guarda el id de la persona
$usuarioId = $_SESSION['id_usuario'];

// 3) Creamos la conexión y el modelo
$db   = new ConexionBD();
$conn = $db->conexion;
$modelo = new FundacionModelo($conn);

// 4) Obtenemos datos actuales de la fundación (si ya existe)
$datos = $modelo->obtenerPorUsuario($usuarioId);

// 5) Procesamos el POST del formulario de Perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mantenemos la imagen anterior si no cargan una nueva
    $imagen = $datos['Fund_Imagen'] ?? null;

    // Si subieron archivo, lo guardamos
    if (!empty($_FILES['foto']['name'])) {
        // Nombre único
        $imagen = uniqid() . "_" . basename($_FILES['foto']['name']);
        // Carpeta de destino: MVC/Vista/IMG/
        $uploadDir = __DIR__ . '/../Vista/IMG/';
        move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $imagen);
    }

    // Preparamos arreglo de datos para insertar/actualizar
    $entrada = [
        'username'   => $_POST['Fund_Username']       ?? '',
        'correo'     => $_POST['Fund_Correo']         ?? '',
        'direccion'  => $_POST['Fund_Direccion']      ?? '',
        'casos'      => $_POST['Fund_Casos_Activos']  ?? 0,
        'telefono'   => $_POST['Fund_Telefono']       ?? '',
        'usuarioId'  => $usuarioId,
        'imagen'     => $imagen
    ];

    // Si venimos de un registro nuevo...
    if (isset($_POST['registrar'])) {
        $modelo->registrar($entrada);
    }
    // ... o de una actualización
    elseif (isset($_POST['actualizar'])) {
        $modelo->actualizar($entrada);
    }

    // Volvemos al dashboard para ver los cambios
    header('Location: ../Vista/HTML/Fundacion_Dashboard.php');
    exit;
}
?>
