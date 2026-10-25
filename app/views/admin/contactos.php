<?php 
// app/views/admin/contactos.php
// Datos disponibles: $mensaje, $contactos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de Contacto - Tocci's Admin</title>
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
                    <li class="nav-item"><a class="nav-link" href="index.php?url=admin-resenas">💬 Reseñas</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="index.php?url=admin-contactos">📨 Contactos</a></li>
                </ul>
                <div class="d-flex align-items-center text-white gap-3">
                    <span>👤 Admin: <strong><?= e($_SESSION['usuario_nombre'] ?? 'Administrador') ?></strong></span>
                    <a href="index.php?url=logout" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <h2 class="fw-bold mb-4">Consultas de Contacto</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= e($mensaje) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (empty($contactos)): ?>
            <div class="alert alert-info text-center">No hay mensajes de contacto recibidos por ahora.</div>
        <?php else: ?>
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Nombre</th>
                                    <th>Datos de Contacto</th>
                                    <th>Motivo</th>
                                    <th>Medio Preferido</th>
                                    <th>Mensaje</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contactos as $c): ?>
                                    <tr>
                                        <td><small><?= date('d/m/Y H:i', strtotime($c['fecha'])) ?></small></td>
                                        <td class="fw-bold"><?= e($c['nombre']) ?></td>
                                        <td>
                                            <small class="d-block">✉️ <?= e($c['email']) ?></small>
                                            <?php if (!empty($c['telefono'])): ?>
                                                <small class="d-block text-muted">📞 <?= e($c['telefono']) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge bg-secondary"><?= e($c['motivo']) ?></span></td>
                                        <td><span class="badge bg-info text-dark"><?= e($c['medio_respuesta']) ?></span></td>
                                        <td><small><?= nl2br(e($c['mensaje'])) ?></small></td>
                                        <td class="text-end">
                                            <form action="index.php?url=admin-contactos" method="POST" class="d-inline" onsubmit="return confirm('¿Borrar esta consulta?')">
                                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
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