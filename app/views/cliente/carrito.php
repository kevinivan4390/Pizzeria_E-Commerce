<?php 
// app/views/cliente/carrito.php
require_once __DIR__ . '/../../../includes/header.php'; 
?>

<h1 class="fw-bold mb-4">Tu Carrito de Compras</h1>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th class="col-cantidad">Cantidad</th>
                                <th>Aclaraciones</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tabla-carrito">
                            <!-- Se completa dinámicamente con JS -->
                        </tbody>
                    </table>
                </div>
                <div id="carrito-vacio-msg" class="p-4 text-center text-muted d-none">
                    El carrito está vacío. <a href="index.php?url=menu">Volver al menú</a> para agregar productos.
                </div>
            </div>
        </div>
        <div class="mt-3 text-end">
            <button id="btn-vaciar-carrito" class="btn btn-outline-danger btn-sm">
                🗑️ Vaciar Carrito
            </button>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body">
                <h5 class="fw-bold card-title mb-3">Resumen del Pedido</h5>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <strong id="resumen-subtotal">$ 0,00</strong>
                </div>
                <div class="d-flex justify-content-between mb-3 fs-5 fw-bold text-success">
                    <span>Total estimado:</span>
                    <span id="resumen-total">$ 0,00</span>
                </div>
                <p class="small text-muted mb-3">
                    * El costo definitivo y opciones de envío se confirman en el siguiente paso.
                </p>
                <a href="index.php?url=checkout" id="btn-checkout" class="btn btn-success w-100 fw-bold disabled">
                    Confirmar Pedido ➔
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>