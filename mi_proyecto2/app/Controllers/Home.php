<?php

namespace App\Controllers; // Reemplaza con el namespace correcto de tu controlador

use App\Models\UserModel; // Reemplaza con el namespace correcto de tu modelo

class Home extends BaseController // Reemplaza "Home" con el nombre de tu controlador si es diferente
{
    // Método por defecto - cargar la vista "welcome_message"
    public function index(): string 
    {
        return view('welcome_message'); // Llama a la vista "welcome_message"
    }

    // Método para obtener y mostrar usuarios
    public function getUsers(): string 
    {
        $userModel = new UserModel(); // Crea una instancia del modelo UserModel
        $users = $userModel->findAll(); // Obtiene todos los registros de usuarios desde la base de datos

        // Carga la vista "user_list" y le pasa los datos de los usuarios
        return view('user_list', ['users' => $users]); 
    }
}