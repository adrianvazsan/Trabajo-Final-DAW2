<?php

namespace App\Controllers;

use App\Models\EventModel;

class EventController extends BaseController
{

    public function __construct()
    {
        helper('url'); // Cargar el helper para redirecciones
        $session = session(); // Obtener la sesión
    
        if (!$session->has('user_id')) {
            redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.')->send();
            exit;
        }
    }
    public function index($userId = null)
    {
        $session = session();

        if ($session->has('user_id')) {
            echo "Estás logueado. Tu ID de usuario es: " . $session->get('user_id');
        } else {
            echo "No has iniciado sesión.";
        }
        
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
        return $this->response->setJSON(['error' => 'Usuario no autenticado']);
    }

    $eventModel = new EventModel();
    $events = $eventModel->getEvents($userId);

    return $this->response->setJSON($events);
}

public function addEvent()
{
    $session = session();
    $userId = $session->get('user_id');

    if (!$userId) {
        return $this->response->setJSON(['error' => 'Usuario no autenticado']);
    }

    $eventModel = new EventModel();

    $data = [
        'title' => $this->request->getPost('title'),
        'start_date' => $this->request->getPost('start_date'),
        'end_date' => $this->request->getPost('end_date'),
        'description_es' => $this->request->getPost('description'),
        'user_id' => $userId
    ];

    if ($eventModel->insert($data)) {
        return $this->response->setJSON(['success' => 'Evento agregado correctamente']);
    } else {
        return $this->response->setJSON(['error' => 'No se pudo agregar el evento']);
    }
}

public function deleteEvent($id)
{
    $session = session();
    $userId = $session->get('user_id');

    if (!$userId) {
        return $this->response->setJSON(['error' => 'Usuario no autenticado']);
    }

    $eventModel = new EventModel();
    $event = $eventModel->find($id);

    if (!$event) {
        return $this->response->setJSON(['error' => 'Evento no encontrado']);
    }

    if ($event['user_id'] != $userId) {
        return $this->response->setJSON(['error' => 'No tienes permisos para eliminar este evento']);
    }

    if ($eventModel->delete($id)) {
        return $this->response->setJSON(['success' => 'Evento eliminado correctamente']);
    } else {
        return $this->response->setJSON(['error' => 'No se pudo eliminar el evento']);
    }
}

}