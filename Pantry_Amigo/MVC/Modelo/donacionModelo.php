<?php
class DonacionModelo {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    // Método existente para consultar donaciones
    public function obtenerDonaciones($cedula = null) {
        if ($cedula) {
            $stmt = $this->conn->prepare("SELECT Don_Monto, Don_Cat_Nombre, Don_Cedula_Donante, Don_Nombre_Donante, Don_Apellido_Donante, Don_Correo FROM tbl_donacion_dinero WHERE Don_Cedula_Donante = ?");
            $stmt->bind_param("s", $cedula);
        } else {
            $stmt = $this->conn->prepare("SELECT Don_Monto, Don_Cat_Nombre, Don_Cedula_Donante, Don_Nombre_Donante, Don_Apellido_Donante, Don_Correo FROM tbl_donacion_dinero");
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    // 🔁 Nuevo método para registrar donación
    public function registrarDonacion($datos) {
    $sql = "INSERT INTO tbl_donacion_dinero 
    (Don_Monto, Don_Comision, Don_Cedula_Donante, Don_Nombre_Donante, Don_Apellido_Donante, Don_Correo, Don_Fecha, Don_Caso_Id, Don_Cat_Nombre) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param(
        "dssssssis",
        $datos['monto'],
        $datos['comision'],
        $datos['cedula'],
        $datos['nombre'],
        $datos['apellido'],
        $datos['correo'],
        $datos['fecha'],
        $datos['casoId'],
        $datos['categoria']
    );

    $stmt->execute();
}

}
?>

