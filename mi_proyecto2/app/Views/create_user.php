<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
</head>
<body>
    <h1>Crear Usuario</h1>

    <?php if (isset($validation)): ?>
        <div style="color: red;">
            <?= $validation->listErrors(); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('relative/path/to/me/create') ?>" method="post">
        <?= csrf_field(); ?>

        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" value="<?= set_value('name'); ?>">
        <br><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" value="<?= set_value('email'); ?>">
        <br><br>

        <button type="submit">Crear Usuario</button>
    </form>
</body>
</html>