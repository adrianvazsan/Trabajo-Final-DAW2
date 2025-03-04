<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\UserModel;
class EventController extends BaseController
{

    public function __construct()
    {
        helper('url'); // Cargar el helper para redirecciones
        $session = session(); // Obtener la sesión
    
        if (!$session->has('user_id')) {
            redirect()->to('/login')->with('error', 'You must log in first.')->send();
            exit;
        }
    }
    public function index($userId = null)
    {
        $session = session();
        
        if (!$session->has('user_id')) {
            return redirect()->to('/login')->with('error', 'You must log in first.');
        }
        
        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        $data = [
            'user_avatar' => 'assets/media/avatars/default.jpg',
            'user_name' => $user['name'] ?? 'Usuario',
            'user_email' => $user['email'] ?? 'correo@example.com',
            'user_phone' => $user['number_phone'] ?? '',
            'users' => $userModel->findAll()
        ];
        
        $eventModel = new EventModel();
        
        if ($userId) {
            $data['event'] = $eventModel->getEvents($userId);
        } else {
            $data['event'] = [];
        }

        return view('calendar', $data);
    }


    public function fetchEvents()
    {
        $session = session();
        $userId = $session->get('user_id');
    
        if (!$userId) {
            return $this->response->setJSON(['error' => 'User not authenticated']);
        }
    
        $eventModel = new EventModel();
    
        try {
            $events = $eventModel->getEvents($userId);
    
            // Verificar si los eventos tienen la clave "id"
            foreach ($events as &$event) {
                if (!isset($event['id'])) {
                    $event['id'] = 0; // Valor por defecto para evitar errores
                }
            }
    
            return $this->response->setJSON($events);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }
    

    

    public function addEvent()
{
    $session = session();
    $userId = $session->get('user_id');

    if (!$userId) {
        return $this->response->setJSON(['error' => 'User not authenticated']);
    }

    $eventModel = new EventModel();

    // Captura los datos que se están recibiendo
    $data = [
        'title' => $this->request->getPost('title'),
        'start_date' => $this->request->getPost('start_date'),
        'end_date' => $this->request->getPost('end_date'),
        'description_eng' => $this->request->getPost('description_eng'),
        'user_id' => $userId
    ];

    // Verificar si la inserción tiene errores
    if (!$eventModel->insert($data)) {
        return $this->response->setJSON([
            'error' => 'No se pudo agregar el evento',
            'db_error' => $eventModel->errors(),
            'query' => $eventModel->db->getLastQuery()->getQuery() // Ver última consulta
        ]);
    }

    return $this->response->setJSON(['success' => 'Event added successfully']);
}

    


public function deleteEvent($id)
{
    $session = session();
    $userId = $session->get('user_id');

    if (!$userId) {
        return $this->response->setJSON(['error' => 'User not authenticated']);
    }

    $eventModel = new EventModel();
    $event = $eventModel->find($id);

    if (!$event) {
        return $this->response->setJSON(['error' => 'Event not found']);
    }

    if ($eventModel->delete($id)) {
        return $this->response->setJSON(['success' => 'Successfully deleted event']);
    } else {
        return $this->response->setJSON(['error' => 'Failed to delete event']);
    }
}

}