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
            redirect()->to('/login')->with('error', 'You must log in first.')->send();
            exit;
        }
    }
    

    public function index()
    {
        $userModel = new UserModel();
        $session = session();
    
        if (!$session->has('user_id')) {
            return redirect()->to('/login')->with('error', 'You must log in first.');
        }
    
        $user = $userModel->find($session->get('user_id'));
    
        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }
    
        $data = [
            'user_avatar' => 'assets/media/avatars/default.jpg',
            'user_name' => $user['name'] ?? 'Usuario',
            'user_email' => $user['email'] ?? 'correo@example.com',
            'user_phone' => $user['number_phone'] ?? '',
        ];
    
        // Capturar filtros desde la URL (GET)
        $search = $this->request->getGet('search');
        $archived = $this->request->getGet('archived') ?? 'all'; // 'all' por defecto
        $sort = $this->request->getGet('sort') ?? 'id';
        $order = $this->request->getGet('order') ?? 'asc';
    
        // Configuración de la paginación
        $perPage = 3;
    
        // Iniciar la consulta
        $query = $userModel;
    
        // Aplicar filtro de "archivados"
        if ($archived === '0') {
            $query = $query->where('archivado', 0); // Usuarios activos
        } elseif ($archived === '1') {
            $query = $query->where('archivado', 1); // Usuarios archivados
        }
    
        // Aplicar búsqueda dentro del filtro seleccionado
        if (!empty($search)) {
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
        $data["filters"] = [
            'search' => $search,
            'archived' => $archived
        ];
        $data["order"] = $order;
    
        return view('user_list', $data);
    }
    


    
    
    
    public function saveUser($id = null)
    {
        $session = session();
    
        // Solo los administradores pueden acceder
        if ($session->get('id_rol') != 1) {
            return redirect()->to('/users')->with('error', 'You do not have permissions for this action.');
        }
    
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
                'password' => $id ? 'permit_empty|min_length[8]' : 'required|min_length[8]', // La contraseña solo es obligatoria al crear un usuario
            ]);
    
            if (!$validation->withRequest($this->request)->run()) {
                // Mostrar errores de validación
                $data['validation'] = $validation;
            } else {
                // Preparar datos del formulario
                $userData = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'id_rol' => $this->request->getPost('id_rol') ?: 2,
                ];
    
                // Si se envió una nueva contraseña, actualizarla
                if ($this->request->getPost('password')) {
                    $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                }
    
                if ($id) {
                    // Actualizar usuario existente
                    $userModel->update($id, $userData);
                    $message = 'User updated successfully.';
                } else {
                    // Crear nuevo usuario
                    $userModel->save($userData);
                    $message = 'User created successfully.';
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
            return redirect()->to('/users')->with('success', 'User archived successfully.');
        } else {
            return redirect()->to('/users')->with('error', 'User not found.');
        }
    }
    
    

    public function restore($id)
{
    $session = session();

    // Solo los administradores pueden restaurar usuarios
    if ($session->get('id_rol') != 1) {
        return redirect()->to('/users')->with('error', 'You do not have permissions for this action.');
    }

    $userModel = new UserModel();

    // Verificar si el usuario existe y está archivado
    $user = $userModel->find($id);
    if ($user && $user['archivado'] == 1) {
        // Restaurar el usuario (cambiar archivado a 0)
        $userModel->update($id, ['archivado' => 0]);
        return redirect()->to('/users')->with('success', 'User restored successfully.');
    } else {
        return redirect()->to('/users')->with('error', 'User not found or not archived.');
    }
}


public function exportCSV()
{
    $userModel = new UserModel();
    $users = $userModel->findAll();

    // Nombre del archivo CSV
    $filename = 'users_' . date('Ymd') . '.csv';

    // Establecer las cabeceras para la descarga del archivo
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '"');

    // Abrir la salida estándar como un archivo
    $output = fopen('php://output', 'w');

    // Escribir la fila de cabecera
    fputcsv($output, ['ID', 'Name', 'Email', 'Number_phone', 'reated_at', 'ID Role']);

    // Escribir los datos de los usuarios
    foreach ($users as $user) {
        fputcsv($output, [
            $user['id'],
            $user['name'],
            $user['email'],
            $user['number_phone'],
            $user['created_at'],
            $user['id_rol']
        ]);
    }

    // Cerrar el archivo de salida
    fclose($output);
    exit;
}

}