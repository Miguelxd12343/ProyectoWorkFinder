<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();
session_unset();
session_destroy();

header("Location: http://localhost/Pantry_Amigo/MVC/Vista/HTML/index.php");
exit;
