<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('custom_view');
    }
    public function getUsers(){
        $userModel = new \App\Models\UserModel();
        $users = $userModel->findAll();
        return view('user_list', ['usuarios' => $users]);
    }

    public function create(){
    helper(['form']); // Cargar el helper de formularios

    if ($this->request->getMethod() == 'POST') {
        $rules = [
            'Nombre'  => 'required|min_length[3]|max_length[100]',
            'Correo' => 'required|valid_email|is_unique[uscrs.email]'
        ];

        $messages = [
            'Nombre' => [
                'required'   => 'El campo Nombre es obligatorio.',
                'min_length' => 'El Nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El Nombre no puede exceder los 100 caracteres.'
            ],
            'Correo' => [
                'required'   => 'El campo Correo Electrónico es obligatorio.',
                'valid_email' => 'El correo electrónico no tiene un formato válido.',
                'is_unique'   => 'El correo electrónico ya está registrado.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            // Si las validaciones fallan, devuelve los errores
            return view('create_user', [
                'validation' => $this->validator,
            ]);
        } else {
            // Si las validaciones pasan, guarda los datos
            $userModel = new \App\Models\UserModel();
            $userModel->save([
                'Nombre'  => $this->request->getPost('Nombre'),
                'Correo' => $this->request->getPost('Correo'),
            ]);

            return redirect()->to('/home');
        }
    }

    return view('create_user');


    }
}
