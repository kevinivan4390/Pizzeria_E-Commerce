<?php 
// app/views/admin/noticias.php
// Datos disponibles: $mensaje, $noticiaEditar, $noticias
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Noticias - Tocci's Admin</title>
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
                    <li class="nav-item"><a class="nav-link" href="index.php?url=admin">📋 Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=admin-productos">🍕 Productos</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="index.php?url=admin-noticias">📰 Noticias</a></li>
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
        <?= $mensaje ?>

        <!-- Formulario (Alta / Edición) -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= $noticiaEditar ? '✏️ Editar Noticia #' . $noticiaEditar['id'] : '➕ Nueva Noticia / Promoción' ?></h5>
                <?php if ($noticiaEditar): ?>
                    <a href="index.php?url=admin-noticias" class="btn btn-sm btn-light">Cancelar Edición</a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <form action="index.php?url=admin-noticias" method="POST" enctype="multipart/form-data">
                    <?php if ($noticiaEditar): ?>
                        <input type="hidden" name="id" value="<?= $noticiaEditar['id'] ?>">
                        <input type="hidden" name="imagen_actual" value="<?= e($noticiaEditar['imagen']) ?>">
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Título</label>
                            <input type="text" name="titulo" class="form-control" required value="<?= e($noticiaEditar['titulo'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Imagen (Opcional)</label>
                            <input type="file" name="imagen" class="form-control" accept="image/*">
                            <?php if ($noticiaEditar && !empty($noticiaEditar['imagen'])): ?>
                                <small class="text-muted">Imagen actual: <?= e($noticiaEditar['imagen']) ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Contenido</label>
                            <textarea name="contenido" class="form-control" rows="4" required><?= e($noticiaEditar['contenido'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success fw-bold px-4">
                                <?= $noticiaEditar ? 'Guardar Cambios' : 'Publicar Noticia' ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla / Listado de Noticias -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Listado de Publicaciones</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($noticias)): ?>
                    <div class="p-4 text-center text-muted">No hay noticias registradas.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Imagen</th>
                                    <th>Título</th>
                                    <th>Fecha</th>
                                    <th>Autor</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($noticias as $n): ?>
                                    <tr>
                                        <td style="width: 90px;">
                                            <?php if (!empty($n['imagen'])): ?>
                                                <img src="/pizzeria/public/assets/img/noticias/<?= e($n['imagen']) ?>" class="rounded" style="width: 70px; height: 50px; object-fit: cover;">
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Sin foto</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?= e($n['titulo']) ?></strong>
                                            <p class="text-muted small mb-0 text-truncate" style="max-width: 350px;">
                                                <?= e($n['contenido']) ?>
                                            </p>
                                        </td>
                                        <td><small><?= date('d/m/Y H:i', strtotime($n['fecha'])) ?></small></td>
                                        <td><small><?= e($n['autor'] ?? 'N/A') ?></small></td>
                                        <td class="text-end">
                                            <a href="index.php?url=admin-noticias&accion=editar&id=<?= $n['id'] ?>" class="btn btn-sm btn-outline-primary me-1">✏️ Editar</a>
                                            <a href="index.php?url=admin-noticias&accion=eliminar&id=<?= $n['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que querés eliminar esta noticia?');">🗑️ Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>