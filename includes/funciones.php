<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Escapa caracteres especiales para evitar ataques XSS al imprimir datos en HTML.
 */
function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Formatea un número como monto de moneda local.
 */
function formatearPrecio($monto) {
    return '$ ' . number_format((float)$monto, 2, ',', '.');
}

/**
 * Redirecciona a una URL específica y detiene la ejecución del script.
 */
function redireccionar($url) {
    header("Location: " . $url);
    exit;
}

/**
 * Comprueba si hay una sesión administrativa activa.
 */
function estaAutenticado() {
    return isset($_SESSION['usuario_id']);
}

/**
 * Restringe el acceso a páginas privadas si el usuario no está logueado.
 */
function requerirAutenticacion() {
    if (!estaAutenticado()) {
        redireccionar('../admin/login.php');
    }
}