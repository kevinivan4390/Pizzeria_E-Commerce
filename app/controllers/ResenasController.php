<?php
// app/controllers/ResenasController.php

class ResenasController extends Controller {
    
    public function index() {
        // 1. Mostrar mensajes guardados en sesión si existen y limpiarlos
        $mensaje = $_SESSION['mensaje_resena'] ?? '';
        $error   = $_SESSION['error_resena'] ?? '';
        unset($_SESSION['mensaje_resena'], $_SESSION['error_resena']);

        // 2. Procesar el envío del formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Campo Honeypot anti-spam
            $honeypot = trim($_POST['website'] ?? '');
            
            if (!empty($honeypot)) {
                $_SESSION['mensaje_resena'] = '¡Gracias por tu comentario!';
            } else {
                $nombre     = trim($_POST['nombre'] ?? '');
                $puntuacion = filter_input(INPUT_POST, 'puntuacion', FILTER_VALIDATE_INT);
                $comentario = trim($_POST['comentario'] ?? '');

                if (!empty($nombre) && $puntuacion && $puntuacion >= 1 && $puntuacion <= 5 && !empty($comentario)) {
                    $stmt = $this->pdo->prepare("
                        INSERT INTO resenas (nombre, puntuacion, comentario, fecha, visible) 
                        VALUES (?, ?, ?, NOW(), 0)
                    ");
                    $stmt->execute([$nombre, $puntuacion, $comentario]);
                    $_SESSION['mensaje_resena'] = '¡Gracias por tu opinión! Tu reseña fue enviada y va a ser publicada apenas la revisemos.';
                } else {
                    $_SESSION['error_resena'] = 'Completá todos los campos y elegí una puntuación entre 1 y 5 estrellas.';
                }
            }

            // 3. REDIRECCIÓN (PRG)
            $this->redirect('index.php?url=resenas');
        }

        // 4. Consultar reseñas aprobadas para la vista pública
        $stmt = $this->pdo->query("SELECT * FROM resenas WHERE visible = 1 ORDER BY fecha DESC");
        $resenas = $stmt->fetchAll();

        // Promedio general de calificación
        $stmtStats = $this->pdo->query("SELECT AVG(puntuacion) AS promedio, COUNT(*) AS total FROM resenas WHERE visible = 1");
        $stats = $stmtStats->fetch();
        $promedio = $stats['promedio'] ? number_format((float)$stats['promedio'], 1) : null;
        $totalResenas = (int)$stats['total'];

        $this->render('cliente/resenas', [
            'mensaje'      => $mensaje,
            'error'        => $error,
            'resenas'      => $resenas,
            'promedio'     => $promedio,
            'totalResenas' => $totalResenas
        ]);
    }
}