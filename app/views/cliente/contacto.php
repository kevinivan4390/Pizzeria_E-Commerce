<?php 
// app/views/cliente/contacto.php
// Datos disponibles: $mensaje, $error
require_once __DIR__ . '/../../../includes/header.php'; 
?>

<div class="container my-5">
    <!-- Título y descripción arriba de las columnas -->
    <div class="mb-4">
        <h2 class="fw-bold mb-2">Contacto</h2>
        <p class="text-muted mb-0">¿Tenés alguna duda, consulta o evento especial? Escribinos o acércate a nuestro local.</p>
    </div>

    <div class="row g-4 align-items-stretch">
        <!-- Columna Izquierda: Información de Contacto + Mapa -->
        <div class="col-lg-5 d-flex flex-column">
            <!-- Tarjeta de Info -->
            <div class="card border-0 shadow-sm p-4 bg-white mb-4 rounded-3">
                <div class="d-flex align-items-center mb-3">
                    <span class="fs-4 me-3">📍</span>
                    <div>
                        <strong class="d-block">Dirección</strong>
                        <small class="text-muted">Av. Pellegrini 1234, Rosario</small>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <span class="fs-4 me-3">📞</span>
                    <div>
                        <strong class="d-block">Teléfono / WhatsApp</strong>
                        <small class="text-muted">+54 341 123 4567</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="fs-4 me-3">⏰</span>
                    <div>
                        <strong class="d-block">Horarios</strong>
                        <small class="text-muted">Miércoles a Lunes de 19:30 a 00:00 hs</small>
                    </div>
                </div>
            </div>

            <!-- Mapa -->
            <div class="card border-0 shadow-sm overflow-hidden rounded-3 flex-grow-1" style="min-height: 220px;">
                <iframe 
                    src="https://maps.google.com/maps?q=-31.728540222016125,-60.52469189910954&z=16&output=embed" 
                    class="w-100 h-100 border-0"
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <!-- Columna Derecha: Formulario -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-3 h-100">
                <h4 class="fw-bold mb-4">Envianos un mensaje</h4>

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

                <form action="index.php?url=contacto" method="POST">
                    <!-- Campo oculto Honeypot -->
                    <div class="d-none">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-bold">Nombre *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Tu nombre">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="nombre@correo.com">
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label fw-bold">Teléfono (opcional)</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ej: 3415551234">
                        </div>
                        <div class="col-md-6">
                            <label for="motivo" class="form-label fw-bold">Motivo *</label>
                            <select class="form-select" id="motivo" name="motivo" required>
                                <option value="">Seleccionar motivo...</option>
                                <option value="Consulta General">Consulta General</option>
                                <option value="Reserva / Evento">Reserva / Evento</option>
                                <option value="Sugerencia / Reclamo">Sugerencia / Reclamo</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="medio_respuesta" class="form-label fw-bold">¿Por qué medio preferís que te respondamos? *</label>
                            <select class="form-select" id="medio_respuesta" name="medio_respuesta" required>
                                <option value="">Seleccionar medio...</option>
                                <option value="Email">Email</option>
                                <option value="WhatsApp">WhatsApp</option>
                                <option value="Telefono">Llamada telefónica</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="mensaje" class="form-label fw-bold">Mensaje / Consulta *</label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required placeholder="Escribí tu mensaje acá..."></textarea>
                        </div>
                        <div class="col-12 pt-2">
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                                Enviar Consulta
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>