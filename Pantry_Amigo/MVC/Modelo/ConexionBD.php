<?php
class ConexionBD {
    
    // Variables para la conexión mysqli
    private $mysqli;
    private $result;

    // Variables para conexión PDO (opcional)
    public $conexion;
    private $host = "localhost";
    private $dbname = "Pantry_Amigo";
    private $usuario = "root";
    private $password = "";

    // Método para abrir la conexión mysqli
    public function abrir() {
        $this->mysqli = new mysqli("localhost", "root", "", "Pantry_Amigo");
        // Manejo de errores de conexión
        if ($this->mysqli->connect_error) {
            return false;
        }
        // Asegurar que se use UTF-8
        $this->mysqli->set_charset("utf8mb4");
        return true;
    }
    // Metodo para que pueda guardar datos
       public function prepare($sql) {
        return $this->mysqli->prepare($sql);
    }

    // Método para cerrar la conexión mysqli
    public function cerrar() {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }

    // Método para ejecutar consultas usando mysqli, con soporte para parámetros opcionales
    public function consulta($sql, $params = []) {
        if (!$this->mysqli) {
            return false;
        }
        // Si se pasan parámetros, usamos sentencias preparadas
        if (!empty($params)) {
            $stmt = $this->mysqli->prepare($sql);
            if (!$stmt) {
                return false;
            }
            // Suponiendo que todos los parámetros son strings por defecto
            $tipos = str_repeat("s", count($params));
            $stmt->bind_param($tipos, ...$params);
            if (!$stmt->execute()) {
                return false;
            }
            $this->result = $stmt->get_result();
            $stmt->close();
            return true;
        } else {
            // Consulta directa sin parámetros
            $this->result = $this->mysqli->query($sql);
            return $this->result !== false;
        }
    }

    // Método para obtener el resultado de la última consulta (como array asociativo)
    public function obtenerResult() {
        return $this->result;
    }

    // Método para obtener la cantidad de filas afectadas
    public function obtenerFilasAfectadas() {
        return $this->mysqli ? $this->mysqli->affected_rows : 0;
    }

    // Método para obtener el último ID insertado
    public function obtenerUltimoID() {
        return $this->mysqli ? $this->mysqli->insert_id : null;
    }

    // Conexión estática (singleton) para mysqli
    private static $conn;
    public static function getConnection() {
        if (!self::$conn) {
            self::$conn = new mysqli("localhost", "root", "", "Pantry_Amigo");
            if (self::$conn->connect_error) {
                die("❌ Error de conexión: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }

    // Constructor: se crea la conexión PDO (opcional)
    public function __construct() {
        try {
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->usuario, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión (PDO): " . $e->getMessage());
        }
    }
}


// importante 
$host = "localhost";
$user = "root";
$pass = "";
$db = "Pantry_Amigo";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}



?>
