<h2>Mis Tareas</h2>

<div class="acciones-tabla">
    <a href="index.php?accion=tareas&subaccion=crear" class="btn">Nueva Tarea</a>
</div>

<?php if (count($tareas) === 0): ?>
    <p class="sin-datos">No tienes tareas registradas. Crea tu primera tarea.</p>
<?php else: ?>
    <div class="tabla-responsive">
        <table>
            <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Estado</th>
                    <th>Fecha Creacion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tareas as $t): ?>
                    <tr>
                        <td><?php echo sanitizarSalida($t['titulo']); ?></td>
                        <td>
                            <span class="estado estado-<?php echo sanitizarSalida($t['estado']); ?>">
                                <?php
                                    $etiquetas = ['pendiente' => 'Pendiente', 'en_progreso' => 'En Progreso', 'completada' => 'Completada'];
                                    echo sanitizarSalida($etiquetas[$t['estado']] ?? $t['estado']);
                                ?>
                            </span>
                        </td>
                        <td><?php echo sanitizarSalida($t['fecha_creacion']); ?></td>
                        <td class="acciones">
                            <a href="index.php?accion=tareas&subaccion=editar&id=<?php echo (int)$t['id']; ?>" class="btn-small">Editar</a>
                            <a href="index.php?accion=tareas&subaccion=eliminar&id=<?php echo (int)$t['id']; ?>"
                               class="btn-small btn-peligro"
                               onclick="return confirm('¿Eliminar esta tarea?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
