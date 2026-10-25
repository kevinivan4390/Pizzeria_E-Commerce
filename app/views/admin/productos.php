<?php 
// app/views/admin/productos.php
// Datos disponibles: $mensaje, $error, $categorias, $productos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Tocci's Admin</title>
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
                    <li class="nav-item"><a class="nav-link active fw-bold" href="index.php?url=admin-productos">🍕 Productos</a></li>
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
            <h2 class="fw-bold mb-0">Catálogo de Productos</h2>
            <button class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#modalProducto" onclick="limpiarFormulario()">
                ➕ Nuevo Producto
            </button>
        </div>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-success alert-dismissible fade show"><?= e($mensaje) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show"><?= e($error) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 70px;">Imagen</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $prod): ?>
                                <tr class="<?= $prod['activo'] ? '' : 'table-secondary text-muted' ?>">
                                    <td>
                                        <?php if (!empty($prod['imagen']) && file_exists(__DIR__ . '/../../../public/assets/img/productos/' . $prod['imagen'])): ?>
                                            <img src="/pizzeria/public/assets/img/productos/<?= e($prod['imagen']) ?>" alt="<?= e($prod['nombre']) ?>" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted border" style="width: 50px; height: 50px;">
                                                🍕
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-bold"><?= e($prod['nombre']) ?></td>
                                    <td><span class="badge bg-secondary"><?= e($prod['categoria_nombre']) ?></span></td>
                                    <td><small><?= e($prod['descripcion'] ?: '-') ?></small></td>
                                    <td class="fw-bold"><?= formatearPrecio($prod['precio']) ?></td>
                                    <td>
                                        <?php if ($prod['activo']): ?>
                                            <span class="badge bg-success">Disponible</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Pausado</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-outline-primary btn-sm me-1" 
                                                onclick='editarProducto(<?= json_encode($prod) ?>)'>
                                            ✏️ Editar
                                        </button>

                                        <form action="index.php?url=admin-productos" method="POST" class="d-inline">
                                            <input type="hidden" name="accion" value="toggle_activo">
                                            <input type="hidden" name="id" value="<?= $prod['id'] ?>">
                                            <?php if ($prod['activo']): ?>
                                                <button type="submit" class="btn btn-outline-warning btn-sm" title="Pausar producto">
                                                    ⏸️ Pausar
                                                </button>
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-outline-success btn-sm" title="Activar producto">
                                                    ▶️ Activar
                                                </button>
                                            <?php endif; ?>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Formulario (Crear / Editar) -->
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="index.php?url=admin-productos" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="accion" value="guardar">
                    <input type="hidden" name="id" id="prod_id" value="">

                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title fw-bold" id="modalTitulo">Nuevo Producto</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="prod_nombre" class="form-label fw-bold">Nombre *</label>
                            <input type="text" class="form-control" id="prod_nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="prod_categoria_id" class="form-label fw-bold">Categoría *</label>
                            <select class="form-select" id="prod_categoria_id" name="categoria_id" required>
                                <option value="">Seleccionar categoría...</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= e($cat['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="prod_precio" class="form-label fw-bold">Precio ($) *</label>
                            <input type="number" step="0.01" class="form-control" id="prod_precio" name="precio" required>
                        </div>
                        <div class="mb-3">
                            <label for="prod_descripcion" class="form-label fw-bold">Descripción</label>
                            <textarea class="form-control" id="prod_descripcion" name="descripcion" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="prod_imagen" class="form-label fw-bold">Imagen del Producto</label>
                            <input type="file" class="form-control" id="prod_imagen" name="imagen" accept="image/*">
                            <div id="preview_imagen_container" class="mt-2 d-none">
                                <small class="text-muted d-block mb-1">Imagen actual:</small>
                                <img id="img_preview" src="" alt="Vista previa" class="img-thumbnail" style="max-height: 80px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary fw-bold">Guardar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function limpiarFormulario() {
        document.getElementById('modalTitulo').textContent = 'Nuevo Producto';
        document.getElementById('prod_id').value = '';
        document.getElementById('prod_nombre').value = '';
        document.getElementById('prod_categoria_id').value = '';
        document.getElementById('prod_precio').value = '';
        document.getElementById('prod_descripcion').value = '';
        document.getElementById('prod_imagen').value = '';
        document.getElementById('preview_imagen_container').classList.add('d-none');
    }

    function editarProducto(prod) {
        document.getElementById('modalTitulo').textContent = 'Editar Producto #' + prod.id;
        document.getElementById('prod_id').value = prod.id;
        document.getElementById('prod_nombre').value = prod.nombre;
        document.getElementById('prod_categoria_id').value = prod.categoria_id;
        document.getElementById('prod_precio').value = prod.precio;
        document.getElementById('prod_descripcion').value = prod.descripcion || '';
        document.getElementById('prod_imagen').value = '';

        const previewContainer = document.getElementById('preview_imagen_container');
        const imgPreview = document.getElementById('img_preview');

        if (prod.imagen) {
            imgPreview.src = '/pizzeria/public/assets/img/productos/' + prod.imagen;
            previewContainer.classList.remove('d-none');
        } else {
            previewContainer.classList.add('d-none');
        }

        const modal = new bootstrap.Modal(document.getElementById('modalProducto'));
        modal.show();
    }
    </script>
</body>
</html>