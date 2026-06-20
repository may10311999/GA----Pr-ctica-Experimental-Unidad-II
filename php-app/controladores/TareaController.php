<?php

require_once __DIR__ . '/../modelos/Tarea.php';
require_once __DIR__ . '/../config/seguridad.php';

class TareaController {

    public function __construct() {
        redirigirSiNoAutenticado();
    }

    public function index() {
        $tarea = new Tarea();
        $tareas = $tarea->obtenerTodas($_SESSION['usuario_id']);

        $titulo = "Mis Tareas";
        ob_start();
        include __DIR__ . '/../vistas/tareas/index.php';
        $contenido = ob_get_clean();
        include __DIR__ . '/../vistas/layout/header.php';
        echo $contenido;
        include __DIR__ . '/../vistas/layout/footer.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            validarTokenCSRF($_POST['token_csrf'] ?? '');

            $titulo = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');

            $errores = [];
            if (strlen($titulo) < 3 || strlen($titulo) > 200) {
                $errores[] = "El titulo debe tener entre 3 y 200 caracteres.";
            }
            if (strlen($descripcion) > 1000) {
                $errores[] = "La descripcion no debe exceder 1000 caracteres.";
            }

            if (empty($errores)) {
                $tarea = new Tarea();
                $tarea->crear($titulo, $descripcion, $_SESSION['usuario_id']);
                $_SESSION['mensaje_exito'] = "Tarea creada exitosamente.";
                header("Location: index.php?accion=tareas");
                exit;
            }

            $tituloPagina = "Crear Tarea";
            ob_start();
            include __DIR__ . '/../vistas/tareas/crear.php';
            $contenido = ob_get_clean();
            include __DIR__ . '/../vistas/layout/header.php';
            echo $contenido;
            include __DIR__ . '/../vistas/layout/footer.php';
        } else {
            $tituloPagina = "Crear Tarea";
            ob_start();
            include __DIR__ . '/../vistas/tareas/crear.php';
            $contenido = ob_get_clean();
            include __DIR__ . '/../vistas/layout/header.php';
            echo $contenido;
            include __DIR__ . '/../vistas/layout/footer.php';
        }
    }

    public function editar() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $tarea = new Tarea();
        $tareaDatos = $tarea->obtenerPorId($id, $_SESSION['usuario_id']);

        if (!$tareaDatos) {
            $_SESSION['mensaje_error'] = "Tarea no encontrada.";
            header("Location: index.php?accion=tareas");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            validarTokenCSRF($_POST['token_csrf'] ?? '');

            $titulo = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $estado = trim($_POST['estado'] ?? '');

            $errores = [];
            if (strlen($titulo) < 3 || strlen($titulo) > 200) {
                $errores[] = "El titulo debe tener entre 3 y 200 caracteres.";
            }
            if (strlen($descripcion) > 1000) {
                $errores[] = "La descripcion no debe exceder 1000 caracteres.";
            }
            if (!in_array($estado, ['pendiente', 'en_progreso', 'completada'])) {
                $errores[] = "Estado no valido.";
            }

            if (empty($errores)) {
                $tarea->actualizar($id, $titulo, $descripcion, $estado, $_SESSION['usuario_id']);
                $_SESSION['mensaje_exito'] = "Tarea actualizada exitosamente.";
                header("Location: index.php?accion=tareas");
                exit;
            }

            $tituloPagina = "Editar Tarea";
            ob_start();
            include __DIR__ . '/../vistas/tareas/editar.php';
            $contenido = ob_get_clean();
            include __DIR__ . '/../vistas/layout/header.php';
            echo $contenido;
            include __DIR__ . '/../vistas/layout/footer.php';
        } else {
            $tituloPagina = "Editar Tarea";
            ob_start();
            include __DIR__ . '/../vistas/tareas/editar.php';
            $contenido = ob_get_clean();
            include __DIR__ . '/../vistas/layout/header.php';
            echo $contenido;
            include __DIR__ . '/../vistas/layout/footer.php';
        }
    }

    public function eliminar() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id <= 0) {
            $_SESSION['mensaje_error'] = "ID de tarea invalido.";
            header("Location: index.php?accion=tareas");
            exit;
        }

        $tarea = new Tarea();
        $tarea->eliminar($id, $_SESSION['usuario_id']);
        $_SESSION['mensaje_exito'] = "Tarea eliminada exitosamente.";
        header("Location: index.php?accion=tareas");
        exit;
    }
}
