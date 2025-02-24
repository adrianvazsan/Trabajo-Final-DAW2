<?php

namespace App\Controllers;

use App\Models\ProfileModel;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function index()
    {

         // Obtener los datos del usuario desde la sesión
         $session = session();
         $userId = $session->get('user_id');
         $userName = $session->get('user_name');
         $userEmail = $session->get('user_email');
 
        // Pasar los datos del usuario a la vista
        $data['user'] = [
            'id' => $userId,
            'name' => $userName,
            'email' => $userEmail,
        ];

        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();

        
        $profileModel = new ProfileModel();
        $data['profiles'] = $profileModel->findAll();
        return view('profile_list', $data);
    }
    
    public function edit($id)
    {
        $profileModel = new ProfileModel();
        $data['profile'] = $profileModel->find($id);

        return view('profile_edit', $data);
    }

    public function update($id)
    {
        $profileModel = new ProfileModel();
        helper(['form', 'url']);

        if ($this->request->getMethod() == 'post') {
            // Reglas de validación
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email',
                'phone' => 'required|min_length[10]',
                'address' => 'required|min_length[5]'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                // Mostrar errores de validación
                $data['validation'] = $validation;
                $data['profile'] = $profileModel->find($id);
                return view('profile_edit', $data);
            } else {
                // Preparar datos del formulario
                $profileData = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                    'address' => $this->request->getPost('address')
                ];

                // Actualizar perfil existente
                $profileModel->update($id, $profileData);
                return redirect()->to('/profiles')->with('success', 'Perfil actualizado correctamente.');
            }
        }
    }
}