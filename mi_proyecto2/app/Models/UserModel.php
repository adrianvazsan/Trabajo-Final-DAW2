<?php

namespace App\Models; // Reemplaza con el namespace correcto de tu modelo

use CodeIgniter\Model; // Importa la clase Model de CodeIgniter

class UserModel extends Model // Reemplaza "UserModel" con el nombre de tu modelo si es diferente
{
    protected $table = 'users'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria de la tabla
    protected $allowedFields = ['name', 'email']; // Campos permitidos para insertar/actualizar

    // ... otros métodos del modelo (si los necesitas) ...
    public function findByEmail(string $email) {
        return $this->where("email", $email)->first();
    }
}