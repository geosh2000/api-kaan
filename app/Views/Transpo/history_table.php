<?php if (!empty($history)): ?>
    <thead>
        <tr>
            <th>#</th>
            <th>id</th>
            <th>Tipo</th>
            <th>Descripcion</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <!-- Agrega más columnas según sea necesario -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($history as $row): ?>
            <tr>
                <td><?= $row['historyId'] ?></td>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['comment'] ?></td>
                <td><?= $row['user'] ?></td>
                <td><?= $row['dtCreated'] ?></td>
                <!-- Agrega más columnas según sea necesario -->
            </tr>
        <?php endforeach; ?>
    </tbody>
<?php else: ?>
    <tr>
        <td colspan="3">No hay datos disponibles</td>
    </tr>
<?php endif; ?>
