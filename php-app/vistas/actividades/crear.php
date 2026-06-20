<h2>Nueva Actividad</h2>

<form method="POST" action="index.php?accion=tareas&subaccion=crear" class="form-crud">
    <?php echo campoCSRF(); ?>

    <div class="campo">
        <label for="titulo">Titulo:</label>
        <input type="text" id="titulo" name="titulo" required minlength="3" maxlength="200"
               value="<?php echo isset($_POST['titulo']) ? sanitizarSalida($_POST['titulo']) : ''; ?>">
    </div>

    <div class="campo">
        <label for="descripcion">Descripcion:</label>
        <textarea id="descripcion" name="descripcion" rows="5" maxlength="1000"><?php echo isset($_POST['descripcion']) ? sanitizarSalida($_POST['descripcion']) : ''; ?></textarea>
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

    <div class="acciones-form">
        <button type="submit" class="btn">Guardar</button>
        <a href="index.php?accion=tareas" class="btn btn-secundario">Cancelar</a>
    </div>
</form>
