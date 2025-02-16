<?php

namespace App\Controllers;

use App\Models\ProductsModel;

class ProductController extends BaseController
{
    public function index()
    {
        $productModel = new ProductsModel();
        
        // Capturar el filtro de búsqueda desde la URL (GET)
        $search = $this->request->getGet('search');
    
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
    
        // Obtener productos paginados
        $data["products"] = $query->paginate($perPage);
        $data["pager"] = $productModel->pager;
        $data["filters"] = ['search' => $search]; // Pasamos el filtro de búsqueda a la vista
    
        return view('product_list', $data);
    }
    
    public function saveProduct($id = null)
    {
        $productModel = new ProductsModel();
        helper(['form', 'url']);
        // Cargar datos del producto si es edición
        $data['product'] = $id ? $productModel->find($id) : null;

        if ($this->request->getMethod() == 'post') {

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
}