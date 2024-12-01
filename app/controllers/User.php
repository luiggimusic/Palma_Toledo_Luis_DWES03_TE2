<?php

declare(strict_types=1);

function getData()
{
    return file_get_contents(__DIR__ . '/../models/users.json', true);
}

// $usersObject = json_decode($usersJSON);
class User
{
    function __construct() {}

    // GET
    function getAllUsers()
    {
        // echo "Hola desde el método getAllUsers() de USER Controller <br>";
        $datos = getData();
        // echo gettype($datos);
        print_r($datos);

        // $datosArray = json_decode($datos);
        // echo gettype($datosArray);
        // print_r($datosArray);

   
    }

    function getUserById($id)
    {
        echo "Hola desde el método getUserById(" . $id . ") de USER Controller <br>";
        echo "El ID del user es " . $id . "<br>";
    }

    // POST
    function createUser($data)
    {
        echo "Hola desde el método createUser() de USER Controller <br>";
        echo "Los datos del USER son " . json_encode($data) . "<br>";
    }

    // PUT
    function updateUser($id, $data)
    {
        echo "Hola desde el método updateUser() de USER Controller <br>";
        echo "El ID del user es " . $id . "<br>";
        echo "Los datos del USER son " . json_encode($data) . "<br>";
    }
    function deleteUser($id)
    {
        echo "Hola desde el método deleteUser() de USER Controller <br>";
        echo "El ID del user es " . $id . "<br>";
    }
}
