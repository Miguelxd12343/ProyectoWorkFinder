<?php
require_once "../config/db.php"; // Asegúrate que esta ruta sea correcta según tu estructura

class Producto
{
    private $pdo;

    public function __construct()
    {
        // Reutiliza la conexión PDO desde config/db.php
        global $pdo;
        $this->pdo = $pdo;
    }

    /**
     * Obtener todos los productos disponibles
     */
    public function obtenerTodos()
    {
        $sql = "SELECT * FROM productos"; // Asegúrate que exista la tabla 'productos'
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Obtener un producto por su ID
     */
    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}