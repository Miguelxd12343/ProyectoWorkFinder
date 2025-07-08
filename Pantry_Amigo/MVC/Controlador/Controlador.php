<?php
require_once '../Modelo/ConexionBD.php';
require_once '../Modelo/Donante.php';
require_once '../Modelo/registrarDonante.php';
require_once '../Modelo/Caso.php';
require_once '../Modelo/Participacion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // REGISTRAR DONAcion dinero (dinero)
        if (
            isset($_POST['regDonaCedula']) &&
            isset($_POST['regDonaNombre']) &&
            isset($_POST['regDonaApellido']) &&
            isset($_POST['regDonaCorreo'])
        ) {
            $Dona_Cedula = $_POST['regDonaCedula'];
            $Dona_Nombre = $_POST['regDonaNombre'];
            $Dona_Apellido = $_POST['regDonaApellido'];
            $Dona_Correo = $_POST['regDonaCorreo'];

            $personal = new Donante($Dona_Cedula, $Dona_Nombre, $Dona_Apellido, $Dona_Correo);

            $perCliente = new registrarDonante();
            $perCliente->regDonante($personal);
        }


        // REGISTRAR CASO DE DONACIÓN DINERO
        if (isset($_POST['registrarCasoDin'])) {
            $casoNombre = $_POST['casoNombre'];
            $casoDescripcion = $_POST['casoDescripcion'];
            $montoMeta =$_POST['casoMontoMeta'];
            $casoMontoRecaudado = 0; 
            $casoFechaInicio = $_POST['casoFechaInicio'];
            $casoFechaFin = $_POST['casoFechaFin'];
            $casoEstado = $_POST['casoEstado'];
            $casoVoluntariado = isset($_POST['casoVoluntariado']) ? 1 : 0;
            $fundacionId = $_POST['casoFundacion'];
            $categoriaNombre =$_POST['casoCategoria'];
            
            $casoImagen = $_FILES['casoImagen']['name'] ?? null;$imagenRuta = null;
            if (isset($_FILES['casoImagen']) && $_FILES['casoImagen']['error'] === 0) {
                $nombreArchivo = basename($_FILES['casoImagen']['name']);
                $rutaTemporal = $_FILES['casoImagen']['tmp_name'];
                $carpetaDestino = "../Vista/imagenes_casos/";
        
                if (!file_exists($carpetaDestino)) {
                    mkdir($carpetaDestino, 0777, true); // Crear carpeta si no existe
                }
        
                $rutaFinal = $carpetaDestino . $nombreArchivo;
        
                if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
                    $imagenRuta = "imagenes_casos/" . $nombreArchivo; // Ruta relativa
                } else {
                    echo "<script>alert('Error al guardar la imagen');</script>";
                }
            }
            $caso = new Caso();
            if ($caso->registrarCasoDinero($casoNombre, $casoDescripcion, $montoMeta, $casoMontoRecaudado, $casoFechaInicio, $casoFechaFin, $casoEstado, $imagenRuta, $casoVoluntariado, $fundacionId, $categoriaNombre)) {
                echo "<script>alert('Caso registrado exitosamente');</script>";
            } else {
                echo "<script>alert('Error al registrar el caso');</script>";
            }
        }

        // REGISTRAR CASO DE DONACIÓN recursos ediat
        if (isset($_POST['registrarCasoRec'])) {
            $casoNombre = $_POST['casoNombre'];
            $casoDescripcion = $_POST['casoDescripcion'];
            $casoFechaInicio = $_POST['casoFechaInicio'];
            $casoFechaFin = $_POST['casoFechaFin'];
            $casoEstado = $_POST['casoEstado'];
            $casoPuntoRec = $_POST['casoPuntoRec'];
            $casoVoluntariado = isset($_POST['casoVoluntariado']) ? 1 : 0;
            $fundacionId = $_POST['casoFundacion'];
            $categoriaNombre =$_POST['casoCategoria'];

            $casoImagen = $_FILES['casoImagen']['name'] ?? null;$imagenRuta = null;
            if (isset($_FILES['casoImagen']) && $_FILES['casoImagen']['error'] === 0) {
                $nombreArchivo = basename($_FILES['casoImagen']['name']);
                $rutaTemporal = $_FILES['casoImagen']['tmp_name'];
                $carpetaDestino = "../Vista/imagenes_casos/";
        
                if (!file_exists($carpetaDestino)) {
                    mkdir($carpetaDestino, 0777, true); // Crear carpeta si no existe
                }
        
                $rutaFinal = $carpetaDestino . $nombreArchivo;
        
                if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
                    $imagenRuta = "imagenes_casos/" . $nombreArchivo; // Ruta relativa
                } else {
                    echo "<script>alert('Error al guardar la imagen');</script>";
                }
            }
            $caso = new Caso();
            if ($caso->registrarCasoRecursos($casoNombre, $casoDescripcion, $casoFechaInicio, $casoFechaFin, $casoEstado, $casoPuntoRec, $casoImagen, $casoVoluntariado, $fundacionId, $categoriaNombre)
            ) {
                echo "<script>alert('Caso registrado exitosamente');</script>";
            } else {
                echo "<script>alert('Error al registrar el caso');</script>";
            }
        }

        //REGISTRAR VOLUNTARIO
        if (isset($_POST['registrarVoluntario'])) {
            $Vol_Cedula = $_POST['regVolCedula'];
            $Vol_Nombre = $_POST['regVolNombre'];
            $Vol_Apellido = $_POST['regVolApellido'];
            $Vol_Correo = $_POST['regVolCorreo'];
            $Vol_Celular = $_POST['regVolCelular'];
            $Vol_CasoId = $_POST['regVolCasoId'];

            $voluntario = new Participacion();
            if ($voluntario->registrarVoluntario($Vol_Cedula, $Vol_Nombre, $Vol_Apellido, $Vol_Correo, $Vol_Celular, $Vol_CasoId)) {
                echo "<script>alert('Voluntario registrado exitosamente');</script>";
            } else {
                echo "<script>alert('Error al registrar el Voluntario');</script>";
            }
        }

        // ASIGNAR HORARIO A VOLUNTARIO
        if (isset($_POST['asignarHorario'])) {
            

            $voluntario = $_POST['HorarioCedula'];
            $horaCitacion = $_POST['HorarioCitacion'];
            $localizacion = $_POST['HorarioLocalizacion'];
            $duracionHoras = $_POST['HorarioDuracionHoras'];

            $participacion = new Participacion();
            if ($participacion->asignarHorario($voluntario, $horaCitacion, $localizacion, $duracionHoras)) {
                echo "<script>alert('Horario asignado exitosamente');</script>";
            } else {
                echo "<script>alert('Error al asignar el horario');</script>";
            }
        }




    } catch (Exception $ex) {
        echo 'Error: ' . $ex->getMessage();
    }
}

