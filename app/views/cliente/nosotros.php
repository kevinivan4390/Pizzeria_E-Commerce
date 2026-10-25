<?php 
// app/views/cliente/nosotros.php
// Datos disponibles: $noticias
require_once __DIR__ . '/../../../includes/header.php'; 
?>

<div class="container my-5">
    <!-- Sección 1: Historia Estática -->
    <section class="bg-white rounded-3 shadow-sm p-4 p-md-5 mb-5 border">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h1 class="fw-bold mb-3">Sobre Tocci's</h1>
                <p class="lead text-secondary">Pasión por la verdadera masa madre y los ingredientes seleccionados.</p>
                <p>
                    Tocci's nació como un proyecto familiar con una idea clara: rescatar la esencia de la pizzería tradicional, respetando los tiempos de fermentación lenta y cocinando con productos frescos de la mejor calidad.
                </p>
                <p class="mb-0">
                    Desde nuestros inicios nos enfocamos en perfeccionar cada receta, desde la clásica Muzzerella hasta nuestras opciones especiales rellenas. Nos gusta que cada pedido sea una experiencia para compartir entre amigos y familia.
                </p>
            </div>
            <div class="col-lg-5 text-center">
                <img src="/pizzeria/public/assets/img/tocci.png" alt="Local Tocci's" class="img-fluid rounded-3 shadow-sm" style="max-height: 320px; object-fit: contain;">
            </div>
        </div>
    </section>

    <!-- Sección 2: Blog / Novedades -->
    <section class="mb-4">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Novedades y Promociones</h2>
            <p class="text-muted">Enterate de nuestros últimos lanzamientos, ofertas especiales y noticias.</p>
        </div>

        <?php if (empty($noticias)): ?>
            <div class="alert alert-info text-center rounded-3">No hay novedades publicadas por el momento. ¡Volvé a consultar pronto!</div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($noticias as $n): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                            <?php if (!empty($n['imagen'])): ?>
                                <img src="/pizzeria/public/assets/img/noticias/<?= e($n['imagen']) ?>" class="card-img-top" alt="<?= e($n['titulo']) ?>" style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <div class="text-muted small mb-2 d-flex justify-content-between align-items-center">
                                    <span>📅 <?= date('d/m/Y', strtotime($n['fecha'])) ?></span>
                                    <?php if (!empty($n['autor'])): ?>
                                        <span class="badge bg-light text-dark border">👤 <?= e($n['autor']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <h5 class="card-title fw-bold mb-2"><?= e($n['titulo']) ?></h5>
                                <p class="card-text text-secondary flex-grow-1">
                                    <?= nl2br(e($n['contenido'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>