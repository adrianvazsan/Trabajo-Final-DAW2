<!DOCTYPE html>
<html lang="en">
<head>
    <base href="">
    <title>Formulario de Producto</title>
    <meta name="description" content="Formulario de producto" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="<?= base_url("assets/media/logos/favicon.ico")?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="<?= base_url("assets/plugins/global/plugins.bundle.css")?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("assets/css/style.bundle.css")?>" rel="stylesheet" type="text/css" />
</head>
<body id="kt_body" class="bg-body">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url('<?= base_url('assets/media/illustrations/sketchy-1/14.png')?>')">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <?php if (isset($validation)): ?>
    <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>
                <a href="../../demo1/dist/index.html" class="mb-12">
                    <img alt="Logo" src="<?= base_url("assets/media/logos/logo-coffe.png")?>" class="h-150px" />
                </a>
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <form method="post" action="<?= base_url('products/save' . (isset($product['id']) ? '/' . $product['id'] : '')) ?>">
                        <?= csrf_field() ?>
                        <div class="mb-10">
                            <label class="required form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" value="<?= esc($product['product_name'] ?? '') ?>" required>
                        </div>
                        <div class="mb-10">
                            <label class="required form-label">Amount</label>
                            <input type="number" name="amount" class="form-control" value="<?= esc($product['amount'] ?? '') ?>" required>
                        </div>
                        <div class="mb-10">
                            <label class="required form-label">Product Origin</label>
                            <input type="text" name="origin_product" class="form-control" value="<?= esc($product['origin_product'] ?? '') ?>" required>
                        </div>
                        <div class="mb-10">
                            <label class="required form-label">Product Type</label>
                            <input type="text" name="type_product" class="form-control" value="<?= esc($product['type_product'] ?? '') ?>" required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>var hostUrl = "assets/";</script>
    <script src="<?= base_url("assets/plugins/global/plugins.bundle.js")?>"></script>
    <script src="<?= base_url("public/assets/js/scripts.bundle.js")?>"></script>
    <script src="<?= base_url("assets/js/custom/authentication/sign-up/general.js")?>"></script>
</body>
</html>