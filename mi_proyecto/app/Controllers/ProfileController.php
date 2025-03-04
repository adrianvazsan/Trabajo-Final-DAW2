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

    public function saveUser()
    {
        $session = session();
        $userModel = new UserModel();

        
    
        // Obtener el ID del usuario desde la sesión
        $id = $session->get('id');
    
        // Verificar si el usuario está autenticado
        if (!$id) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión.');
        }
    
        // Obtener datos del formulario
        $userData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'number_phone' => $this->request->getPost('number_phone'),
        ];
    
        // Si se envió una nueva contraseña, actualizarla
        if ($this->request->getPost('password')) {
            $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }
    
        // Actualizar los datos del usuario
        $userModel->update($id, $userData);
    
        // Actualizar la sesión con los nuevos datos
        $session->set($userData);
    
        return redirect()->to('/profiles')->with('success', 'Perfil actualizado correctamente.');
  
    }
    
    
    
    


    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login')->with('success', 'Sesión cerrada correctamente.');
    }
}
