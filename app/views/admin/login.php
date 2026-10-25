<?php 
// app/views/admin/login.php
// Datos disponibles: $error
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tocci's - Acceso Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h3 class="fw-bold text-center mb-4">Tocci's Admin</h3>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger py-2 mb-3" role="alert">
                                <?= e($error) ?>
                            </div>
                        <?php endif; ?>

                        <form action="index.php?url=login" method="POST">
                            <div class="mb-3">
                                <label for="usuario" class="form-label fw-bold">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" required placeholder="Ej: admin">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mt-2">
                                Iniciar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>