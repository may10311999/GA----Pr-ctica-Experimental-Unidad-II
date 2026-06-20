<h2>Editar Tarea</h2>

<form method="POST" action="index.php?accion=tareas&subaccion=editar&id=<?php echo (int)$tareaDatos['id']; ?>" class="form-crud">
    <?php echo campoCSRF(); ?>

    <div class="campo">
        <label for="titulo">Titulo:</label>
        <input type="text" id="titulo" name="titulo" required minlength="3" maxlength="200"
               value="<?php echo sanitizarSalida($tareaDatos['titulo']); ?>">
    </div>

    <div class="campo">
        <label for="descripcion">Descripcion:</label>
        <textarea id="descripcion" name="descripcion" rows="5" maxlength="1000"><?php echo sanitizarSalida($tareaDatos['descripcion']); ?></textarea>
    </div>

    <div class="campo">
        <label for="estado">Estado:</label>
        <select id="estado" name="estado">
            <option value="pendiente" <?php echo $tareaDatos['estado'] === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
            <option value="en_progreso" <?php echo $tareaDatos['estado'] === 'en_progreso' ? 'selected' : ''; ?>>En Progreso</option>
            <option value="completada" <?php echo $tareaDatos['estado'] === 'completada' ? 'selected' : ''; ?>>Completada</option>
        </select>
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
        <button type="submit" class="btn">Actualizar Tarea</button>
        <a href="index.php?accion=tareas" class="btn btn-secundario">Cancelar</a>
    </div>
</form>
