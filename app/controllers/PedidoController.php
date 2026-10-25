<?php
// app/controllers/PedidoController.php

class PedidoController extends Controller {
    
    public function checkout() {
        $this->render('cliente/checkout');
    }

    public function procesar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?url=menu');
        }

        $nombre       = trim($_POST['nombre'] ?? '');
        $telefono     = trim($_POST['telefono'] ?? '');
        $tipo_entrega = trim($_POST['tipo_entrega'] ?? 'delivery');
        $direccion    = trim($_POST['direccion'] ?? '');
        $metodo_pago  = trim($_POST['metodo_pago'] ?? 'efectivo');
        $notas        = trim($_POST['notas'] ?? '');
        $raw_carrito  = $_POST['carrito_data'] ?? '[]';

        if ($metodo_pago === 'mercado_pago') {
            $metodo_pago = 'mercadopago';
        }

        $carrito = json_decode($raw_carrito, true);

        if (empty($nombre) || empty($telefono) || empty($carrito)) {
            exit('Faltan datos obligatorios para procesar el pedido.');
        }

        $total = 0;
        foreach ($carrito as $item) {
            $total += (float)$item['precio'] * (int)$item['cantidad'];
        }

        $pedidoModel = new Pedido($this->pdo);

        try {
            $pedidoId = $pedidoModel->crearPedidoCompleto([
                'nombre'       => $nombre,
                'telefono'     => $telefono,
                'direccion'    => $direccion,
                'tipo_entrega' => $tipo_entrega,
                'metodo_pago'  => $metodo_pago,
                'notas'        => $notas,
                'total'        => $total,
                'carrito'      => $carrito
            ]);

            // Agregar el nuevo pedido a la lista de pedidos activos en sesión
            if (!isset($_SESSION['pedidos_activos']) || !is_array($_SESSION['pedidos_activos'])) {
                $_SESSION['pedidos_activos'] = [];
            }
            if (!in_array($pedidoId, $_SESSION['pedidos_activos'])) {
                $_SESSION['pedidos_activos'][] = $pedidoId;
            }

            $this->redirect('index.php?url=confirmacion&id=' . $pedidoId);

        } catch (\Exception $e) {
            exit('Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    public function confirmacion() {
        $pedidoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$pedidoId) {
            $this->redirect('index.php?url=menu');
        }

        $pedidoModel = new Pedido($this->pdo);
        $pedido = $pedidoModel->obtenerConCliente($pedidoId);

        if (!$pedido) {
            $this->redirect('index.php?url=menu');
        }

        $items = $pedidoModel->obtenerDetalle($pedidoId);

        $this->render('cliente/confirmacion', [
            'pedido' => $pedido,
            'items'  => $items
        ]);
    }
}