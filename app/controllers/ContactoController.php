<?php
// app/controllers/ContactoController.php

class ContactoController extends Controller {
    
    public function index() {
        // Mensajes de sesión
        $mensaje = $_SESSION['mensaje_contacto'] ?? '';
        $error   = $_SESSION['error_contacto'] ?? '';
        unset($_SESSION['mensaje_contacto'], $_SESSION['error_contacto']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Campo Honeypot anti-spam
            $honeypot = trim($_POST['website'] ?? '');
            
            if (!empty($honeypot)) {
                $_SESSION['mensaje_contacto'] = '¡Gracias por escribirnos!';
            } else {
                $nombre         = trim($_POST['nombre'] ?? '');
                $email          = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                $telefono       = trim($_POST['telefono'] ?? '');
                $motivo         = trim($_POST['motivo'] ?? '');
                $medioRespuesta = trim($_POST['medio_respuesta'] ?? '');
                $mensajeTexto   = trim($_POST['mensaje'] ?? '');

                if (!empty($nombre) && $email && !empty($motivo) && !empty($medioRespuesta) && !empty($mensajeTexto)) {
                    $stmt = $this->pdo->prepare("
                        INSERT INTO contactos (nombre, email, telefono, motivo, medio_respuesta, mensaje, fecha) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW())
                    ");
                    $stmt->execute([$nombre, $email, $telefono, $motivo, $medioRespuesta, $mensajeTexto]);
                    $_SESSION['mensaje_contacto'] = '¡Mensaje enviado con éxito! Nos vamos a poner en contacto a la brevedad.';
                } else {
                    $_SESSION['error_contacto'] = 'Completá todos los campos obligatorios.';
                }
            }

            // Redirección POST-Redirect-GET
            $this->redirect('index.php?url=contacto');
        }

        $this->render('cliente/contacto', [
            'mensaje' => $mensaje,
            'error'   => $error
        ]);
    }
}