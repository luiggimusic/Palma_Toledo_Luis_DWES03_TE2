<?php

declare(strict_types=1);

class User
{
    // Atributos
    // public $name;
    // public $surname;
    // public $dni;
    // public $dateOfBirth;
    // public $department;

    // Constructor
    function __construct() {}

    function getData()
    {
        $usersJSON = file_get_contents(__DIR__ . '/../models/users.json', true);
        $usersObject = json_decode($usersJSON, true);
        return $usersObject;
    }

    // GET
    function getAllUsers()
    {
        $usersJSON = json_encode($this->getData());
        echo $usersJSON;
        // echo gettype($UsersDataJSON);
    }

    function getUserById($id)
    {
        $usersObject = $this->getData();

        // uso json_encode($user) para que sea legible en el navegador
        foreach ($usersObject as $user) {
            if ($user["id"] == $id) {
                $user = json_encode($user);
                echo $user;
                return $user;
            }
        }
        echo "Usuario no encontrado";
        return null;
    }

    // POST
    function createUser($data)
    {
        // Recupero los datos del JSON
        $usersObject = $this->getData();

        // Busco el último id que hay en el fichero y le sumo 1
        $id = array_key_last($usersObject) + 1;

        // Una vez que tengo el id le indico que agregue en ese índice los datos que recibe según "clave"=>"valor" como un array, que en este caso es $data
        $usersObject[$id] = (object) [
            "id" => $id,
            "name" => $data["name"],
            "surname" => $data["surname"],
            "dni" => $data["dni"],
            "dateOfBirth" => $data["dateOfBirth"],
            "department" => $data["department"]
        ];

        // Valido los datos del formulario y voy completando un array con los errores que aparezcan
        $arrayErrores = array();
        if (is_null($data["name"])) {
            $arrayErrores["name"] = 'El nombre es obligatorio';
        }
        if (is_null($data["surname"])) {
            $arrayErrores["surname"] = 'El apellido es obligatorio';
        }
        if (is_null($data["dni"])) {
            $arrayErrores["dni"] = 'El DNI es obligatorio';
        } elseif (!validarDNI($data["dni"])) {
            $arrayErrores["dni"] = 'El DNI no es válido';
        }

        if (!count($arrayErrores) > 0) {
            $json = json_encode(array_values($usersObject), JSON_PRETTY_PRINT);
            file_put_contents(__DIR__ . '/../models/users.json', $json);

            // Creo un array asociativo para mostrar cuando la respuesta ha sido y lo imprimo
            $resp['status'] = 'Se ha creado el usuario';
            print_r($resp);
            print_r($usersObject[$id]);
        } else {

            $resp['failed'] = 'No se a podido crear el usuario';
            print_r($resp);
            print_r($arrayErrores);
        }
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

/*********** Funciones necesarias ***********/
// Validación del DNI del usuario
function letraNif($numero)
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($numero, "XYZ", "012") % 23, 1);
}

function validarDNI($dni)
{
    $numero = substr($dni, 0, 8);
    $letra = letraNif($numero);
    return $dni == $numero . $letra;
}
