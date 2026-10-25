<?php
// app/controllers/Controller.php

class Controller {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    protected function render($vista, $datos = []) {
        // Hacer que $pdo esté disponible en el scope de la vista y del header
        $pdo = $this->pdo;

        extract($datos);
        $archivoVista = __DIR__ . '/../views/' . $vista . '.php';
        
        if (!file_exists($archivoVista)) {
            die("Error: La vista '$vista' no existe.");
        }
        
        require_once $archivoVista;
    }

    protected function redirect($url) {
        header("Location: " . $url);
        exit;
    }

    protected function json($datos) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($datos);
        exit;
    }
}