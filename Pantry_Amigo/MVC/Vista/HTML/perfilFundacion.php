<?php
include_once '../../Controlador/fundacionControlador.php';;

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil Fundación</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background:rgb(0, 0, 0);
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .image-box {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .image-box img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #007bff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .custom-file-upload {
            display: inline-block;
            background-color: #007bff;
            color: black;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .custom-file-upload:hover {
            background-color: #0056b3;
        }


        input[type="file"] {
            display: none;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 8px;
        }

        .btn {
            padding: 10px 25px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            margin: 10px 5px;
        }

        .btn-green {
            background-color: #28a745;
        }

        .btn-blue {
            background-color: #007bff;
        }
    </style>
</head>

<body>

    <div class="image-box">
    <img src="../imagenes/<?= $datos['Fund_Imagen'] ?? 'default.png' ?>" alt="Foto Fundación" id="preview">
    
        <!-- Botón debajo de la imagen -->
        <label for="foto" class="custom-file-upload">📁 Seleccionar imagen</label>
        <input type="file" name="foto" id="foto" accept="image/*" onchange="loadImage(event)" form="form-perfil">
    </div>


    <!-- Formulario -->
    <form method="POST" enctype="multipart/form-data" id="form-perfil">
        <div class="form-group">
            <label>Nombre de la Fundación:</label>
            <input type="text" name="Fund_Username" value="<?= $datos['Fund_Username'] ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label>Correo:</label>
            <input type="email" name="Fund_Correo" value="<?= $datos['Fund_Correo'] ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label>Dirección:</label>
            <input type="text" name="Fund_Direccion" value="<?= $datos['Fund_Direccion'] ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label>Casos Activos:</label>
            <input type="number" name="Fund_Casos_Activos" value="<?= $datos['Fund_Casos_Activos'] ?? '' ?>" min="0" required>
        </div>
        <div class="form-group">
            <label>Teléfono:</label>
            <input type="text" name="Fund_Telefono" value="<?= $datos['Fund_Telefono'] ?? '' ?>" required>
        </div>

        <?php if ($datos): ?>
            <button type="submit" name="actualizar" class="btn btn-green">Actualizar</button>
        <?php else: ?>
            <button type="submit" name="registrar" class="btn btn-blue">Registrar</button>
        <?php endif; ?>
    </form>
    </div>

    <script>
        function loadImage(event) {
            var image = document.getElementById('preview');
            image.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

</body>

</html>