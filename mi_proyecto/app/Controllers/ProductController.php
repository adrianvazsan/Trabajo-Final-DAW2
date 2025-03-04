<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProductsModel;

class ProductController extends BaseController
{
    protected $session;
    protected $productModel;
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
        $productModel = new ProductsModel();
        
        // Capturar el filtro de búsqueda desde la URL (GET)
        $search = $this->request->getGet('search');
        $sort = $this->request->getGet('sort') ?? 'id';
        $order = $this->request->getGet('order') ?? 'asc';
    
        // Configuración de la paginación
        $perPage = 3;
    
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
        return view('product_list', $data);
    }

  
    
    public function saveProduct($id = null)
    {
        if ($this->session->get('rol_id') != 1) {
            return redirect()->to('/products')->with('error', 'No tienes permisos para realizar esta acción.');
        }

        helper(['form', 'url']);

        $data['product'] = $id ? $this->productModel->find($id) : null;

        if ($this->request->getMethod() == 'POST') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|min_length[3]|max_length[100]',
                'description' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                $data['validation'] = $validation;
            } else {
                $productData = [
                    'name' => $this->request->getPost('name'),
                    'description' => $this->request->getPost('description'),
                    'price' => $this->request->getPost('price'),
                    'stock' => $this->request->getPost('stock'),
                ];

                if ($id) {
                    $this->productModel->update($id, $productData);
                    $message = 'Producto actualizado correctamente.';
                } else {
                    $this->productModel->save($productData);
                    $message = 'Producto creado correctamente.';
                }

                return redirect()->to('/products')->with('success', $message);
            }
        }
        return view('product_form', $data);
    }


    public function delete($id)
    {
        if ($this->session->get('rol_id') != 1) {
            return redirect()->to('/products')->with('error', 'No tienes permisos para realizar esta acción.');
        }

        $product = $this->productModel->find($id);

        if ($product) {
            $this->productModel->delete($id);
            return redirect()->to('/products')->with('success', 'Producto eliminado correctamente.');
        } else {
            return redirect()->to('/products')->with('error', 'Producto no encontrado.');
        }
    }

    public function exportCSV()
    {
    $productModel = new ProductsModel();
    $products = $productModel->findAll();

    // Nombre del archivo CSV
    $filename = 'products_' . date('Ymd') . '.csv';

    // Establecer las cabeceras para la descarga del archivo
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '"');

    // Abrir la salida estándar como un archivo
    $output = fopen('php://output', 'w');

    // Escribir la fila de cabecera
    fputcsv($output, ['ID', 'Nombre del Producto', 'Cantidad', 'Origen del Producto', 'Tipo de Producto', 'Fecha de Creación']);

    // Escribir los datos de los productos
    foreach ($products as $product) {
        fputcsv($output, [
            $product['id'],
            $product['product_name'],
            $product['amount'],
            $product['origin_product'],
            $product['type_product'],
            $product['created_at']
        ]);
    }

    // Cerrar el archivo de salida
    fclose($output);
    exit;
    }

}