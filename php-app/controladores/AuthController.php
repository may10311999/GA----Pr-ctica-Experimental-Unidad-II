<?php

require_once __DIR__ . '/../modelos/Usuario.php';
require_once __DIR__ . '/../config/seguridad.php';

class AuthController {

    public function mostrarRegistro() {
        redirigirSiAutenticado();
        $titulo = "Registro de Usuario";
        ob_start();
        include __DIR__ . '/../vistas/auth/registro.php';
        $contenido = ob_get_clean();
        include __DIR__ . '/../vistas/layout/header.php';
        echo $contenido;
        include __DIR__ . '/../vistas/layout/footer.php';
    }

    public function registrar() {
        redirigirSiAutenticado();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?accion=registro");
            exit;
        }

        validarTokenCSRF($_POST['token_csrf'] ?? '');

        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirmar = $_POST['password_confirmar'] ?? '';

        $errores = [];

        if (strlen($nombre) < 2 || strlen($nombre) > 100) {
            $errores[] = "El nombre debe tener entre 2 y 100 caracteres.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electronico no es valido.";
        }
        if (strlen($password) < 8) {
            $errores[] = "La contrasena debe tener al menos 8 caracteres.";
        }
        if ($password !== $password_confirmar) {
            $errores[] = "Las contrasenas no coinciden.";
        }

        if (empty($errores)) {
            $usuario = new Usuario();
            if ($usuario->emailExiste($email)) {
                $errores[] = "El correo electronico ya esta registrado.";
            } else {
                $usuario->registrar($nombre, $email, $password);
                $_SESSION['mensaje_exito'] = "Cuenta creada con exito. Accede con tus datos.";
                header("Location: index.php?accion=login");
                exit;
            }
        }

        $titulo = "Registro de Usuario";
        ob_start();
        include __DIR__ . '/../vistas/auth/registro.php';
        $contenido = ob_get_clean();
        include __DIR__ . '/../vistas/layout/header.php';
        echo $contenido;
        include __DIR__ . '/../vistas/layout/footer.php';
    }

    public function mostrarLogin() {
        redirigirSiAutenticado();
        $titulo = "Inicio de Sesion";
        ob_start();
        include __DIR__ . '/../vistas/auth/login.php';
        $contenido = ob_get_clean();
        include __DIR__ . '/../vistas/layout/header.php';
        echo $contenido;
        include __DIR__ . '/../vistas/layout/footer.php';
    }

    public function login() {
        redirigirSiAutenticado();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?accion=login");
            exit;
        }

        validarTokenCSRF($_POST['token_csrf'] ?? '');

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $usuario = new Usuario();
        $resultado = $usuario->autenticar($email, $password);

        if ($resultado) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $resultado['id'];
            $_SESSION['usuario_nombre'] = $resultado['nombre'];
            $_SESSION['usuario_email'] = $resultado['email'];

            header("Location: index.php?accion=tareas");
            exit;
        }

        $error = "Credenciales incorrectas.";
        $titulo = "Inicio de Sesion";
        ob_start();
        include __DIR__ . '/../vistas/auth/login.php';
        $contenido = ob_get_clean();
        include __DIR__ . '/../vistas/layout/header.php';
        echo $contenido;
        include __DIR__ . '/../vistas/layout/footer.php';
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: index.php?accion=login");
        exit;
    }
}
