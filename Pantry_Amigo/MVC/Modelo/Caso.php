<?php
require_once 'ConexionBD.php';

class Caso {
    private $conexion;

    public function __construct() {
        $this->conexion = new ConexionBD();
    }

    //regcasos dinero
    public function registrarCasoDinero($nombre, $descripcion, $montoMeta, $montoRecaudado, $fechaInicio, $fechaFin, $estado, $imagen = null, $voluntariado, $fundacionId, $categoriaNombre) {
        if ($this->conexion->abrir()) {
            // Si no se proporciona una imagen, se guarda como NULL en la base de datos
            $imagenSQL = $imagen ? "'$imagen'" : "NULL";
    
            $sql = "INSERT INTO tbl_casos_dinero (
                        Caso_Nombre, Caso_Descripcion, Caso_Monto_Meta, Caso_Monto_Recaudado, 
                        Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Imagen, 
                        Caso_Voluntariado, Caso_Fund_Id, Caso_Cat_Nombre
                    ) 
                    VALUES (
                        '$nombre', '$descripcion', '$montoMeta', '$montoRecaudado',
                        '$fechaInicio', '$fechaFin', '$estado', $imagenSQL, 
                        '$voluntariado', '$fundacionId', '$categoriaNombre'
                    )";
    
            $this->conexion->consulta($sql);
            $filasAfectadas = $this->conexion->obtenerFilasAfectadas();
            $this->conexion->cerrar();
            return $filasAfectadas > 0;
        }
        return false;
    }

    // 🔍 Obtener todos los casos activos dinero
    public function obtenerCasosActivosDinero() {
        if ($this->conexion->abrir()) {
            
            $sql = "SELECT Caso_Id, Caso_Nombre, Caso_Descripcion FROM tbl_casos_dinero WHERE Caso_Estado = 'Activo'";
            $resultado = $this->conexion->consulta($sql);
            $this->conexion->cerrar();
            return $resultado;
        }
        return null;
    }
    
}
?>


