<?php 
// app/views/admin/index.php
// Datos disponibles: $pedidos, $mensaje, $configAdminEstados
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Pedidos - Tocci's Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar del Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php?url=admin">Tocci's - Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active fw-bold" href="index.php?url=admin">📋 Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=admin-productos">🍕 Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=admin-noticias">📰 Noticias</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=admin-resenas">💬 Reseñas</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=admin-contactos">📨 Contactos</a></li>
                </ul>
                <div class="d-flex align-items-center text-white gap-3">
                    <span>👤 Admin: <strong><?= e($_SESSION['usuario_nombre'] ?? 'Administrador') ?></strong></span>
                    <a href="index.php?url=logout" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Gestión de Pedidos</h2>
            <button onclick="location.reload()" class="btn btn-outline-primary btn-sm">🔄 Actualizar Lista</button>
        </div>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= e($mensaje) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (empty($pedidos)): ?>
            <div class="alert alert-info text-center">No hay pedidos registrados por el momento.</div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($pedidos as $p): ?>
                    <?php
                    $items = $p['items'];
                    $infoEstadoAdmin = $configAdminEstados[$p['estado']] ?? ['clase' => 'bg-secondary text-white', 'texto' => strtoupper($p['estado'])];
                    ?>
                    <div class="col-12 col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <span class="fs-5 fw-bold">Pedido #<?= e($p['id']) ?></span>
                                    <small class="text-muted ms-2">(<?= date('d/m/Y H:i', strtotime($p['fecha'])) ?>)</small>
                                </div>
                                <span class="badge <?= $infoEstadoAdmin['clase'] ?> px-3 py-2">
                                    <?= $infoEstadoAdmin['texto'] ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3 small">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Cliente:</strong> <?= e($p['cliente_nombre']) ?></p>
                                        <p class="mb-1"><strong>Teléfono:</strong> <?= e($p['telefono']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Entrega:</strong> <?= ucfirst(e($p['tipo_entrega'])) ?></p>
                                        <p class="mb-1"><strong>Pago:</strong> <?= ucfirst(e($p['metodo_pago'])) ?></p>
                                    </div>
                                    <?php if (!empty($p['direccion'])): ?>
                                        <div class="col-12 mt-1">
                                            <p class="mb-0 text-truncate"><strong>Dirección:</strong> <?= e($p['direccion']) ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($p['notas'])): ?>
                                        <div class="col-12 mt-1">
                                            <p class="mb-0 text-truncate text-muted"><strong>Notas:</strong> <?= e($p['notas']) ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="bg-light p-3 rounded mb-3">
                                    <h6 class="fw-bold mb-2 small text-uppercase text-muted">Detalle de la Comanda</h6>
                                    <ul class="list-unstyled mb-0 small">
                                        <?php foreach ($items as $it): ?>
                                            <li class="d-flex justify-content-between py-1 border-bottom border-white">
                                                <span>
                                                    <strong><?= e($it['cantidad']) ?>x</strong> <?= e($it['producto_nombre']) ?>
                                                    <?php if (!empty($it['aclaraciones'])): ?>
                                                        <br><small class="text-danger">↳ <?= e($it['aclaraciones']) ?></small>
                                                    <?php endif; ?>
                                                </span>
                                                <span class="fw-bold"><?= formatearPrecio($it['precio_unitario'] * $it['cantidad']) ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2 fw-bold fs-6">
                                        <span>Total:</span>
                                        <span class="text-success"><?= formatearPrecio($p['total']) ?></span>
                                    </div>
                                </div>

                                <!-- Acciones rápidas y selector de estado -->
                                <div class="d-flex flex-column gap-2">
                                    <?php if ($p['estado'] === 'pendiente'): ?>
                                        <form action="index.php?url=admin" method="POST">
                                            <input type="hidden" name="accion" value="cambiar_estado">
                                            <input type="hidden" name="pedido_id" value="<?= e($p['id']) ?>">
                                            <input type="hidden" name="estado" value="en_proceso">
                                            <button type="submit" class="btn btn-success btn-sm w-100 fw-bold">
                                                ✅ Aceptar Pedido (Pasar a Cocina)
                                            </button>
                                        </form>
                                    <?php elseif ($p['estado'] === 'en_proceso'): ?>
                                        <form action="index.php?url=admin" method="POST">
                                            <input type="hidden" name="accion" value="cambiar_estado">
                                            <input type="hidden" name="pedido_id" value="<?= e($p['id']) ?>">
                                            <input type="hidden" name="estado" value="enviado">
                                            <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">
                                                🛵 Despachar (Pasar a Enviado)
                                            </button>
                                        </form>
                                    <?php elseif ($p['estado'] === 'enviado'): ?>
                                        <form action="index.php?url=admin" method="POST">
                                            <input type="hidden" name="accion" value="cambiar_estado">
                                            <input type="hidden" name="pedido_id" value="<?= e($p['id']) ?>">
                                            <input type="hidden" name="estado" value="completado">
                                            <button type="submit" class="btn btn-dark btn-sm w-100 fw-bold">
                                                🏁 Marcar como Completado
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <form action="index.php?url=admin" method="POST" class="d-flex gap-2">
                                        <input type="hidden" name="accion" value="cambiar_estado">
                                        <input type="hidden" name="pedido_id" value="<?= e($p['id']) ?>">
                                        <select name="estado" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="pendiente" <?= $p['estado'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                            <option value="en_proceso" <?= $p['estado'] === 'en_proceso' ? 'selected' : '' ?>>En Cocina</option>
                                            <option value="enviado" <?= $p['estado'] === 'enviado' ? 'selected' : '' ?>>Enviado</option>
                                            <option value="completado" <?= $p['estado'] === 'completado' ? 'selected' : '' ?>>Completado</option>
                                            <option value="cancelado" <?= $p['estado'] === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                        </select>
                                        <button type="submit" class="btn btn-outline-secondary btn-sm px-3">Cambiar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    setInterval(() => {
        const elementoActivo = document.activeElement;
        const estaInteractuando = elementoActivo && (elementoActivo.tagName === 'SELECT' || elementoActivo.tagName === 'INPUT' || elementoActivo.tagName === 'TEXTAREA');

        if (!estaInteractuando) {
            location.reload();
        }
    }, 10000);
    </script>
</body>
</html>