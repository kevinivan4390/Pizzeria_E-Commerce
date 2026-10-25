<?php
// app/controllers/MenuController.php

class MenuController extends Controller {
    
    public function index() {
        // Cargar modelos
        require_once __DIR__ . '/../models/Producto.php';
        require_once __DIR__ . '/../models/Categoria.php';
        require_once __DIR__ . '/../models/Pedido.php';

        $productoModel  = new Producto($this->pdo);
        $categoriaModel = new Categoria($this->pdo);
        $pedidoModel    = new Pedido($this->pdo);

        // Obtener datos
        $categorias = $categoriaModel->obtenerTodas();
        $productos  = $productoModel->obtenerTodosActivos();

        // Obtener TODOS los pedidos activos de la sesión
        $pedidosActivos = [];
        $idsSesion = $_SESSION['pedidos_activos'] ?? [];

        if (!empty($idsSesion) && is_array($idsSesion)) {
            foreach ($idsSesion as $pedidoId) {
                $pedido = $pedidoModel->obtenerPorId($pedidoId);
                
                // Solo mostrar pedidos que existan y NO estén completados ni cancelados
                if ($pedido && !in_array($pedido['estado'], ['completado', 'cancelado'])) {
                    $pedidosActivos[] = $pedido;
                }
            }
        }

        // Limpiar de la sesión los pedidos que ya no están activos
        $idsActivosFiltrados = [];
        foreach ($idsSesion as $pedidoId) {
            $pedido = $pedidoModel->obtenerPorId($pedidoId);
            if ($pedido && !in_array($pedido['estado'], ['completado', 'cancelado'])) {
                $idsActivosFiltrados[] = $pedidoId;
            }
        }
        $_SESSION['pedidos_activos'] = $idsActivosFiltrados;

        // Configuración de estados para el cliente
        $configEstadosCliente = [
            'pendiente'  => ['clase' => 'bg-warning text-dark', 'texto' => '⏳ Pedido Recibido (Pendiente)'],
            'en_proceso' => ['clase' => 'bg-info text-dark', 'texto' => '🍕 En Cocina (En Preparación)'],
            'enviado'    => ['clase' => 'bg-primary text-white', 'texto' => '🛵 En Camino (Despachado)'],
            'completado' => ['clase' => 'bg-success text-white', 'texto' => '✅ Entregado (Completado)'],
            'cancelado'  => ['clase' => 'bg-danger text-white', 'texto' => '❌ Cancelado']
        ];

        // Renderizar la vista con los datos
        $this->render('cliente/menu', [
            'categorias'             => $categorias,
            'productos'              => $productos,
            'pedidosActivos'         => $pedidosActivos,
            'configEstadosCliente'   => $configEstadosCliente
        ]);
    }
}