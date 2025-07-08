<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la Consulta</title>
</head>
<body>
    <h1>Resultado de la Consulta de Participación</h1>

    <div>
        <?php 
        $fila = $result->fetch_object();
        if ($fila): 
        ?>
            <table>
                <tr><th colspan="2">Datos de Participación</th></tr>
                <tr><td>Cedula del participante</td><td> <?php echo $fila->Dona_Cedula; ?> </td></tr>
                <tr><td>ID Caso de Donación</td><td> <?php echo $fila->Caso_Id; ?> </td></tr>
                <tr><td>Nombre</td><td> <?php echo $fila->Caso_Nombre_Caso; ?> </td></tr>
                <tr><td>Descripción</td><td> <?php echo $fila->Caso_Descripcion; ?> </td></tr>
                <tr><td>Fecha Inicio</td><td> <?php echo $fila->Caso_Fecha_Inicio; ?> </td></tr>
                <tr><td>Fecha Fin</td><td> <?php echo $fila->Caso_Fecha_Fin; ?> </td></tr>
                <tr><td>Estado</td><td> <?php echo $fila->Caso_Estado; ?> </td></tr>
                <tr><td>ID Fundación</td><td> <?php echo $fila->Caso_Fund_Id; ?> </td></tr>
                <tr><td>Fundación</td><td> <?php echo $fila->Fund_Username; ?> </td></tr>
                <tr><td>Teléfono</td><td> <?php echo $fila->Fund_telefono; ?> </td></tr>
                <tr><td>Correo</td><td> <?php echo $fila->Fund_Correo; ?> </td></tr>
            </table>
        <?php 
        else: 
            echo "<p>No se encontraron resultados.</p>";
        endif; 
        ?>
    </div>
</body>
</html>
