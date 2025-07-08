<?php
class Usuario {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = "SELECT * FROM Tbl_Usuario WHERE Usu_Username=? AND Usu_Password=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Método register() actualizado con validación de duplicados
    public function register($username, $password, $tipo, $correo) {
        // Verificar si ya existe el usuario o correo
        $query = "SELECT * FROM Tbl_Usuario WHERE Usu_Username = ? OR Usu_Correo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $username, $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return false; // Ya existe el usuario o correo
        }

        // Insertar nuevo usuario
        $insertQuery = "INSERT INTO Tbl_Usuario (Usu_Username, Usu_Password, Usu_Tipo, Usu_Correo) VALUES (?, ?, ?, ?)";
        $stmtInsert = $this->conn->prepare($insertQuery);
        $stmtInsert->bind_param("ssss", $username, $password, $tipo, $correo);
        return $stmtInsert->execute();
    }

    public function resetPassword($correo, $new_password) {
        $query = "UPDATE Tbl_Usuario SET Usu_Password=? WHERE Usu_Correo=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $new_password, $correo);
        return $stmt->execute();
    }
}
?>