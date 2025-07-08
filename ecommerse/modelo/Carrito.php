<?php
require_once "../config/db.php";

class Carrito
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Agregar un producto al carrito
    public function agregar($usuario_id, $producto_id, $cantidad)
    {
        $sql = "INSERT INTO carrito_items (usuario_id, producto_id, cantidad)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE cantidad = cantidad + VALUES(cantidad)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$usuario_id, $producto_id, $cantidad]);
    }

    // Obtener todos los productos en el carrito de un usuario
    public function obtenerItems($usuario_id)
    {
        $sql = "SELECT ci.*, p.nombre, p.precio
                FROM carrito_items ci
                JOIN productos p ON ci.producto_id = p.id
                WHERE ci.usuario_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll();
    }

    // Eliminar un producto del carrito
    public function eliminar($usuario_id, $producto_id)
    {
        $sql = "DELETE FROM carrito_items WHERE usuario_id = ? AND producto_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$usuario_id, $producto_id]);
    }

    // Vaciar todo el carrito de un usuario
    public function vaciar($usuario_id)
    {
        $sql = "DELETE FROM carrito_items WHERE usuario_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$usuario_id]);
    }
}
