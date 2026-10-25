<?php
// app/controllers/NosotrosController.php

class NosotrosController extends Controller {
    
    public function index() {
        try {
            $stmt = $this->pdo->query("SELECT n.*, u.nombre AS autor 
                                       FROM noticias n 
                                       LEFT JOIN usuarios u ON n.usuario_id = u.id 
                                       ORDER BY n.fecha DESC");
            $noticias = $stmt->fetchAll();
        } catch (PDOException $e) {
            $noticias = [];
        }

        $this->render('cliente/nosotros', [
            'noticias' => $noticias
        ]);
    }
}