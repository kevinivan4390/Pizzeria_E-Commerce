<?php
require_once __DIR__ . '/funciones.php';

// Consultar si hay pedidos activos (pendiente, en_proceso, enviado) en la sesión del cliente
$tienePedidosActivos = false;
$pedidosActivosSesion = $_SESSION['pedidos_activos'] ?? [];

if (!empty($pedidosActivosSesion)) {
    $placeholders = implode(',', array_fill(0, count($pedidosActivosSesion), '?'));
    $stmtNav = $pdo->prepare("
        SELECT COUNT(*) 
        FROM pedidos 
        WHERE id IN ($placeholders) 
          AND estado NOT IN ('completado', 'cancelado')
    ");
    $stmtNav->execute($pedidosActivosSesion);
    
    if ($stmtNav->fetchColumn() > 0) {
        $tienePedidosActivos = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tocci's - Pizzeria & Focacceria</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos propios -->
    <link rel="stylesheet" href="/pizzeria/public/assets/css/estilos.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand fw-bold" href="index.php?url=inicio">Tocci's</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item"><a class="nav-link" href="index.php?url=inicio">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?url=menu">Menú</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?url=nosotros">Nosotros</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?url=resenas">Reseñas</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?url=contacto">Contacto</a></li>
                        
                        <!-- Muestra el link si hay al menos un pedido activo en curso -->
                        <?php if ($tienePedidosActivos): ?>
                            <li class="nav-item">
                                <a class="nav-link text-warning fw-bold" href="index.php?url=confirmacion">🛵 Seguir mi pedido</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-outline-warning text-white position-relative" href="index.php?url=carrito">
                                🛒 Carrito
                                <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    0
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-4 flex-grow-1">