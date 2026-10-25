<?php
// public/index.php

// Mostrar errores en desarrollo (quitar en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Autoload simple de clases
spl_autoload_register(function ($class) {
    // Mapear namespaces a carpetas
    $paths = [
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/models/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Cargar configuración y helpers
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../includes/funciones.php';

// Obtener la URL amigable
$url = $_GET['url'] ?? 'inicio';
$url = rtrim($url, '/');
$url = explode('/', filter_var($url, FILTER_SANITIZE_URL));

// Determinar controlador y método
$controllerName = ucfirst($url[0]) . 'Controller';
$methodName     = $url[1] ?? 'index';
$params         = array_slice($url, 2);

// Mapeo de rutas especiales
$rutasEspeciales = [
    // Rutas públicas
    'inicio'          => ['InicioController', 'index'],
    'menu'            => ['MenuController', 'index'],
    'carrito'         => ['CarritoController', 'index'],
    'checkout'        => ['PedidoController', 'checkout'],
    'procesar'        => ['PedidoController', 'procesar'],
    'confirmacion'    => ['PedidoController', 'confirmacion'],
    'api-estado'      => ['ApiController', 'estadoPedido'],
    'nosotros'        => ['NosotrosController', 'index'],
    'resenas'         => ['ResenasController', 'index'],
    'contacto'        => ['ContactoController', 'index'],

    // Rutas de autenticación
    'login'           => ['AuthController', 'login'],
    'logout'          => ['AuthController', 'logout'],

    // Rutas del admin
    'admin'           => ['AdminController', 'index'],
    'admin-productos' => ['AdminProductosController', 'index'],
    'admin-noticias'  => ['AdminNoticiasController', 'index'],
    'admin-resenas'   => ['AdminResenasController', 'index'],
    'admin-contactos' => ['AdminContactosController', 'index'],
];

// Si la URL coincide con una ruta especial, usarla
if (isset($rutasEspeciales[$url[0]])) {
    $controllerName = $rutasEspeciales[$url[0]][0];
    $methodName     = $rutasEspeciales[$url[0]][1];
    $params         = array_slice($url, 1);
}

// Verificar que el controlador exista
if (!class_exists($controllerName)) {
    http_response_code(404);
    echo "Error 404: Controlador '$controllerName' no encontrado.";
    exit;
}

// Instanciar controlador y llamar al método
$controller = new $controllerName($pdo);

if (!method_exists($controller, $methodName)) {
    http_response_code(404);
    echo "Error 404: Método '$methodName' no encontrado en '$controllerName'.";
    exit;
}

// Llamar al método pasando los parámetros
call_user_func_array([$controller, $methodName], $params);