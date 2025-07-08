<?php
session_start();
if(isset($_GET["logout"])){
    session_destroy();
    header("Location: vistas/usuarios/login.php");
    exit;
}

header("Location: vistas/usuarios/login.php");