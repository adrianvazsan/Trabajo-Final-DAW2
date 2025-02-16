<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        
        // Capturar los filtros desde la URL (GET)
        $filters = [
            'id' => $this->request->getGet('id'),
            'name' => $this->request->getGet('name'),
            'email' => $this->request->getGet('email'),
            'number_phone' => $this->request->getGet('number_phone'),
            'address' => $this->request->getGet('address'),
            'created_at' => $this->request->getGet('created_at')
        ];
    
        // Configuración de la paginación
        $perPage = 3;
    
        // Aplicar filtros
        $query = $userModel;
        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }
        if (!empty($filters['name'])) {
            $query = $query->like('nombre_usuario', $filters['name']);
        }
        if (!empty($filters['email'])) {
            $query = $query->like('email', $filters['email']);
        }
        if (!empty($filters['number_phone'])) {
            $query = $query->like('number_phone', $filters['number_phone']);
        }
        if (!empty($filters['address'])) {
            $query = $query->like('address', $filters['address']);
        }
        if (!empty($filters['created_at'])) {
            $query = $query->where('DATE(created_at)', $filters['created_at']);
        }
    
        // Obtener usuarios paginados
        $data["users"] = $query->paginate($perPage);
        $data["pager"] = $userModel->pager;
        $data["filters"] = $filters; // Pasamos los filtros a la vista
    
        return view('user_list', $data);
    }
    
    public function saveUser($id = null)
    {
        $userModel = new UserModel();
        helper(['form', 'url']);
        // Cargar datos del usuario si es edición
        $data['user'] = $id ? $userModel->find($id) : null;

        if ($this->request->getMethod() == 'POST') {

            // Reglas de validación
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[8]'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                // Mostrar errores de validación
                $data['validation'] = $validation;
            } else {
                // Preparar datos del formulario
                $userData = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Encriptamos la contraseña antes de guardarla.
                    'id_rol'  => $this->request->getPost('id_rol') ?: 2
                ];

                if ($id) {
                    // Actualizar usuario existente
                    $userModel->update($id, $userData);
                    $message = 'Usuario actualizado correctamente.';
                } else {
                    // Crear nuevo usuario
                    $userModel->save($userData);
                    $message = 'Usuario creado correctamente.';
                }

                // Redirigir al listado con un mensaje de éxito
                return redirect()->to('/users')->with('success', $message);
            }
        }

        // Cargar la vista del formulario (crear/editar)
        return view('user_form', $data);
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        
        // Verificar si el usuario existe
        $user = $userModel->find($id);
        if ($user) {
            // Marcar el usuario como archivado
            $userModel->update($id, ['archivado' => 1]);
            return redirect()->to('/users')->with('success', 'Usuario archivado correctamente.');
        } else {
            return redirect()->to('/users')->with('error', 'Usuario no encontrado.');
        }
    }

    public function restore($id)
    {
        $userModel = new UserModel();
        // Restaurar el usuario archivado
        $userModel->update($id, ['archivado' => 0]);

        return redirect()->to('/users')->with('success', 'Usuario restaurado correctamente.');
    }
}