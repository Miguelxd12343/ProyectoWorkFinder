<?php

class FuncionesCaso {

  public static function calcularProgreso($recaudado, $meta) {
    if ($meta <= 0) return 0;
    $porcentaje = ($recaudado / $meta) * 100;
    return min($porcentaje, 100); // Limita a 100%
  }


  public static function actualizarMontoRecaudado($conn, $casoId, $monto) {
    $sql = "UPDATE Tbl_Casos_Dinero SET Caso_Monto_Recaudado = Caso_Monto_Recaudado + ? WHERE Caso_Id = ?";
    return $conn->consulta($sql, [$monto, $casoId]);
  }
}


?>

