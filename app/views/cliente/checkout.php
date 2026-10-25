<?php 
// app/views/cliente/checkout.php
require_once __DIR__ . '/../../../includes/header.php'; 
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <h1 class="fw-bold mb-4">Finalizar Pedido</h1>

        <form action="index.php?url=procesar" method="POST" id="form-checkout">
            
            <!-- Datos del Cliente -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold py-3">👤 Tus Datos</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-bold">Nombre y Apellido *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label fw-bold">Teléfono *</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tipo de Entrega -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold py-3">🛵 Tipo de Entrega</div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="tipo_entrega" id="tipo_delivery" value="delivery" checked>
                        <label class="form-check-label" for="tipo_delivery">
                            <strong>Delivery</strong> (Envío a domicilio)
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="tipo_entrega" id="tipo_retiro" value="retiro">
                        <label class="form-check-label" for="tipo_retiro">
                            <strong>Retiro en local</strong> (Pasás a buscarlo)
                        </label>
                    </div>
                    <div id="campo-direccion">
                        <label for="direccion" class="form-label fw-bold">Dirección de Entrega</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Calle, número, piso/depto, barrio">
                    </div>
                </div>
            </div>

            <!-- Método de Pago -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold py-3">💳 Método de Pago</div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="metodo_pago" id="pago_efectivo" value="efectivo" checked>
                        <label class="form-check-label" for="pago_efectivo">Efectivo</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="metodo_pago" id="pago_transferencia" value="transferencia">
                        <label class="form-check-label" for="pago_transferencia">Transferencia Bancaria</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="metodo_pago" id="pago_mercadopago" value="mercado_pago">
                        <label class="form-check-label" for="pago_mercadopago">Mercado Pago</label>
                    </div>
                </div>
            </div>

            <!-- Notas Adicionales -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold py-3">📝 Notas Adicionales</div>
                <div class="card-body">
                    <textarea class="form-control" id="notas" name="notas" rows="3" placeholder="Ej: Sin orégano, timbre roto, etc."></textarea>
                </div>
            </div>

            <!-- Resumen del Pedido (se llena con JS) -->
            <div class="card shadow-sm border-0 mb-4 bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Resumen del Pedido</h5>
                    <div id="resumen-checkout"></div>
                    <hr>
                    <div class="d-flex justify-content-between fs-5 fw-bold text-success">
                        <span>Total a pagar:</span>
                        <span id="total-checkout">$ 0,00</span>
                    </div>
                </div>
            </div>

            <!-- Campo oculto para enviar el carrito -->
            <input type="hidden" name="carrito_data" id="carrito_data_input">

            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold py-3">
                ✅ Confirmar y Enviar Pedido
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Cargar carrito desde localStorage (MISMA CLAVE QUE main.js)
    const carrito = JSON.parse(localStorage.getItem('tocci_carrito') || '[]');
    
    if (carrito.length === 0) {
        alert('Tu carrito está vacío. Serás redirigido al menú.');
        window.location.href = 'index.php?url=menu';
        return;
    }

    // Llenar el campo oculto con el carrito
    document.getElementById('carrito_data_input').value = JSON.stringify(carrito);

    // Generar resumen
    let resumenHTML = '<ul class="list-unstyled mb-0">';
    let total = 0;

    carrito.forEach(item => {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;
        resumenHTML += `
            <li class="d-flex justify-content-between py-2 border-bottom">
                <span><strong>${item.cantidad}x</strong> ${item.nombre}</span>
                <span class="fw-bold">$ ${subtotal.toFixed(2)}</span>
            </li>
        `;
    });

    resumenHTML += '</ul>';
    document.getElementById('resumen-checkout').innerHTML = resumenHTML;
    document.getElementById('total-checkout').innerText = '$ ' + total.toFixed(2);

    // Mostrar/ocultar dirección según tipo de entrega
    const radioDelivery = document.getElementById('tipo_delivery');
    const radioRetiro = document.getElementById('tipo_retiro');
    const campoDireccion = document.getElementById('campo-direccion');

    function toggleDireccion() {
        if (radioRetiro.checked) {
            campoDireccion.style.display = 'none';
            document.getElementById('direccion').value = '';
        } else {
            campoDireccion.style.display = 'block';
        }
    }

    radioDelivery.addEventListener('change', toggleDireccion);
    radioRetiro.addEventListener('change', toggleDireccion);
});
</script>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>