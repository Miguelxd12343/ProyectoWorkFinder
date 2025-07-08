<?php
require_once "../../MVC/Modelo/voluntarioModelo.php";

class VoluntarioControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new Voluntario();
    }

    public function buscar() {
        if (isset($_POST['cedula'])) {
            $cedula = $_POST['cedula'];
            $voluntario = $this->modelo->buscarVoluntario($cedula);
            return $voluntario;
        }
        return null;
    }
}

$controlador = new VoluntarioControlador();
$voluntario = $controlador->buscar();
?>
