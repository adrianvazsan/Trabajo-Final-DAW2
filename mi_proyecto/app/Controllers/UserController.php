<?php

namespace App\Controllers;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function __construct()
    {
        helper('url'); // Cargar el helper para redirecciones
        $session = session(); // Obtener la sesión
    
        if (!$session->has('user_id')) {
            redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.')->send();
            exit;
        }
    }
    

    public function index()
    {
        $userModel = new UserModel();
        
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
        

       // Capturar el filtro de búsqueda y la columna desde la URL (GET)
    $search = $this->request->getGet('search');
    $column = $this->request->getGet('column');
    $sort = $this->request->getGet('sort') ?? 'id';
    $order = $this->request->getGet('order') ?? 'asc';

    // Configuración de la paginación
    $perPage = 3;

    // Aplicar filtros
    $query = $userModel;
    if (!empty($search) && !empty($column)) {
        $query = $query->like($column, $search);
    } elseif (!empty($search)) {
        $query = $query->groupStart()
                       ->like('id', $search)
                       ->orLike('name', $search)
                       ->orLike('email', $search)
                       ->orLike('created_at', $search)
                       ->groupEnd();
    }

       // Aplicar ordenación
       $query = $query->orderBy($sort, $order);

    // Obtener usuarios paginados
    $data["users"] = $query->paginate($perPage);
    $data["pager"] = $userModel->pager;
    $data["filters"] = ['search' => $search, 'column' => $column]; // Pasamos el filtro de búsqueda y la columna a la vista
    $data["order"] = $order; // Pasamos el orden a la vista
    
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

    public function logout()
{
    $session = session();
    $session->destroy(); // Destruir la sesión
    return redirect()->to('/login')->with('success', 'Sesión cerrada correctamente.');
}

}