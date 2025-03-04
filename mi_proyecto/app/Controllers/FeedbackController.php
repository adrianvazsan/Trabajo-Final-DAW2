<?php

namespace App\Controllers;

use App\Models\FeedbackModel;
use App\Models\UserModel;

class FeedbackController extends BaseController
{

    protected $session;
    protected $feedbackModel;
    public function __construct()
    {
        helper('url'); // Cargar el helper para redirecciones
        $session = session(); // Obtener la sesión
    
        if (!$session->has('user_id')) {
            redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.')->send();
            exit;
        }
    }
    public function index()
    {
        $session = session();
        
        if (!$session->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }
        
        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Usuario no encontrado.');
        }

        $data = [
            'user_avatar' => 'assets/media/avatars/default.jpg',
            'user_name' => $user['name'] ?? 'Usuario',
            'user_email' => $user['email'] ?? 'correo@example.com',
            'user_phone' => $user['number_phone'] ?? '',
            'users' => $userModel->findAll()
        ];

        $feedbackModel = new FeedbackModel();
        
        // Capturar el filtro de búsqueda desde la URL (GET)
        $search = $this->request->getGet('search');
        $sort = $this->request->getGet('sort') ?? 'id';
        $order = $this->request->getGet('order') ?? 'asc';
    
        // Configuración de la paginación
        $perPage = 10;
    
        // Aplicar filtros
        $query = $feedbackModel;
        if (!empty($search)) {
            $query = $query->groupStart()
                           ->like('id', $search)
                           ->orLike('name', $search)
                           ->orLike('text', $search)
                           ->orLike('rating', $search)
                           ->orLike('created_at', $search)
                           ->groupEnd();
        }
               // Aplicar ordenación
       $query = $query->orderBy($sort, $order);
    
        // Obtener feedbacks paginados
        $data["feedbacks"] = $query->paginate($perPage);
        $data["pager"] = $feedbackModel->pager;
        $data["filters"] = ['search' => $search]; // Pasamos el filtro de búsqueda a la vista
        $data["order"] = $order; // Pasamos el orden a la vista
        return view('feedback_list', $data);
    }
    
public function saveFeedback($id = null)
    {
        if ($this->session->get('id_rol') != 1) {
            return redirect()->to('/feedback')->with('error', 'No tienes permisos para realizar esta acción.');
        }

        helper(['form', 'url']);

        $data['feedback'] = $id ? $this->feedbackModel->find($id) : null;

        if ($this->request->getMethod() == 'POST') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'user_id' => 'required|integer',
                'comments' => 'required|min_length[5]',
                'rating' => 'required|integer|greater_than[0]|less_than[6]',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                $data['validation'] = $validation;
            } else {
                $feedbackData = [
                    'user_id' => $this->request->getPost('user_id'),
                    'comments' => $this->request->getPost('comments'),
                    'rating' => $this->request->getPost('rating'),
                ];

                if ($id) {
                    $this->feedbackModel->update($id, $feedbackData);
                    $message = 'Feedback actualizado correctamente.';
                } else {
                    $this->feedbackModel->save($feedbackData);
                    $message = 'Feedback creado correctamente.';
                }

                return redirect()->to('/feedback')->with('success', $message);
            }
        }
        return view('feedback_form', $data);
    }

    public function delete($id)
    {
        if ($this->session->get('id_rol') != 1) {
            return redirect()->to('/feedback')->with('error', 'No tienes permisos para realizar esta acción.');
        }

        $feedback = $this->feedbackModel->find($id);

        if ($feedback) {
            $this->feedbackModel->delete($id);
            return redirect()->to('/feedback')->with('success', 'Feedback eliminado correctamente.');
        } else {
            return redirect()->to('/feedback')->with('error', 'Feedback no encontrado.');
        }
    }
    public function exportCSV()
    {
    $feedbackModel = new FeedbackModel();
    $feedbacks = $feedbackModel->findAll();

    // Nombre del archivo CSV
    $filename = 'feedbacks_' . date('Ymd') . '.csv';

    // Establecer las cabeceras para la descarga del archivo
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '"');

    // Abrir la salida estándar como un archivo
    $output = fopen('php://output', 'w');

    // Escribir la fila de cabecera
    fputcsv($output, ['ID', 'Nombre', 'Texto', 'Calificación', 'Fecha de Creación']);

    // Escribir los datos de los feedbacks
    foreach ($feedbacks as $feedback) {
        fputcsv($output, [
            $feedback['id'],
            $feedback['name'],
            $feedback['text'],
            $feedback['rating'],
            $feedback['created_at']
        ]);
    }

    // Cerrar el archivo de salida
    fclose($output);
    exit;
    }
}