<?php
//importante
class ConexionBD {
    public function getConexion() {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "Pantry_Amigo";

        $conn = new mysqli($host, $user, $pass, $db);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        return $conn;
    }
}

// NO quitar
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Pantry_Amigo";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>