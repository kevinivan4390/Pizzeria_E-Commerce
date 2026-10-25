<?php 
// app/views/cliente/inicio.php
require_once __DIR__ . '/../../../includes/header.php'; 
?>

<!-- Hero Section / Portada Principal -->
<div class="hero-banner position-relative p-5 text-center text-white rounded-3 mb-5 shadow overflow-hidden">
    <div class="col-md-8 p-lg-5 mx-auto my-3">
        <h1 class="display-4 fw-bold mb-3">Las mejores pizzas artesanales de masa madre</h1>
        <p class="lead fw-normal text-light mb-4">Ingredientes frescos, fermentación lenta y el auténtico sabor tradicional en cada porción.</p>
        <a class="btn btn-primary btn-lg fw-bold px-4 py-3 shadow" href="index.php?url=menu">
            🍕 Hacé tu Pedido Online
        </a>
    </div>
</div>

<!-- Seccion Destacados / Beneficios -->
<div class="row g-4 mb-5 text-center">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-4 bg-light card-hover">
            <div class="fs-1 mb-2">🌾</div>
            <h5 class="fw-bold">Masa Madre</h5>
            <p class="text-muted small mb-0">Fermentación natural de 48 horas para una digestión liviana y bordes crocantes.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-4 bg-light card-hover">
            <div class="fs-1 mb-2">🧀</div>
            <h5 class="fw-bold">Ingredientes Seleccionados</h5>
            <p class="text-muted small mb-0">Muzzarella de primera calidad, vegetales frescos y embutidos de primera línea.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-4 bg-light card-hover">
            <div class="fs-1 mb-2">🛵</div>
            <h5 class="fw-bold">Envío Directo</h5>
            <p class="text-muted small mb-0">Tu pedido sale directo del horno a la puerta de tu casa.</p>
        </div>
    </div>
</div>

<!-- Banner de Llamado a la Acción -->
<div class="cta-banner p-4 rounded-3 shadow-sm d-md-flex align-items-center justify-content-between my-5">
    <div>
        <h3 class="fw-bold mb-1">¿Con ganas de una pizza esta noche?</h3>
        <p class="mb-0 text-white-50">Elegí tus gustos favoritos de la carta y armá tu pedido en pocos clics.</p>
    </div>
    <div class="mt-3 mt-md-0">
        <a href="index.php?url=menu" class="btn btn-primary btn-lg fw-bold px-4">
            Ver Menú Completo
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>