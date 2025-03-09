<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProductsModel;

class ProveedoresController extends BaseController
{
    public function index()
    {
        $session = session();
        
        if (!$session->has('user_id')) {
            return redirect()->to('/login')->with('error', 'You must log in first.');
        }
        
        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        $data = [
            'user_avatar' => 'assets/media/avatars/default.jpg',
            'user_name' => $user['name'] ?? 'Usuario',
            'user_email' => $user['email'] ?? 'correo@example.com',
            'user_phone' => $user['number_phone'] ?? '',
            'users' => $userModel->findAll()
        ];
        $productModel = new ProductsModel();
        
        // Capturar el filtro de búsqueda desde la URL (GET)
        $search = $this->request->getGet('search');
        $sort = $this->request->getGet('sort') ?? 'id';
        $order = $this->request->getGet('order') ?? 'asc';
    
        // Configuración de la paginación
        $perPage = $this->request->getGet('perPage') ?? 3;
        $perPage = is_numeric($perPage) ? (int)$perPage : 3;
    
        // Aplicar filtros
        $query = $productModel;
        if (!empty($search)) {
            $query = $query->groupStart()
                           ->like('id', $search)
                           ->orLike('product_name', $search)
                           ->orLike('amount', $search)
                           ->orLike('origin_product', $search)
                           ->orLike('type_product', $search)
                           ->orLike('created_at', $search)
                           ->groupEnd();
        }
               // Aplicar ordenación
       $query = $query->orderBy($sort, $order);
    
        // Obtener productos paginados
        $data["products"] = $query->paginate($perPage);
        $data["pager"] = $productModel->pager;
        $data["filters"] = ['search' => $search]; // Pasamos el filtro de búsqueda a la vista
        $data["order"] = $order; // Pasamos el orden a la vista
        $data["sort"] = $sort; // Pasamos la columna de orden a la vista
        $data["perPage"]  = $perPage;
        return view('proveedores_list', $data);
    }

    public function export()
    {
        // Lógica para exportar productos
    }

    public function filter()
    {
        // Lógica para filtrar productos
    }
}
