<?php

namespace App\Controllers;

use App\Models\UserModel;

use CodeIgniter\Controller;

class ProfileController extends Controller
{
    public function __construct()
    {
        helper(['url', 'form']); // Cargar helpers necesarios
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
        
        return view('profile_list', $data);
    }

    public function saveUser($id = null)
    {
        $session = session();
    
        // Verificar si el usuario está autenticado
        if (!$session->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión.');
        }
    
        // Solo los administradores pueden modificar usuarios
        if ($session->get('id_rol') != 1) {
            return redirect()->to('/users')->with('error', 'No tienes permisos para esta acción.');
        }
    
        $userModel = new UserModel();
        helper(['form', 'url']);
    
        // Obtener datos del usuario si es edición
        $data['user'] = $id ? $userModel->find($id) : null;
    
        if ($this->request->getMethod() == 'POST') {
            // Reglas de validación
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email',
                'number_phone' => 'required|min_length[8]|max_length[15]',
                'password' => $id ? 'permit_empty|min_length[8]' : 'required|min_length[8]', // Solo obligatorio al crear usuario
            ]);
    
            if (!$validation->withRequest($this->request)->run()) {
                // Devolver errores de validación
                $data['validation'] = $validation;
                return view('user_form', $data);
            } else {
                // Datos a actualizar
                $userData = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'number_phone' => $this->request->getPost('number_phone'),
                    'id_rol' => $this->request->getPost('id_rol') ?: 2,
                    'updated_at' => date('Y-m-d H:i:s'), // Agregar timestamp de actualización
                ];
    
                // Si se envió una nueva contraseña, actualizarla
                if ($this->request->getPost('password')) {
                    $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                }
    
                if ($id) {
                    // Actualizar usuario existente
                    $userModel->update($id, $userData);
                    $message = 'Usuario actualizado correctamente.';
                } else {
                    // Crear nuevo usuario
                    $userModel->save($userData);
                    $message = 'Usuario creado correctamente.';
                }
    
                // Redirigir con mensaje de éxito
                return redirect()->to('/users')->with('success', $message);
            }
        }
    
        // Mostrar vista del formulario de usuario
        return view('user_form', $data);
    }
    
    


    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login')->with('success', 'Sesión cerrada correctamente.');
    }
}
