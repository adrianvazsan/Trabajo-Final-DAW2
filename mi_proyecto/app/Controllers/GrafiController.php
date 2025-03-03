<?php

namespace App\Controllers;

use App\Models\ProductsModel;
use CodeIgniter\RESTful\ResourceController;

class GrafiController extends ResourceController
{
    
    public function getChartData()
    {
        $model = new ProductsModel();
        $data = $model->select('product_name, amount')->findAll();
        return $this->respond($data);
    }

    public function chart()
{
    $session = session();

    // Obtener datos del usuario desde la sesión
    $data = [
        'user_name'  => $session->get('user_name'),
        'user_email' => $session->get('user_email'),
    ];

    return view('graficos', $data); // Pasamos los datos a la vista
}

}
