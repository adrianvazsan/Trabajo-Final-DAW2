<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $name = $this->request->getVar("name"); // Obtener el término de búsqueda desde el formulario

        // Aplicar filtro si se introduce un nombre
        if ($name) {
            $query = $userModel->like("nombre_usuario", $name);
        }

        // Configuración de la paginación
        $perPage = 3; // Número de elementos por página
        $data["users"] = $userModel->findAll(); // Obtener usuarios paginados
        $data["pager"] = $userModel->pager; // Instancia del paginador
        $data["name"] = $name; // Mantener el término de búsqueda en la vista
        //$data['users'] = $userModel->findAll(); // Obtener todos los usuarios
        
        return view('user_list', $data); // Cargar la vista con los datos
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
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                // Mostrar errores de validación
                $data['validation'] = $validation;
            } else {
                // Preparar datos del formulario
                $userData = [
                    'nombre_usuario' => $this->request->getPost('nombre'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Encriptamos la contraseña antes de guardarla.
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
        $userModel->delete($id); // Eliminar usuario
        return redirect()->to('/users')->with('success', 'Usuario eliminado correctamente.');
    }
}