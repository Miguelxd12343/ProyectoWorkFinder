    <?php
    class FundacionModelo {
        private $conn;

        public function __construct($conexion) {
            $this->conn = $conexion;
        }

        public function obtenerPorUsuario($usuarioId) {
            $sql = "SELECT * FROM tbl_fundaciones WHERE Fund_Usu_Id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $usuarioId);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function registrar($datos) {
            $sql = "INSERT INTO tbl_fundaciones (Fund_Username, Fund_Correo, Fund_Direccion, Fund_Casos_Activos, Fund_Telefono, Fund_Usu_Id, Fund_Imagen) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssssis", $datos['username'], $datos['correo'], $datos['direccion'], $datos['casos'], $datos['telefono'], $datos['usuarioId'], $datos['imagen']);
            return $stmt->execute();
        }

        public function actualizar($datos) {
            $sql = "UPDATE tbl_fundaciones 
                    SET Fund_Username = ?, Fund_Correo = ?, Fund_Direccion = ?, Fund_Casos_Activos = ?, Fund_Telefono = ?" . 
                    ($datos['imagen'] ? ", Fund_Imagen = ?" : "") . 
                    " WHERE Fund_Usu_Id = ?";
            if ($datos['imagen']) {
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ssssssi", $datos['username'], $datos['correo'], $datos['direccion'], $datos['casos'], $datos['telefono'], $datos['imagen'], $datos['usuarioId']);
            } else {
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sssssi", $datos['username'], $datos['correo'], $datos['direccion'], $datos['casos'], $datos['telefono'], $datos['usuarioId']);
            }
            return $stmt->execute();
        }
    }
    ?>
