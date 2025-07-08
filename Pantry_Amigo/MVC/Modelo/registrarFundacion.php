<?php
require_once '../Modelo/ConexionBD.php';
class registrarFundacion{
    private $Dona_Cedula;
    private $Dona_Nombre;
    private $Dona_Apellido;
    private $Dona_Correo;

    public function __construct() {
        $this->Dona_Cedula = "";
        $this->Dona_Nombre = "";
        $this->Dona_Apellido = "" ;
        $this->Dona_Correo = "";
    }

    public function Donante($Dona_Cedula, $Dona_Nombre, $Dona_Apellido, $Dona_Correo) {
        $this->Dona_Cedula = $Dona_Cedula;
        $this->Dona_Nombre = $Dona_Nombre;
        $this->Dona_Apellido = $Dona_Apellido;
        $this->Dona_Correo = $Dona_Correo;
    }

    function getDona_Cedula(){
        return $this->Dona_Cedula;
    }

    function getDona_Nombre(){
        return $this->Dona_Nombre;
    }

    function getDona_Apellido(){
        return $this->Dona_Apellido;
    }

    function getDona_Correo(){
        return $this->Dona_Correo;
    }

}
?>