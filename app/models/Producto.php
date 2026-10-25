<?php
// app/models/Producto.php

class Producto extends Model {
    
    public function obtenerTodosActivos() {
        $query = "SELECT p.*, c.nombre AS categoria_nombre 
                  FROM productos p 
                  JOIN categorias c ON p.categoria_id = c.id 
                  WHERE p.activo = 1 
                  ORDER BY p.categoria_id ASC, p.nombre ASC";
        return $this->pdo->query($query)->fetchAll();
    }

    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}