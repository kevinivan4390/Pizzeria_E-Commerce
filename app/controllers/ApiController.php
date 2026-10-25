<?php
// app/controllers/ApiController.php

class ApiController extends Controller {
    
    public function estadoPedido() {
        // Limpiar cualquier salida previa para no ensuciar el JSON
        if (ob_get_length()) {
            ob_clean();
        }

        $pedidoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$pedidoId) {
            $this->json(['exito' => false, 'error' => 'ID inválido']);
        }

        $pedidoModel = new Pedido($this->pdo);
        $pedido = $pedidoModel->obtenerPorId($pedidoId);

        if ($pedido) {
            $this->json([
                'exito'  => true,
                'estado' => strtolower(trim($pedido['estado']))
            ]);
        } else {
            $this->json(['exito' => false, 'error' => 'Pedido no encontrado']);
        }
    }
}