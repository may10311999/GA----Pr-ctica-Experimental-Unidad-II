<h2>Acceder</h2>

<form method="POST" action="index.php?accion=login" class="form-auth">
    <?php echo campoCSRF(); ?>

    <div class="campo">
        <label for="email">Correo Electronico:</label>
        <input type="email" id="email" name="email" required
               value="<?php echo isset($_POST['email']) ? sanitizarSalida($_POST['email']) : ''; ?>">
    </div>

    <div class="campo">
        <label for="password">Contrasena:</label>
        <div class="contenedor-password">
            <input type="password" id="password" name="password" required minlength="8">
            <button type="button" class="toggle-password" onclick="togglePassword('password', this)" tabindex="-1" aria-label="Mostrar contrasena">Mostrar</button>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="mensaje error"><?php echo sanitizarSalida($error); ?></div>
    <?php endif; ?>

    <button type="submit" class="btn">Acceder</button>

    <p class="enlace-form">¿No tienes cuenta? <a href="index.php?accion=registro">Crear Cuenta</a></p>
</form>
