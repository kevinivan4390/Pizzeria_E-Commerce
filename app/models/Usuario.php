<?php
// app/models/Usuario.php

class Usuario extends Model {
    
    public function buscarPorUsuario($usuario) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? LIMIT 1");
        $stmt->execute([$usuario]);
        return $stmt->fetch();
    }
}