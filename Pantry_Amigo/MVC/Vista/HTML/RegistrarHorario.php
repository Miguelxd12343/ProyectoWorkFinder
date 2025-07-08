      <!DOCTYPE html>
<html>
<head>
    <title>Asignar Horario a Voluntario</title>
    <link rel="stylesheet" href="../CSS/estiloRegHorarios.css">
</head>
<body>
    <h2>Asignar Horario a Voluntario</h2>
    <?php
    $cedula = isset($_GET['cedula']) ? htmlspecialchars($_GET['cedula']) : null;
    if (!$cedula) {
        echo "<p style='color: red;'>Error: No se proporcionó una cédula.</p>";
        exit;
    }
    if (isset($_GET['success'])) echo "<p style='color: green;'>Horario asignado con éxito.</p>";
    ?>
    
    <form method="POST" action="../../Controlador/Controlador.php">
        <label>Voluntario:</label>
        <input type="text" value="<?php echo $cedula; ?>" disabled>
        <input type="hidden" name="HorarioCedula" value="<?php echo $cedula; ?>">
        <br>

        <label>Hora de Citación:</label>
        <input type="datetime-local" name="HorarioCitacion" required>
        <br>

        <label>Localización:</label>
        <input type="text" name="HorarioLocalizacion" required>
        <br>

        <label>Duración (horas):</label>
        <input type="number" name="HorarioDuracionHoras" min="1" required>
        <br>

        <button type="submit" name="asignarHorario">Asignar Horario</button>
    </form>
</body>
</html>
