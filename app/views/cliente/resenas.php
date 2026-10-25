<?php 
// app/views/cliente/resenas.php
// Datos disponibles: $mensaje, $error, $resenas, $promedio, $totalResenas
require_once __DIR__ . '/../../../includes/header.php'; 
?>

<div class="container my-5">
    <div class="row g-4">
        <!-- Listado de Reseñas Públicas -->
        <div class="col-lg-7">
            <h2 class="fw-bold mb-3">Qué dicen nuestros clientes</h2>
            
            <?php if ($promedio): ?>
                <div class="card bg-light border-0 p-3 mb-4 d-flex flex-row align-items-center gap-3">
                    <div class="display-5 fw-bold text-warning mb-0"><?= $promedio ?></div>
                    <div>
                        <div class="fs-5 text-warning">
                            <?= str_repeat('★', (int)round($promedio)) ?><?= str_repeat('☆', 5 - (int)round($promedio)) ?>
                        </div>
                        <small class="text-muted">Basado en <?= $totalResenas ?> <?= $totalResenas === 1 ? 'opinión' : 'opiniones' ?></small>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (empty($resenas)): ?>
                <div class="alert alert-info">Aún no hay reseñas publicadas. ¡Sé el primero en dejar la tuya!</div>
            <?php else: ?>
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($resenas as $r): ?>
                        <div class="card border-0 shadow-sm p-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="fw-bold mb-0"><?= e($r['nombre']) ?></h6>
                                <small class="text-muted"><?= date('d/m/Y', strtotime($r['fecha'])) ?></small>
                            </div>
                            <div class="text-warning mb-2">
                                <?= str_repeat('★', (int)$r['puntuacion']) ?><?= str_repeat('☆', 5 - (int)$r['puntuacion']) ?>
                            </div>
                            <p class="mb-0 text-secondary"><?= nl2br(e($r['comentario'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Formulario para enviar nueva reseña -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4 sticky-lg-top tarjeta-formulario-sticky">
                <h4 class="fw-bold mb-3">Dejanos tu reseña</h4>

                <?php if (!empty($mensaje)): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= e($mensaje) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= e($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="index.php?url=resenas" method="POST">
                    <!-- Campo oculto Honeypot -->
                    <div class="d-none">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">Tu Nombre *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ej: Lucas">
                    </div>

                    <div class="mb-3">
                        <label for="puntuacion" class="form-label fw-bold">Puntuación *</label>
                        <select class="form-select" id="puntuacion" name="puntuacion" required>
                            <option value="">Seleccionar calificación...</option>
                            <option value="5">⭐⭐⭐⭐⭐ (Excelente)</option>
                            <option value="4">⭐⭐⭐⭐ (Muy Bueno)</option>
                            <option value="3">⭐⭐⭐ (Bueno)</option>
                            <option value="2">⭐⭐ (Regular)</option>
                            <option value="1">⭐ (Malo)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="comentario" class="form-label fw-bold">Comentario *</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="4" required placeholder="Qué te parecieron las pizzas..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        Enviar Reseña
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>