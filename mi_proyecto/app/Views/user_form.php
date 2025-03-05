<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($user) ? 'Edit User' : 'Create User' ?></title>
    <link rel="shortcut icon" href="<?= base_url("assets/media/logos/favicon.ico")?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="<?= base_url("assets/plugins/global/plugins.bundle.css")?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("assets/css/style.bundle.css")?>" rel="stylesheet" type="text/css" />
</head>
<body id="kt_body" class="bg-body">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url('<?= base_url('assets/media/illustrations/sketchy-1/14.png')?>')">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        

        <!-- Mostrar errores de validación -->
        <?php if (isset($validation)): ?>
            <div class="alert alert-danger">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>
                      

        <!-- Formulario -->
    <a href="../../demo1/dist/index.html" class="mb-12">
        <img alt="Logo" src="<?= base_url("assets/media/logos/logo-coffe.png")?>" class="h-150px" />
    </a>
    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
        <form action="<?= isset($user) ? base_url('users/save/') . $user['id'] : base_url('users/save') ?>" method="post">
            <?= csrf_field(); ?>
            <div class="mb-3">
                <label for="name" class="required form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" 
                    value="<?= isset($user) ? esc($user['name']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="required form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" 
                    value="<?= isset($user) ? esc($user['email']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="required form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Your Password" required>
            </div>
            <button type="submit" class="btn btn-success"><?= isset($user) ? 'Update' : 'Save' ?></button>
            <a href="<?= base_url('users') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    </div>
</div>
</div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
