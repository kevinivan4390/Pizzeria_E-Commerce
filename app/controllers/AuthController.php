<?php
// app/controllers/AuthController.php

class AuthController extends Controller {
    
    public function login() {
        // Si ya está autenticado, redirigir al admin
        if (estaAutenticado()) {
            $this->redirect('index.php?url=admin');
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario  = trim($_POST['usuario'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!empty($usuario) && !empty($password)) {
                $usuarioModel = new Usuario($this->pdo);
                $user = $usuarioModel->buscarPorUsuario($usuario);

                if ($user && password_verify($password, $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['usuario_id']     = $user['id'];
                    $_SESSION['usuario_nombre'] = $user['nombre'];
                    $_SESSION['usuario_rol']    = $user['rol'];

                    $this->redirect('index.php?url=admin');
                } else {
                    $error = 'Usuario o contraseña incorrectos.';
                }
            } else {
                $error = 'Por favor completá todos los campos.';
            }
        }

        $this->render('admin/login', ['error' => $error]);
    }

    public function logout() {
        session_destroy();
        $this->redirect('index.php?url=login');
    }
}