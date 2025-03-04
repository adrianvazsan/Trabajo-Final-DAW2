<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'pk_id_event';
    protected $allowedFields = ['title', 'start_date', 'end_date', 'description_eng', 'user_id'];

    public function getEvents(int $userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }
}