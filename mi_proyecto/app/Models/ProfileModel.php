<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'number_phone', 'address', 'password', 'updated_at'];
    public function findByMail(string $email): array|null
    {
        return $this->where('email', $email)->first();
    }
}