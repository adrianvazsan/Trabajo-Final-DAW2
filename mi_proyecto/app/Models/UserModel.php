<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Especifica la tabla que este modelo utilizará en la base de datos.
    protected $table = 'users';

    // La clave primaria de la tabla (en este caso, 'id').
    protected $primaryKey = 'id';

    // Habilita el uso de las marcas de tiempo automáticas (created_at, updated_at).
    protected $useTimestamps = true;

    // Campos que pueden insertarse o actualizarse en la base de datos de manera masiva.
    protected $allowedFields = ['name', 'email', 'number_phone', 'address', 'password', 'archivado', 'created_at', 'updated_at'];


    public function findByMail(string $email): array|null
    {
        return $this->where('email', $email)->first();
    }
}

?>