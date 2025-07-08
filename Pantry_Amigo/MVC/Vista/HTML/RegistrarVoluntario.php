<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../CSS/estiloRegVoluntario.css">
    <title>Registro de Voluntariado</title>
</head>

<body>
    <?php
    $casoId = isset($_GET['ID']) ? $_GET['ID'] : '';
    ?>
    <div class="voluntario-card">
        <div class="voluntario-formulario">
            <h2>Registro de Voluntarios</h2>
            <form id="frmDonar" action="../../Controlador/Controlador.php" method="POST">
                <label>CC:</label>
                <input type="text" name="regVolCedula" id="regDonaCedula" required>

                <label>Nombre:</label>
                <input type="text" name="regVolNombre" id="regDonaNombre" required>

                <label>Apellido:</label>
                <input type="text" name="regVolApellido" id="regDonaApellido" required>

                <label>Correo:</label>
                <input type="email" name="regVolCorreo" id="regVolCorreo" required>

                <label>Celular:</label>
                <input type="text" name="regVolCelular" id="regVolCelular" required>

                <input type="hidden" name="regVolCasoId" id="regVolCasoId" value="<?php echo $casoId; ?>">

                <button type="submit" name="registrarVoluntario">Registrar</button>
            </form>
        </div>
    </div>
</body>
</html>