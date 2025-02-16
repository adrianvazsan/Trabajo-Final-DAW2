<?php

namespace App\Controllers;

use App\Models\UserModel; // Importamos el modelo de usuarios para interactuar con la base de datos.

class AuthController extends BaseController
{
    /**
     * Muestra el formulario de registro de usuario.
     */
    public function register()
    {
        helper('form'); // Carga el helper de formularios
        return view('register');

    }

    /**
     * Procesa el registro de un nuevo usuario.
     */
    public function registerProcess()
    {
        helper(['form', 'url']); // Carga los helpers necesarios para trabajar con formularios y URLs.

        // Configuración de las reglas de validación del formulario.
        $rules = [
            'name' => 'required|min_length[3]|max_length[50]', // El nombre es obligatorio y debe tener entre 3 y 50 caracteres.
            'email' => 'required|valid_email|is_unique[users.email]', // El correo debe ser válido y único en la tabla `users`.
            'password' => 'required|min_length[6]', // La contraseña debe ser obligatoria y tener al menos 6 caracteres.
            'password_confirm' => 'required|matches[password]', // La confirmación de la contraseña debe coincidir con la contraseña.
            
        ];

        // Si la validación falla, volvemos a mostrar el formulario con los errores.
        if (!$this->validate($rules)) {
            return view('register', [
                'validation' => $this->validator, // Pasamos los errores de validación a la vista.
            ]);
        }

        // Si la validación pasa, procedemos a guardar el usuario en la base de datos.
        $userModel = new UserModel();
        $userModel->save([
            'name' => $this->request->getPost('name'), // Obtenemos el nombre del formulario.
            'email' => $this->request->getPost('email'), // Obtenemos el correo del formulario.
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Encriptamos la contraseña antes de guardarla.
            'id_rol'  => $this->request->getPost('id_rol') ?: 2
        ]);

        // Redirigimos al formulario de inicio de sesión con un mensaje de éxito.
        return redirect()->to('/login')->with('success', 'Usuario registrado correctamente.');
    }

    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function login()
    {
        return view('login');
    }

    public function loginProcess()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ]);

        if ($validation->withRequest($this->request)->run()) {
            $userModel = new UserModel();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $userModel->findByMail($email); // Usar findByMail en lugar de findByEmail

            if ($user && password_verify($password, $user['password'])) {
                // Verificar la existencia de la clave 'id_rol'
                if (isset($user['id_rol'])) {
                    // Iniciar sesión del usuario y redirigir a dashboard.php
                    return redirect()->to('/dashboard')->with('success', 'Login successful');
                } else {
                    return redirect()->back()->with('error', 'Role ID not found');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid email or password');
            }
        } else {
            return view('login', [
                'validation' => $validation
            ]);
        }
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout()
    {
        $session = session(); // Inicia o accede a la sesión.
        $session->destroy(); // Destruye todos los datos de la sesión.

        // Redirige al formulario de inicio de sesión con un mensaje de éxito.
        return redirect()->to('/login')->with('success', 'Has cerrado sesión correctamente.');
    }
}
