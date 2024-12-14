<?php
declare(strict_types=1);

require_once '../app/models/User.php'; // cargo el modelo User
require_once '../app/helpers/arrayHelper.php'; // cargo el fichero con las funciones que me permitirán trabajar con los arrays

class UserController
{
    // GET
    function getAllUsers()
    {
        $usersArray = User::getAll(); // Llamo a la función getAll para obtener todos los usuarios
        print_r($usersArray);
    }

    function getUserById($id)
    {
        User::getById($id);
    }

    // POST
    function createUser($data)
    {
        $userData = [
            'name' => $data["name"],
            'surname' => $data["surname"],
            'dni' => $data["dni"],
            'dateOfBirth' => $data["dateOfBirth"],
            'department' => $data["department"]
        ];

        // Llamo al método estático "create" para agregar al usuario
        $success = User::create($userData);

        if ($success) {
            echo "Usuario creado correctamente.";
        } else {
            echo "No se ha creado el usuario.";
        }
    }

    // PUT
    function updateUser($id, $data)
    {// Creo un array asociativo con los datos recibidos
        $userData = [
            'id' => $id,
            'name' => $data["name"],
            'surname' => $data["surname"],
            'dni' => $data["dni"],
            'dateOfBirth' => $data["dateOfBirth"],
            'department' => $data["department"]
        ];

        // Llamo al método estático "update" para actualizar al usuario
        $success = User::update($id, $userData);

        if ($success) {
            echo "Usuario actualizado correctamente."; 
        } 
        else{
            echo "Error al actualizar";
        }
    }

    function deleteUser($id)
    {
        $success = User::delete($id);

        if ($success) {
            echo "Usuario eliminado"; 
        } 
        else{
            echo "Error al eliminar";
        }
    }
}
