<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
</head>
<body>
    <h1>Usuarios Registrados</h1>
    <ul>
        <?php foreach ($usuarios as $user): ?>
            <li><?= $user['Nombre'] ?> (<?= $user ['Correo'] ?>) (<?= $user ['Telefono'] ?>) (<?= $user ['Direccion'] ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>