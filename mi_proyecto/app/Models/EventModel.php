<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class EventModel extends Model
{
    protected $table = 'events';

    protected $primaryKey = 'id';

    protected $useTimestamps = true;

    protected $allowedFields = ['title', 'description', 'start', 'end', 'color', 'textColor', 'user_id'];

    public function getEvents(int $userId): array
    {
        return $this->where('user_id', $userId)->findAll();
    }

    public function addEvent(array $data): bool
    {
        return $this->insert($data);
    }

    public function deleteEvent(int $id): bool
    {
        return $this->delete($id);
    }
    



}