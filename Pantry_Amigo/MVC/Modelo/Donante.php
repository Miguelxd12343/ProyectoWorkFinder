<?php
require_once '../Modelo/ConexionBD.php';

class Donante {
    public $cedula;
    public $nombre;
    public $apellido;
    public $correo;
    private $conn;

    // Constructor que recibe la conexión
    public function __construct($conexion, $cedula = "", $nombre = "", $apellido = "", $correo = "") {
        $this->conn = $conexion;
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
    }

    // Método para registrar donante en BD
    public function registrar() {
        $sql = "INSERT INTO tbl_donante (Dona_Cedula, Dona_Nombre, Dona_Apellido, Dona_Correo) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparando la consulta");
        }
        $stmt->bind_param(
            "ssss",
            $this->cedula,
            $this->nombre,
            $this->apellido,
            $this->correo
        );
        if (!$stmt->execute()) {
            throw new Exception("Error ejecutando la consulta");
        }
        return $stmt->affected_rows;
    }

    // Método para obtener donantes (puedes agregar filtros)
    public function obtenerPorCedula($cedula) {
        $sql = "SELECT Dona_Cedula, Dona_Nombre, Dona_Apellido, Dona_Correo FROM tbl_donante WHERE Dona_Cedula = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
