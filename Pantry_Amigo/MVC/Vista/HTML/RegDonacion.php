<?php
require_once '../../../vendor/autoload.php';
require_once '../../Modelo/ConexionBD.php';
require_once '../../Modelo/DonacionModelo.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

MercadoPagoConfig::setAccessToken('APP_USR-4306942363216817-061310-05528330eb0be839b7b575acd647667e-2496822952');

$payment_id = $_GET['payment_id'] ?? null;

if (!$payment_id) {
    die("❌ No se recibió el ID del pago.");
}

$client = new PaymentClient();
$payment = $client->get($payment_id);

// ✅ Validar estado del pago
if ($payment->status !== 'approved') {
    die("❌ El pago no fue aprobado. Estado: " . $payment->status);
}

// ✅ Descomponer los datos de external_reference
list($casoId, $nombre, $apellido, $cedula, $correo, $monto, $categoria) = explode('|', $payment->external_reference);

// ✅ Conexión a la base de datos
$conn = new ConexionBD();
if (!$conn->abrir()) {
    die("❌ Error al conectar con la base de datos.");
}

// ✅ Calcular la comisión
$comision = $payment->transaction_details->total_paid_amount - $payment->transaction_details->net_received_amount;
$fecha = date('Y-m-d H:i:s');

// ✅ Registrar donación usando el modelo
$modelo = new DonacionModelo($conn->getConexion());

$modelo->registrarDonacion([
    'monto' => $monto,
    'comision' => $comision,
    'cedula' => $cedula,
    'nombre' => $nombre,
    'apellido' => $apellido,
    'correo' => $correo,
    'fecha' => $fecha,
    'casoId' => $casoId,
    'categoria' => $categoria
]);

$conn->cerrar();

echo "✅ Donación registrada correctamente. ¡Gracias por tu apoyo!";




