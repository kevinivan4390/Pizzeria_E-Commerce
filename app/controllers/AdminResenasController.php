<?php
// app/controllers/AdminResenasController.php

class AdminResenasController extends Controller {
    
    public function index() {
        // Requerir autenticación
        if (!estaAutenticado()) {
            $this->redirect('index.php?url=login');
        }

        // Procesar acciones de moderación (Aprobar, Ocultar, Borrar)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $accion = $_POST['accion'] ?? '';
            
            if ($id) {
                if ($accion === 'aprobar') {
                    $stmt = $this->pdo->prepare("UPDATE resenas SET visible = 1 WHERE id = ?");
                    $stmt->execute([$id]);
                    $_SESSION['mensaje_admin'] = 'Reseña aprobada con éxito.';
                } elseif ($accion === 'ocultar') {
                    $stmt = $this->pdo->prepare("UPDATE resenas SET visible = 0 WHERE id = ?");
                    $stmt->execute([$id]);
                    $_SESSION['mensaje_admin'] = 'Reseña ocultada.';
                } elseif ($accion === 'eliminar') {
                    $stmt = $this->pdo->prepare("DELETE FROM resenas WHERE id = ?");
                    $stmt->execute([$id]);
                    $_SESSION['mensaje_admin'] = 'Reseña eliminada correctamente.';
                }
            }

            // Redirección POST-Redirect-GET
            $this->redirect('index.php?url=admin-resenas');
        }

        // Obtener mensaje guardado en sesión si existe
        $mensaje = $_SESSION['mensaje_admin'] ?? '';
        unset($_SESSION['mensaje_admin']);

        // Consultar todas las reseñas
        $resenas = $this->pdo->query("SELECT * FROM resenas ORDER BY fecha DESC")->fetchAll();

        $this->render('admin/resenas', [
            'mensaje' => $mensaje,
            'resenas' => $resenas
        ]);
    }
}