<?php

require_once __DIR__ . '/../modelo/conexion.php';

class Login{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function registrar($data){
        $sql = "INSERT INTO usuario (nombre, apellido, cedula, email, telefono, direccion, password, rol) VALUES (:nombre, :apellido, :cedula, :email, :telefono, :direccion, :password, :rol)";
        $stmt = $this->pdo->prepare($sql);
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        return $stmt->execute($data);
    }

    public function login($email, $password){
        $stmt = $this->pdo->prepare("SELECT * FROM usuario WHERE email = :email");
        $stmt->execute(["email" => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user["password"])){
            return $user;
        }
        return false;
    }

    }

?>