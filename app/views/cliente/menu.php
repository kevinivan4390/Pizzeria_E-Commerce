<?php 
// app/views/cliente/menu.php
// Los datos vienen del controlador: $categorias, $productos, $pedidosActivos, $configEstadosCliente
require_once __DIR__ . '/../../../includes/header.php'; 
?>

<!-- Sección de Estado de Pedidos Activos -->
<?php if (!empty($pedidosActivos)): ?>
    <?php foreach ($pedidosActivos as $pedido): ?>
        <?php 
        $infoEstado = $configEstadosCliente[$pedido['estado']] ?? ['clase' => 'bg-secondary text-white', 'texto' => strtoupper($pedido['estado'])];
        ?>
        <div class="card border-0 shadow-sm mb-3 bg-white contenedor-seguimiento-pedido" data-pedido-id="<?= e($pedido['id']) ?>">
            <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div>
                    <h5 class="fw-bold mb-1">Estado de tu Pedido #<?= e($pedido['id']) ?></h5>
                    <p class="text-muted small mb-0">Total: <strong><?= formatearPrecio($pedido['total']) ?></strong> — Se actualiza automáticamente.</p>
                </div>
                <div>
                    <span class="badge <?= $infoEstado['clase'] ?> fs-6 px-3 py-2 badge-estado-pedido">
                        <?= $infoEstado['texto'] ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h1 class="fw-bold">Nuestro Menú</h1>
        <p class="text-muted">Seleccioná los productos para armar tu pedido online.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <select id="filtro-categoria" class="form-select">
            <option value="todas">Todas las categorías</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= e($cat['id']) ?>"><?= e($cat['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="row g-4" id="contenedor-productos">
    <?php if (empty($productos)): ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                No hay productos disponibles en este momento.
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($productos as $prod): ?>
            <div class="col-md-6 col-lg-4 tarjeta-producto" data-categoria="<?= e($prod['categoria_id']) ?>">
                <div class="card h-100 shadow-sm border-0">
                    <?php if (!empty($prod['imagen']) && file_exists(__DIR__ . '/../../../public/assets/img/productos/' . $prod['imagen'])): ?>
                        <img src="/pizzeria/public/assets/img/productos/<?= e($prod['imagen']) ?>" class="card-img-top bg-light producto-img" alt="<?= e($prod['nombre']) ?>">
                    <?php else: ?>
                        <div class="bg-light text-center border-bottom d-flex align-items-center justify-content-center producto-img-placeholder">
                            <span class="fs-1">🍕</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold mb-0"><?= e($prod['nombre']) ?></h5>
                            <span class="badge bg-secondary"><?= e($prod['categoria_nombre']) ?></span>
                        </div>
                        
                        <p class="card-text text-muted small flex-grow-1">
                            <?= e($prod['descripcion']) ?>
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                            <span class="fs-5 fw-bold text-success">
                                <?= formatearPrecio($prod['precio']) ?>
                            </span>
                            <button 
                                class="btn btn-primary btn-sm btn-agregar" 
                                data-id="<?= e($prod['id']) ?>"
                                data-nombre="<?= e($prod['nombre']) ?>"
                                data-precio="<?= e($prod['precio']) ?>">
                                ➕ Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Seguimiento automático de TODOS los pedidos activos
    const mapaEstados = {
        'pendiente':  { clase: 'bg-warning text-dark', texto: '⏳ Pedido Recibido (Pendiente)' },
        'en_proceso': { clase: 'bg-info text-dark', texto: '🍕 En Cocina (En Preparación)' },
        'enviado':    { clase: 'bg-primary text-white', texto: '🛵 En Camino (Despachado)' },
        'completado': { clase: 'bg-success text-white', texto: '✅ Entregado (Completado)' },
        'cancelado':  { clase: 'bg-danger text-white', texto: '❌ Cancelado' }
    };

    document.querySelectorAll('.contenedor-seguimiento-pedido').forEach(contenedor => {
        const pedidoId = contenedor.dataset.pedidoId;
        if (!pedidoId) return;

        const intervalo = setInterval(async () => {
            try {
                const res = await fetch(`index.php?url=api-estado&id=${pedidoId}&_t=${Date.now()}`);
                if (!res.ok) return;

                const data = await res.json();

                if (data.exito) {
                    const estadoLimpio = data.estado.toLowerCase().trim();
                    const badge = contenedor.querySelector('.badge-estado-pedido');
                    const info = mapaEstados[estadoLimpio] || { clase: 'bg-secondary text-white', texto: estadoLimpio.toUpperCase() };

                    if (badge) {
                        badge.className = `badge ${info.clase} fs-6 px-3 py-2 badge-estado-pedido`;
                        badge.innerText = info.texto;
                    }

                    // Cuando el pedido está completado o cancelado, lo eliminamos de la vista
                    if (estadoLimpio === 'completado' || estadoLimpio === 'cancelado') {
                        clearInterval(intervalo);
                        contenedor.remove();
                    }
                }
            } catch (e) {
                console.error("Error al consultar el estado del pedido:", e);
            }
        }, 3000);
    });
});
</script>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>