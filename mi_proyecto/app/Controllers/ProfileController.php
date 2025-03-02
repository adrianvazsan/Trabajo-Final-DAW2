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
    die("La función saveUser() se está ejecutando correctamente.");
}


    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login')->with('success', 'Sesión cerrada correctamente.');
    }
}
