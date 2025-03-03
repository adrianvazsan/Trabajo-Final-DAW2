<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    // Especifica la tabla que este modelo utilizará en la base de datos.
    protected $table = 'products';

    // La clave primaria de la tabla (en este caso, 'id').
    protected $primaryKey = 'id';

    // Habilita el uso de las marcas de tiempo automáticas (created_at, updated_at).
    protected $useTimestamps = true;

    // Campos que pueden insertarse o actualizarse en la base de datos de manera masiva.
    protected $allowedFields = ['product_name', 'amount', 'origin_product', 'type_product', 'created_at'];

    
}