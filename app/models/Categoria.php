<?php
// app/models/Categoria.php

class Categoria extends Model {
    
    public function obtenerTodas() {
        return $this->pdo->query("SELECT * FROM categorias ORDER BY id ASC")->fetchAll();
    }
}