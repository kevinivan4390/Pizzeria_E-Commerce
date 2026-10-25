<?php
// app/controllers/AdminProductosController.php

class AdminProductosController extends Controller {
    
    public function index() {
        // Requerir autenticación
        if (!estaAutenticado()) {
            $this->redirect('index.php?url=login');
        }

        $mensaje = '';
        $error = '';

        // Procesar guardado (Alta / Edición) y toggle activo
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
            $this->procesarAccion($mensaje, $error);
        }

        // Obtener categorías para el desplegable
        $categorias = $this->pdo->query("SELECT * FROM categorias ORDER BY nombre ASC")->fetchAll();

        // Obtener listado completo de productos
        $queryProductos = "
            SELECT p.*, c.nombre AS categoria_nombre 
            FROM productos p 
            INNER JOIN categorias c ON p.categoria_id = c.id 
            ORDER BY p.activo DESC, c.nombre ASC, p.nombre ASC";
        $productos = $this->pdo->query($queryProductos)->fetchAll();

        $this->render('admin/productos', [
            'mensaje'    => $mensaje,
            'error'      => $error,
            'categorias' => $categorias,
            'productos'  => $productos
        ]);
    }

    private function procesarAccion(&$mensaje, &$error) {
        // GUARDAR (Alta / Edición)
        if ($_POST['accion'] === 'guardar') {
            $id           = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $nombre       = trim($_POST['nombre'] ?? '');
            $categoria_id = filter_input(INPUT_POST, 'categoria_id', FILTER_VALIDATE_INT);
            $descripcion  = trim($_POST['descripcion'] ?? '');
            $precio       = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);

            if (!empty($nombre) && $categoria_id && $precio !== false && $precio >= 0) {
                
                // Procesamiento de subida de imagen
                $nombreImagen = $this->procesarImagen($error);

                if (empty($error)) {
                    if ($id) {
                        // Actualizar producto existente
                        if ($nombreImagen) {
                            $stmt = $this->pdo->prepare("
                                UPDATE productos 
                                SET nombre = ?, categoria_id = ?, descripcion = ?, precio = ?, imagen = ? 
                                WHERE id = ?
                            ");
                            $stmt->execute([$nombre, $categoria_id, $descripcion, $precio, $nombreImagen, $id]);
                        } else {
                            $stmt = $this->pdo->prepare("
                                UPDATE productos 
                                SET nombre = ?, categoria_id = ?, descripcion = ?, precio = ? 
                                WHERE id = ?
                            ");
                            $stmt->execute([$nombre, $categoria_id, $descripcion, $precio, $id]);
                        }
                        $mensaje = 'Producto actualizado correctamente.';
                    } else {
                        // Insertar nuevo producto
                        $stmt = $this->pdo->prepare("
                            INSERT INTO productos (nombre, categoria_id, descripcion, precio, imagen, activo) 
                            VALUES (?, ?, ?, ?, ?, 1)
                        ");
                        $stmt->execute([$nombre, $categoria_id, $descripcion, $precio, $nombreImagen]);
                        $mensaje = 'Producto guardado con éxito.';
                    }
                }
            } else {
                $error = 'Por favor completá todos los campos obligatorios correctamente.';
            }
        }

        // TOGGLE ACTIVO (Alta/Baja Lógica)
        if ($_POST['accion'] === 'toggle_activo') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if ($id) {
                $stmt = $this->pdo->prepare("UPDATE productos SET activo = NOT activo WHERE id = ?");
                $stmt->execute([$id]);
                $mensaje = 'Estado del producto modificado.';
            }
        }
    }

    private function procesarImagen(&$error) {
        $nombreImagen = null;

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath   = $_FILES['imagen']['tmp_name'];
            $fileName      = $_FILES['imagen']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

            if (in_array($fileExtension, $extensionesPermitidas)) {
                $nombreImagen = md5(time() . $fileName) . '.' . $fileExtension;
                
                // Directorio de destino en /public/assets/img/productos/
                $uploadDir = __DIR__ . '/../../public/assets/img/productos/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $destPath = $uploadDir . $nombreImagen;

                if (!move_uploaded_file($fileTmpPath, $destPath)) {
                    $error = 'Error al guardar la imagen en el servidor.';
                    $nombreImagen = null;
                }
            } else {
                $error = 'Formato de imagen no permitido. Usá JPG, JPEG, PNG, WEBP o GIF.';
            }
        }

        return $nombreImagen;
    }
}