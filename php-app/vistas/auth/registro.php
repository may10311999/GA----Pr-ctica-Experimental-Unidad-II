<h2>Registro de Usuario</h2>

<form method="POST" action="index.php?accion=registro" class="form-auth">
    <?php echo campoCSRF(); ?>

    <div class="campo">
        <label for="nombre">Nombre Completo:</label>
        <input type="text" id="nombre" name="nombre" required minlength="2" maxlength="100"
               value="<?php echo isset($_POST['nombre']) ? sanitizarSalida($_POST['nombre']) : ''; ?>">
    </div>

    <div class="campo">
        <label for="email">Correo Electronico:</label>
        <input type="email" id="email" name="email" required
               value="<?php echo isset($_POST['email']) ? sanitizarSalida($_POST['email']) : ''; ?>">
    </div>

    <div class="campo">
        <label for="password">Contrasena (min. 8 caracteres):</label>
        <div class="contenedor-password">
            <input type="password" id="password" name="password" required minlength="8">
            <button type="button" class="toggle-password" onclick="togglePassword('password', this)" tabindex="-1" aria-label="Mostrar contrasena">Mostrar</button>
        </div>
    </div>

    <div class="campo">
        <label for="password_confirmar">Confirmar Contrasena:</label>
        <div class="contenedor-password">
            <input type="password" id="password_confirmar" name="password_confirmar" required minlength="8">
            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmar', this)" tabindex="-1" aria-label="Mostrar contrasena">Mostrar</button>
        </div>
    </div>

    <?php if (!empty($errores)): ?>
        <div class="mensaje error">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo sanitizarSalida($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <button type="submit" class="btn">Registrarse</button>

    <p class="enlace-form">¿Ya tienes cuenta? <a href="index.php?accion=login">Inicia sesion aqui</a></p>
</form>
