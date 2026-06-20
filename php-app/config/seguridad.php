<?php

function generarTokenCSRF() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['token_csrf'])) {
        $_SESSION['token_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['token_csrf'];
}

function validarTokenCSRF($token) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['token_csrf']) || !hash_equals($_SESSION['token_csrf'], $token)) {
        die("Error: Token CSRF invalido.");
    }
    return true;
}

function campoCSRF() {
    $token = generarTokenCSRF();
    return '<input type="hidden" name="token_csrf" value="' . $token . '">';
}

function sanitizarSalida($dato) {
    return htmlspecialchars($dato, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function sanitizarArray($datos) {
    $limpios = [];
    foreach ($datos as $clave => $valor) {
        if (is_string($valor)) {
            $limpios[$clave] = sanitizarSalida($valor);
        } else {
            $limpios[$clave] = $valor;
        }
    }
    return $limpios;
}

function enviarCabecerasSeguridad() {
    header("X-Frame-Options: DENY");
    header("X-Content-Type-Options: nosniff");
    header("X-XSS-Protection: 1; mode=block");
    header("Referrer-Policy: strict-origin-when-cross-origin");
    header("Permissions-Policy: geolocation=(), camera=(), microphone=()");
    header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'self'");
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
    header("Cache-Control: no-store, no-cache, must-revalidate");
}

function redirigirSiNoAutenticado() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: index.php?accion=login");
        exit;
    }
}

function redirigirSiAutenticado() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['usuario_id'])) {
        header("Location: index.php?accion=tareas");
        exit;
    }
}
