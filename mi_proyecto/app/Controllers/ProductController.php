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
        $productModel = new ProductsModel();
        helper(['form', 'url']);
        // Cargar datos del producto si es edición
        $data['product'] = $id ? $productModel->find($id) : null;

        if ($this->request->getMethod() == 'POST') {

            // Reglas de validación
            $validation = \Config\Services::validation();
            $validation->setRules([
                'product_name' => 'required|min_length[3]|max_length[100]',
                'amount' => 'required|numeric',
                'origin_product' => 'required|min_length[3]|max_length[100]',
                'type_product' => 'required|min_length[3]|max_length[50]',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                // Mostrar errores de validación
                $data['validation'] = $validation;
            } else {
                // Preparar datos del formulario
                $productData = [
                    'product_name' => $this->request->getPost('product_name'),
                    'amount' => $this->request->getPost('amount'),
                    'origin_product' => $this->request->getPost('origin_product'),
                    'type_product' => $this->request->getPost('type_product'),
                ];

                if ($id) {
                    // Actualizar producto existente
                    $productModel->update($id, $productData);
                    $message = 'Producto actualizado correctamente.';
                } else {
                    // Crear nuevo producto
                    $productModel->save($productData);
                    $message = 'Producto creado correctamente.';
                }

                // Redirigir al listado con un mensaje de éxito
                return redirect()->to('/products')->with('success', $message);
            }
        }

        // Cargar la vista del formulario (crear/editar)
        return view('product_form', $data);
    }

    public function delete($id)
    {
        $productModel = new ProductsModel();
        
        // Verificar si el ID es válido
        if ($id && $id > 0) {
            // Verificar si el producto existe
            $product = $productModel->find($id);
            if ($product) {
                // Eliminar el producto
                $productModel->delete($id);
                return redirect()->to('/products')->with('success', 'Producto eliminado correctamente.');
            } else {
                return redirect()->to('/products')->with('error', 'Producto no encontrado.');
            }
        } else {
            return redirect()->to('/products')->with('error', 'ID de producto inválido.');
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