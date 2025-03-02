<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('dashboard');
    }
    public function create()
    {
        helper(['form', 'url']);

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();

            $validation->setRules([
                'name' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'password_confirm' => 'required|matches[password]'
            ]);

            if ($validation->withRequest($this->request)->run()) {
                $userModel = new UserModel();

                $data = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                ];

                if ($userModel->save($data)) {
                    return redirect()->to('/home')->with('success', 'User created successfully');
                } else {
                    return redirect()->back()->with('error', 'Failed to create user');
                }
            } else {
                return view('register', [
                    'validation' => $validation
                ]);
            }
        }

        return view('register');
    }
}