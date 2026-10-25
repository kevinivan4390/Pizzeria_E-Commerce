<?php
// app/models/Pedido.php

class Pedido extends Model {
    
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function obtenerConCliente($id) {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.nombre AS cliente_nombre, c.telefono, c.direccion 
            FROM pedidos p 
            INNER JOIN clientes c ON p.cliente_id = c.id 
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function obtenerTodosConCliente() {
        $query = "
            SELECT p.*, c.nombre AS cliente_nombre, c.telefono, c.direccion 
            FROM pedidos p 
            INNER JOIN clientes c ON p.cliente_id = c.id 
            ORDER BY p.id DESC";
        return $this->pdo->query($query)->fetchAll();
    }

    public function obtenerDetalle($pedidoId) {
        $stmt = $this->pdo->prepare("
            SELECT dp.*, prod.nombre AS producto_nombre 
            FROM detalle_pedidos dp 
            INNER JOIN productos prod ON dp.producto_id = prod.id 
            WHERE dp.pedido_id = ?
        ");
        $stmt->execute([$pedidoId]);
        return $stmt->fetchAll();
    }

    public function actualizarEstado($pedidoId, $nuevoEstado) {
        $stmt = $this->pdo->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
        return $stmt->execute([$nuevoEstado, $pedidoId]);
    }

    public function crearPedidoCompleto($datos) {
        try {
            $this->pdo->beginTransaction();

            // 1. Guardar cliente
            $stmtCliente = $this->pdo->prepare("
                INSERT INTO clientes (nombre, telefono, direccion) 
                VALUES (?, ?, ?)
            ");
            $stmtCliente->execute([
                $datos['nombre'], 
                $datos['telefono'], 
                $datos['direccion']
            ]);
            $clienteId = $this->pdo->lastInsertId();

            // 2. Guardar pedido
            $stmtPedido = $this->pdo->prepare("
                INSERT INTO pedidos (cliente_id, costo_envio, total, estado, metodo_pago, tipo_entrega, notas, fecha) 
                VALUES (?, 0.00, ?, 'pendiente', ?, ?, ?, NOW())
            ");
            $stmtPedido->execute([
                $clienteId, 
                $datos['total'], 
                $datos['metodo_pago'], 
                $datos['tipo_entrega'], 
                $datos['notas']
            ]);
            $pedidoId = (int)$this->pdo->lastInsertId();

            // 3. Guardar detalle
            $stmtDetalle = $this->pdo->prepare("
                INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio_unitario, aclaraciones) 
                VALUES (?, ?, ?, ?, ?)
            ");

            foreach ($datos['carrito'] as $item) {
                $stmtDetalle->execute([
                    $pedidoId,
                    (int)$item['id'],
                    (int)$item['cantidad'],
                    (float)$item['precio'],
                    $item['aclaraciones'] ?? ''
                ]);
            }

            $this->pdo->commit();
            return $pedidoId;

        } catch (\Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }
}