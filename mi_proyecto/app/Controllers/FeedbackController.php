<?php

namespace App\Controllers;

use App\Models\FeedbackModel;

class FeedbackController extends BaseController
{
    public function index()
    {
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
        $feedbackModel = new FeedbackModel();
        helper(['form', 'url']);
        
        // Cargar datos del feedback si es edición
        $data['feedback'] = $id ? $feedbackModel->find($id) : null;

        if ($this->request->getMethod() == 'post') {
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
                ];

                if ($id) {
                    $feedbackModel->update($id, $feedbackData);
                    $message = 'Feedback actualizado correctamente.';
                } else {
                    $feedbackModel->insert($feedbackData);
                    $message = 'Feedback creado correctamente.';
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
                return redirect()->to('/feedback')->with('success', 'Feedback eliminado correctamente.');
            } else {
                return redirect()->to('/feedback')->with('error', 'Feedback no encontrado.');
            }
        } else {
            return redirect()->to('/feedback')->with('error', 'ID de feedback inválido.');
        }
    }
}