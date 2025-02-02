<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Especifica la tabla que este modelo utilizará en la base de datos.
    protected $table = 'usuarios';

    // La clave primaria de la tabla (en este caso, 'id').
    protected $primaryKey = 'ID';

    // Habilita el uso de las marcas de tiempo automáticas (created_at, updated_at).
    protected $useTimestamps = true;

    // Campos que pueden insertarse o actualizarse en la base de datos de manera masiva.
    protected $allowedFields = ['Nombre', 'Correo', 'Telefono', 'Direccion', 'password'];

    /**
     * Método personalizado para encontrar un usuario por correo electrónico.
     * @param string $Correo El correo electrónico que se desea buscar.
     * @return array|null Retorna un array con los datos del usuario si lo encuentra, o null si no existe.
     */
    public function findByMail(string $Correo): array|null
    {
        return $this->where('Correo', $Correo)->first();
    }
}

?>