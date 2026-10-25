<?php 
// app/views/admin/resenas.php
// Datos disponibles: $mensaje, $resenas
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderación de Reseñas - Tocci's Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php?url=admin">Tocci's - Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?url=admin">📋 Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=admin-productos">🍕 Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=admin-noticias">📰 Noticias</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="index.php?url=admin-resenas">💬 Reseñas</a></li>
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
        <h2 class="fw-bold mb-4">Moderación de Reseñas</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= e($mensaje) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (empty($resenas)): ?>
            <div class="alert alert-info text-center">No hay reseñas para moderar en este momento.</div>
        <?php else: ?>
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Puntuación</th>
                                    <th>Comentario</th>
                                    <th>Estado</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resenas as $r): ?>
                                    <tr>
                                        <td><small><?= date('d/m/Y H:i', strtotime($r['fecha'])) ?></small></td>
                                        <td class="fw-bold"><?= e($r['nombre']) ?></td>
                                        <td class="text-warning"><?= str_repeat('★', (int)$r['puntuacion']) ?></td>
                                        <td><small><?= e($r['comentario']) ?></small></td>
                                        <td>
                                            <?php if ($r['visible']): ?>
                                                <span class="badge bg-success">Aprobada</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Pendiente</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <?php if ($r['visible']): ?>
                                                <form action="index.php?url=admin-resenas" method="POST" class="d-inline">
                                                    <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                                    <input type="hidden" name="accion" value="ocultar">
                                                    <button type="submit" class="btn btn-outline-warning btn-sm">Ocultar</button>
                                                </form>
                                            <?php else: ?>
                                                <form action="index.php?url=admin-resenas" method="POST" class="d-inline">
                                                    <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                                    <input type="hidden" name="accion" value="aprobar">
                                                    <button type="submit" class="btn btn-outline-success btn-sm">Aprobar</button>
                                                </form>
                                            <?php endif; ?>

                                            <form action="index.php?url=admin-resenas" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta reseña?')">
                                                <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                                <input type="hidden" name="accion" value="eliminar">
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Borrar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>