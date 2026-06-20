<?php

require_once __DIR__ . '/../config/seguridad.php';
require_once __DIR__ . '/../controladores/AuthController.php';
require_once __DIR__ . '/../controladores/TareaController.php';

session_start();
enviarCabecerasSeguridad();

$accion = $_GET['accion'] ?? 'login';
$subaccion = $_GET['subaccion'] ?? 'index';

try {
    switch ($accion) {
        case 'login':
            $controlador = new AuthController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controlador->login();
            } else {
                $controlador->mostrarLogin();
            }
            break;

        case 'registro':
            $controlador = new AuthController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controlador->registrar();
            } else {
                $controlador->mostrarRegistro();
            }
            break;

        case 'logout':
            $controlador = new AuthController();
            $controlador->logout();
            break;

        case 'tareas':
            $controlador = new TareaController();
            switch ($subaccion) {
                case 'crear':
                    $controlador->crear();
                    break;
                case 'editar':
                    $controlador->editar();
                    break;
                case 'eliminar':
                    $controlador->eliminar();
                    break;
                default:
                    $controlador->index();
                    break;
            }
            break;

        default:
            header("HTTP/1.0 404 Not Found");
            echo "<h1>Pagina no encontrada</h1>";
            break;
    }
} catch (Exception $e) {
    $_SESSION['mensaje_error'] = "Error interno del servidor.";
    header("Location: index.php?accion=login");
    exit;
}
