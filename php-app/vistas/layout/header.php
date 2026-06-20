<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo sanitizarSalida($titulo ?? 'Aplicacion Web'); ?></title>
    <link rel="stylesheet" href="css/estilo.css">
    <script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = 'Ocultar';
        } else {
            input.type = 'password';
            btn.textContent = 'Mostrar';
        }
    }
    </script>
</head>
<body>
    <header>
        <nav>
            <div class="nav-inner">
                <a href="index.php" class="logo">Control Actividades</a>
                <ul>
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <li><a href="index.php?accion=tareas">Actividades</a></li>
                        <li><a href="index.php?accion=tareas&subaccion=crear">Agregar</a></li>
                        <li><span class="usuario-info">Hola, <?php echo sanitizarSalida($_SESSION['usuario_nombre']); ?></span></li>
                        <li><a href="index.php?accion=logout" class="btn-cerrar">Salir</a></li>
                    <?php else: ?>
                        <li><a href="index.php?accion=login">Acceder</a></li>
                        <li><a href="index.php?accion=registro">Crear Cuenta</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <div class="contenedor">
            <?php if (isset($_SESSION['mensaje_exito'])): ?>
                <div class="mensaje exito"><?php echo sanitizarSalida($_SESSION['mensaje_exito']); unset($_SESSION['mensaje_exito']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['mensaje_error'])): ?>
                <div class="mensaje error"><?php echo sanitizarSalida($_SESSION['mensaje_error']); unset($_SESSION['mensaje_error']); ?></div>
            <?php endif; ?>
