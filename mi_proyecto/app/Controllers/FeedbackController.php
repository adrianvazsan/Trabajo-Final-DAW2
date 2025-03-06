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
            redirect()->to('/login')->with('error', 'You must log in first.')->send();
            exit;
        }
    }
    public function index()
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

        $feedbackModel = new FeedbackModel();
        
        // Capturar el filtro de búsqueda desde la URL (GET)
        $search = $this->request->getGet('search');
        $sort = $this->request->getGet('sort') ?? 'id';
        $order = $this->request->getGet('order') ?? 'asc';
    
        // Configuración de la paginación
        $perPage = $this->request->getGet('perPage') ?? 10;
        $perPage = is_numeric($perPage) ? (int)$perPage : 10;
    
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
        $data["sort"] = $sort; // Pasamos la columna de orden a la vista
        $data["perPage"]   = $perPage;
        return view('feedback_list', $data);
    }
    
    public function saveFeedback($id = null)
{
    $feedbackModel = new FeedbackModel();
    helper(['form', 'url']);

    // Cargar datos del feedback si es edición
    $data['feedback'] = $id ? $feedbackModel->find($id) : null;

    if ($this->request->getMethod() == 'POST') {
        // Reglas de validación
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[100]',
            'text' => 'required',
            'rating' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Mostrar errores de validación
            $data['validation'] = $validation;
            return view('feedback_form', $data);
        } else {
            // Preparar datos del formulario
            $feedbackData = [
                'name' => $this->request->getPost('name'),
                'text' => $this->request->getPost('text'),
                'rating' => $this->request->getPost('rating'),
                'user_id' => session()->get('user_id'), // Asegurar que se envía el usuario autenticado
            ];

            if ($id) {
                $feedbackModel->update($id, $feedbackData);
                $message = 'Feedback updated correctly.';
            } else {
                $feedbackModel->insert($feedbackData);
                $message = 'Feedback created correctly.';
            }

            // Redirigir al listado con un mensaje de éxito
            return redirect()->to('/feedback')->with('success', $message);
        }
    }

    // Cargar la vista del formulario (crear/editar)
    return view('feedback_form', $data);
}

    
        public function delete($id)
        {
            $feedbackModel = new FeedbackModel();
            
            // Verificar si el ID es válido
            if ($id && $id > 0) {
                // Verificar si el feedback existe
                $feedback = $feedbackModel->find($id);
                if ($feedback) {
                    // Eliminar el feedback
                    $feedbackModel->delete($id);
                    return redirect()->to('/feedback')->with('success', 'Feedback deleted correctly.');
                } else {
                    return redirect()->to('/feedback')->with('error', 'Feedback not found.');
                }
            } else {
                return redirect()->to('/feedback')->with('error', 'Invalid feedback ID.');
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
    fputcsv($output, ['ID', 'Name', 'Text', 'Rating', 'Created At']);

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