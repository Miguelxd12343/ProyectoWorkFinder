<?php
session_start();
include '../../Modelo/ConexionBD.php';
if ($_SERVER['REQUEST_METHOD']!=='POST'||!isset($_SESSION['id_fundacion'])) {
  echo json_encode(['success'=>false,'message'=>'Inválido']);
  exit;
}
$conn = (new ConexionBD())->conexion;
$d = $_POST;
try {
  $stmt = $conn->prepare("
    UPDATE tbl_casos_recursos SET
      Caso_Nombre=?,Caso_Descripcion=?,Caso_Fecha_Inicio=?,Caso_Fecha_Fin=?,
      Caso_Estado=?,Caso_Punto_Recoleccion=?,Caso_Imagen=?,
      Caso_Voluntariado=?,Caso_Cat_Nombre=?
    WHERE Caso_Id=? AND Caso_Fund_Id=?
  ");
  $stmt->execute([
    $d['Caso_Nombre'],$d['Caso_Descripcion'],$d['Caso_Fecha_Inicio'],
    $d['Caso_Fecha_Fin'],$d['Caso_Estado'],$d['Caso_Punto_Recoleccion'],
    $d['Caso_Imagen'] ?? '',$d['Caso_Voluntariado'] ?? 0,$d['Caso_Cat_Nombre'],
    $d['Caso_Id'],$_SESSION['id_fundacion']
  ]);
  echo json_encode(['success'=>true,'message'=>'Caso de recurso actualizado']);
} catch(PDOException $e){
  echo json_encode(['success'=>false,'message'=>$e->getMessage()]);
}
