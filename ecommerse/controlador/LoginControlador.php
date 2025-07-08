<?php

require_once __DIR__ . '../../modelo/LoginModelo.php';
require_once __DIR__ . '../../modelo/conexion.php';


session_start();



$usuario = new Login($pdo);

if (isset($_POST["registrar"])){    
    $data = [
        "nombre" => $_POST["nombre"],
        "apellido" => $_POST["apellido"],
        "cedula" => $_POST["cedula"],
        "email" => $_POST["email"],
        "telefono" => $_POST["telefono"],
        "direccion" => $_POST["direccion"],
        "password" => $_POST["password"],
        "rol" => $_POST["rol"]
    ];
    $usuario->registrar($data);
    header("Location: ../vistas/usuarios/login.php");

    exit;
}

if(isset($_POST["login"])){
    $user = $usuario->login($_POST["email"], $_POST["password"]);
    if($user){
        $_SESSION["usuario"] = $user;
        header("Location: ../vistas/dashboard.php");
    }else{
        echo "Credenciales Incorrectas";
    }

}