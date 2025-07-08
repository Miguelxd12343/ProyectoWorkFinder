<?php
require_once "../../MVC/Modelo/ConexionBD.php";

class Voluntario{
    private $conexion;

    public function __construct() {
        $this->conexion = (new conexionBD())->conexion;
    }

    public function buscarVoluntario($cedula) {
        $sql = "SELECT * FROM tbl_voluntarios WHERE Vol_Cedula = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$cedula]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
