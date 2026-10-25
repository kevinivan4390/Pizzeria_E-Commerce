<?php
// app/controllers/AdminNoticiasController.php

class AdminNoticiasController extends Controller {
    
    public function index() {
        // Requerir autenticación
        if (!estaAutenticado()) {
            $this->redirect('index.php?url=login');
        }

        $mensaje = '';
        $noticiaEditar = null;

        // --- PROCESAR ELIMINACIÓN ---
        if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
            $idEliminar = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($idEliminar) {
                // Buscar la imagen actual para borrarla del servidor
                $stmtImg = $this->pdo->prepare("SELECT imagen FROM noticias WHERE id = ?");
                $stmtImg->execute([$idEliminar]);
                $noticiaImg = $stmtImg->fetch();

                if ($noticiaImg && !empty($noticiaImg['imagen'])) {
                    $rutaImg = __DIR__ . '/../../public/assets/img/noticias/' . $noticiaImg['imagen'];
                    if (file_exists($rutaImg)) {
                        unlink($rutaImg);
                    }
                }

                $stmtDel = $this->pdo->prepare("DELETE FROM noticias WHERE id = ?");
                $stmtDel->execute([$idEliminar]);
                $mensaje = '<div class="alert alert-success">Noticia eliminada correctamente.</div>';
            }
        }

        // --- PROCESAR GUARDAR (CREAR / EDITAR) ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $titulo = trim($_POST['titulo'] ?? '');
            $contenido = trim($_POST['contenido'] ?? '');
            $usuario_id = $_SESSION['usuario_id'] ?? null;
            $nombre_imagen = $_POST['imagen_actual'] ?? null;

            if (!empty($titulo) && !empty($contenido)) {
                // Procesar subida de nueva imagen
                if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                    $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                    $nuevoNombre = time() . '_' . uniqid() . '.' . $ext;
                    $directorio = __DIR__ . '/../../public/assets/img/noticias/';

                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777, true);
                    }

                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nuevoNombre)) {
                        // Borrar la imagen anterior si existía
                        if (!empty($nombre_imagen)) {
                            $rutaVieja = $directorio . $nombre_imagen;
                            if (file_exists($rutaVieja)) {
                                unlink($rutaVieja);
                            }
                        }
                        $nombre_imagen = $nuevoNombre;
                    }
                }

                if ($id) {
                    // Modificar
                    $stmt = $this->pdo->prepare("UPDATE noticias SET titulo = ?, contenido = ?, imagen = ? WHERE id = ?");
                    $stmt->execute([$titulo, $contenido, $nombre_imagen, $id]);
                    $mensaje = '<div class="alert alert-success">Noticia actualizada con éxito.</div>';
                } else {
                    // Crear
                    $stmt = $this->pdo->prepare("INSERT INTO noticias (usuario_id, titulo, contenido, imagen, fecha) VALUES (?, ?, ?, ?, NOW())");
                    $stmt->execute([$usuario_id, $titulo, $contenido, $nombre_imagen]);
                    $mensaje = '<div class="alert alert-success">Noticia publicada con éxito.</div>';
                }
            } else {
                $mensaje = '<div class="alert alert-danger">El título y el contenido son obligatorios.</div>';
            }
        }

        // --- CARGAR DATOS PARA EDICIÓN ---
        if (isset($_GET['accion']) && $_GET['accion'] === 'editar' && isset($_GET['id'])) {
            $idEditar = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($idEditar) {
                $stmtEdit = $this->pdo->prepare("SELECT * FROM noticias WHERE id = ?");
                $stmtEdit->execute([$idEditar]);
                $noticiaEditar = $stmtEdit->fetch();
            }
        }

        // --- CONSULTAR LISTADO ---
        $noticias = $this->pdo->query("SELECT n.*, u.nombre AS autor FROM noticias n LEFT JOIN usuarios u ON n.usuario_id = u.id ORDER BY n.fecha DESC")->fetchAll();

        $this->render('admin/noticias', [
            'mensaje'        => $mensaje,
            'noticiaEditar'  => $noticiaEditar,
            'noticias'       => $noticias
        ]);
    }
}