<?php
// app/controllers/AdminContactosController.php

class AdminContactosController extends Controller {
    
    public function index() {
        // Requerir autenticación
        if (!estaAutenticado()) {
            $this->redirect('index.php?url=login');
        }

        // Acción para eliminar un mensaje
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if ($id) {
                $stmt = $this->pdo->prepare("DELETE FROM contactos WHERE id = ?");
                $stmt->execute([$id]);
                $_SESSION['mensaje_admin'] = 'Mensaje eliminado correctamente.';
            }
            $this->redirect('index.php?url=admin-contactos');
        }

        $mensaje = $_SESSION['mensaje_admin'] ?? '';
        unset($_SESSION['mensaje_admin']);

        // Consultar todos los contactos ordenados del más reciente al más viejo
        $contactos = $this->pdo->query("SELECT * FROM contactos ORDER BY fecha DESC")->fetchAll();

        $this->render('admin/contactos', [
            'mensaje'   => $mensaje,
            'contactos' => $contactos
        ]);
    }
}