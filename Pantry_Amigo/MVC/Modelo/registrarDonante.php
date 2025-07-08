 <?php
require_once '../Modelo/ConexionBD.php';
class registrarDonante{
    public function regDonante(Donante $regDonante){
        try{
            $conexion = new ConexionBD();
            $conexion->abrir();

            $Dona_Cedula = $regDonante->getDona_Cedula();
            $Dona_Nombre = $regDonante->getDona_Nombre();
            $Dona_Apellido = $regDonante->getDona_Apellido();
            $Dona_Correo = $regDonante->getDona_Correo();
         
            $sql = "INSERT INTO tbl_donante (Dona_Cedula, Dona_Nombre, Dona_Apellido, Dona_Correo) 
                    VALUES ('$Dona_Cedula', '$Dona_Nombre', '$Dona_Apellido', '$Dona_Correo')";

$conexion->consulta($sql);
$res = $conexion->obtenerFilasAfectadas();
print ($res);

$conexion->cerrar();
        }catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
}