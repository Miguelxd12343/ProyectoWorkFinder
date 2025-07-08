<?php
//  errores durante desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Limpiar buffer antes de generar PDF
if (ob_get_length()) ob_clean();

require_once '../Modelo/conexionBDD.php';
require_once '../Modelo/donacionModelo.php';

// Si se solicita descargar PDF
if (isset($_GET['generar_pdf'])) {
    // Incluir TCPDF
    require_once '../../MVC/Vista/Librerias/tcpdf/tcpdf.php';

    $conexion = new ConexionBD();
    $conn = $conexion->getConexion();
    $modelo = new DonacionModelo($conn);

    $cedula = isset($_GET['cedula']) ? urldecode($_GET['cedula']) : null;
    $donaciones = $modelo->obtenerDonaciones($cedula);

    if (!empty($donaciones)) {
        // Crear PDF
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('PANTRY');
        $pdf->SetTitle('Reporte de Donaciones');
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        // Título centrado
        $pdf->Cell(0, 10, 'Reporte de Donaciones', 0, 1, 'C');
        $pdf->Ln(10);

        // Tabla de resultados
        $html = '
        <table border="1" cellpadding="5">
            <thead>
                <tr style="background-color:#e0e0e0;">
                    <th>Nombre</th>
                    <th>Cédula</th>
                    <th>Monto</th>
                    <th>Categoría</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($donaciones as $don) {
            $nombre = htmlspecialchars($don['Don_Nombre_Donante'] . ' ' . $don['Don_Apellido_Donante']);
            $monto = '$' . number_format($don['Don_Monto'], 0, ',', '.');
            $html .= "<tr>
                        <td>{$nombre}</td>
                        <td>{$don['Don_Cedula_Donante']}</td>
                        <td>{$monto}</td>
                        <td>{$don['Don_Cat_Nombre']}</td>
                        <td>{$don['Don_Correo']}</td>
                      </tr>";
        }

        $html .= '</tbody></table>';

        // Escribir contenido HTML en el PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Limpiar buffer final y enviar PDF
        if (ob_get_length()) ob_end_clean();

        // Descargar el PDF
        $pdf->Output('donaciones.pdf', 'D');
        exit;
    } else {
        header("Location: ConsultarParticipacion.php");
        exit;
    }
}

// Si no es generación de PDF, mostrar página normal
$conexion = new ConexionBD();
$conn = $conexion->getConexion();
$modelo = new DonacionModelo($conn);

$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : null;
$donaciones = $modelo->obtenerDonaciones($cedula);

include '../Vista/HTML/ConsultarParticipacion.php';
?>