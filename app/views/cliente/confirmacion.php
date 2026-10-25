<?php 
// app/views/cliente/confirmacion.php
// Datos que vienen del controlador: $pedido, $items
require_once __DIR__ . '/../../../includes/header.php'; 
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4 text-center">
            <div class="card-body p-5">
                <div class="display-1 mb-3">🎉</div>
                <h1 class="fw-bold text-success mb-3">¡Pedido Confirmado!</h1>
                <p class="lead">Tu pedido <strong>#<?= e($pedido['id']) ?></strong> fue recibido con éxito.</p>
                <p class="text-muted">Te avisaremos cuando esté en camino. Podés seguir el estado en tiempo real desde el menú.</p>
            </div>
        </div>

        <!-- Estado del Pedido -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4 text-center">
                <h5 class="fw-bold mb-3">Estado Actual</h5>
                <span id="badge-estado-confirmacion" class="badge bg-warning text-dark fs-5 px-4 py-3">
                    ⏳ Pedido Recibido (Pendiente)
                </span>
            </div>
        </div>

        <!-- Detalle del Pedido -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold py-3">📋 Detalle de tu Pedido</div>
            <div class="card-body">
                <ul class="list-unstyled mb-3">
                    <?php foreach ($items as $item): ?>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span>
                                <strong><?= e($item['cantidad']) ?>x</strong> <?= e($item['producto_nombre']) ?>
                                <?php if (!empty($item['aclaraciones'])): ?>
                                    <br><small class="text-muted">↳ <?= e($item['aclaraciones']) ?></small>
                                <?php endif; ?>
                            </span>
                            <span class="fw-bold"><?= formatearPrecio($item['precio_unitario'] * $item['cantidad']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="d-flex justify-content-between fs-5 fw-bold text-success">
                    <span>Total:</span>
                    <span><?= formatearPrecio($pedido['total']) ?></span>
                </div>
            </div>
        </div>

        <!-- Datos de Entrega -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold py-3">🛵 Datos de Entrega</div>
            <div class="card-body">
                <p class="mb-1"><strong>Tipo:</strong> <?= ucfirst(e($pedido['tipo_entrega'])) ?></p>
                <p class="mb-1"><strong>Método de pago:</strong> <?= ucfirst(e($pedido['metodo_pago'])) ?></p>
                <?php if (!empty($pedido['notas'])): ?>
                    <p class="mb-0"><strong>Notas:</strong> <?= e($pedido['notas']) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center mb-5">
            <a href="index.php?url=menu" class="btn btn-primary fw-bold px-4 py-2">
                🍕 Volver al Menú
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 🧹 Vaciar el carrito del localStorage al llegar a la confirmación
    // (usamos la MISMA clave que main.js: 'tocci_carrito')
    localStorage.removeItem('tocci_carrito');

    // Actualizar el contador del carrito en el header si existe
    const cartCount = document.getElementById('cart-count');
    if (cartCount) {
        cartCount.innerText = '0';
    }

    // Seguimiento automático del estado
    const pedidoId = <?= json_encode($pedido['id']) ?>;
    const mapaEstados = {
        'pendiente':  { clase: 'bg-warning text-dark', texto: '⏳ Pedido Recibido (Pendiente)' },
        'en_proceso': { clase: 'bg-info text-dark', texto: '🍕 En Cocina (En Preparación)' },
        'enviado':    { clase: 'bg-primary text-white', texto: '🛵 En Camino (Despachado)' },
        'completado': { clase: 'bg-success text-white', texto: '✅ Entregado (Completado)' },
        'cancelado':  { clase: 'bg-danger text-white', texto: '❌ Cancelado' }
    };

    const intervaloEstado = setInterval(async () => {
        try {
            const res = await fetch(`index.php?url=api-estado&id=${pedidoId}&_t=${Date.now()}`);
            if (!res.ok) return;
            
            const data = await res.json();
            
            if (data.exito) {
                const estadoLimpio = data.estado.toLowerCase().trim();
                const badge = document.getElementById('badge-estado-confirmacion');
                const info = mapaEstados[estadoLimpio] || { clase: 'bg-secondary text-white', texto: estadoLimpio.toUpperCase() };
                
                if (badge) {
                    badge.className = `badge ${info.clase} fs-5 px-4 py-3`;
                    badge.innerText = info.texto;
                }

                if (estadoLimpio === 'completado' || estadoLimpio === 'cancelado') {
                    clearInterval(intervaloEstado);
                }
            }
        } catch (e) {
            console.error("Error al consultar el estado del pedido:", e);
        }
    }, 3000);
});
</script>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>