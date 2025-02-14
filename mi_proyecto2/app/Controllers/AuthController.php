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
        return view('register'); // Carga y retorna la vista del formulario de registro.
    }

    /**
     * Procesa el registro de un nuevo usuario.
     */
    public function processRegister()
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
        ]);

        // Redirigimos al formulario de inicio de sesión con un mensaje de éxito.
        return redirect()->to('/login')->with('success', 'Usuario registrado correctamente.');
    }

    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function login()
    {
        return view('login'); // Carga y retorna la vista del formulario de inicio de sesión.
    }

    /**
     * Procesa el inicio de sesión del usuario.
     */
    public function processLogin()
    {
        helper(['form', 'url']); // Carga los helpers necesarios para trabajar con formularios y URLs.
        $session = session(); // Inicia una sesión para el usuario.

        // Configuración de las reglas de validación del formulario.
        $rules = [
            'email' => 'required|valid_email', // El correo es obligatorio y debe ser válido.
            'password' => 'required', // La contraseña es obligatoria.
        ];

        // Si la validación falla, volvemos a mostrar el formulario con los errores.
        if (!$this->validate($rules)) {
            return view('login', [
                'validation' => $this->validator, // Pasamos los errores de validación a la vista.
            ]);
        }

        // Si la validación pasa, verificamos las credenciales.
        $userModel = new UserModel();
        $user = $userModel->findByEmail($this->request->getPost('email')); // Buscamos al usuario por su correo.

        if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
            // Si las credenciales son correctas, guardamos datos del usuario en la sesión.
            $session->set([
                'id' => $user['id'],           // ID del usuario.
                'name' => $user['name'],       // Nombre del usuario.
                'email' => $user['email'],     // Correo del usuario.
                'isLoggedIn' => true,          // Bandera para indicar que está logueado.
                'created_at' => $user['created_at'], // Fecha de registro del usuario.
            ]);

            // Redirigimos a la página de inicio con un mensaje de éxito.
            return redirect()->to('/dashboard')->with('success', 'Inicio de sesión exitoso.');
        }

        // Si las credenciales son incorrectas, mostramos un mensaje de error.
        return redirect()->to('/login')->with('error', 'Correo o contraseña incorrectos.');
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
