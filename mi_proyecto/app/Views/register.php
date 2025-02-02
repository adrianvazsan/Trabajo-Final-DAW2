<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="<?= base_url('assets/plugins/global/plugins.bundle.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.bundle.css'); ?>">
</head>
<body>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid p-10 pb-lg-20">
            <div class="w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <form class="form w-100" method="post" action="<?= site_url('user/create'); ?>" id="user_create_form">
                    <?= csrf_field(); ?>
                    <div class="mb-10 text-center">
                        <h1 class="text-dark mb-3">Crear una Cuenta</h1>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bolder text-dark fs-6">Nombre</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="Nombre" value="<?= old('Nombre'); ?>" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bolder text-dark fs-6">Correo Electrónico</label>
                        <input class="form-control form-control-lg form-control-solid" type="email" name="Correo" value="<?= old('Correo'); ?>">
                    </div>
                    <?php if(isset($validation)): ?>
                        <div class="alert alert-danger">
                            <?= $validation->listErrors(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="text-center">
                        <button type="submit" class="btn btn-lg btn-primary">
                            <span class="indicator-label">Registrar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/plugins/global/plugins.bundle.js'); ?>"></script>
    <script src="<?= base_url('assets/js/scripts.bundle.js'); ?>"></script>
</body>
</html>
