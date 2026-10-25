<?php
// app/controllers/AdminController.php

class AdminController extends Controller {
    
    public function index() {
        // Requerir autenticación
        if (!estaAutenticado()) {
            $this->redirect('index.php?url=login');
        }

        // Procesar cambio de estado
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'cambiar_estado') {
            $this->cambiarEstado();
            return;
        }

        $pedidoModel = new Pedido($this->pdo);

        // Mensaje flash
        $mensaje = $_SESSION['mensaje_admin'] ?? '';
        unset($_SESSION['mensaje_admin']);

        // Obtener pedidos
        $pedidos = $pedidoModel->obtenerTodosConCliente();

        // Cargar items de cada pedido
        foreach ($pedidos as &$pedido) {
            $pedido['items'] = $pedidoModel->obtenerDetalle($pedido['id']);
        }

        // Configuración de estados
        $configAdminEstados = [
            'pendiente'  => ['clase' => 'bg-warning text-dark', 'texto' => 'PENDIENTE'],
            'en_proceso' => ['clase' => 'bg-info text-dark', 'texto' => 'EN COCINA'],
            'enviado'    => ['clase' => 'bg-primary text-white', 'texto' => 'ENVIADO'],
            'completado' => ['clase' => 'bg-success text-white', 'texto' => 'COMPLETADO'],
            'cancelado'  => ['clase' => 'bg-danger text-white', 'texto' => 'CANCELADO']
        ];

        $this->render('admin/index', [
            'pedidos'             => $pedidos,
            'mensaje'             => $mensaje,
            'configAdminEstados'  => $configAdminEstados
        ]);
    }

    private function cambiarEstado() {
        $pedidoId    = filter_input(INPUT_POST, 'pedido_id', FILTER_VALIDATE_INT);
        $nuevoEstado = trim($_POST['estado'] ?? '');

        $estadosValidos = ['pendiente', 'en_proceso', 'enviado', 'completado', 'cancelado'];

        if ($pedidoId && in_array($nuevoEstado, $estadosValidos)) {
            $pedidoModel = new Pedido($this->pdo);
            $pedidoModel->actualizarEstado($pedidoId, $nuevoEstado);
            
            $_SESSION['mensaje_admin'] = "Pedido #{$pedidoId} actualizado a " . strtoupper(str_replace('_', ' ', $nuevoEstado)) . " con éxito.";
        }

        $this->redirect('index.php?url=admin');
    }
}