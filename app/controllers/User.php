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

        // Valido los datos insertados en body (formulario) y voy completando el array $arrayErrores con los errores que aparezcan
        $arrayErrores = array();
        if (empty($data["name"])) {
            $arrayErrores["name"] = 'El nombre es obligatorio';
        }
        if (empty($data["surname"])) {
            $arrayErrores["surname"] = 'El apellido es obligatorio';
        }
        if (empty($data["dni"])) {
            $arrayErrores["dni"] = 'El DNI es obligatorio';
        } elseif (!validarDNI($data["dni"])) {
            $arrayErrores["dni"] = 'El DNI no es válido';
        } elseif (existeDNI($usersObject, $data["dni"])) {
            $arrayErrores["dni"] = 'El DNI ya está registrado';
            var_dump(existeDNI($usersObject, $data["dni"]));
        }
        if (empty($data["dateOfBirth"])) {
            $arrayErrores["dateOfBirth"] = 'La fecha de nacimiento es obligatoria';
        }
        if (empty($data["department"])) {
            $arrayErrores["department"] = 'El departamento es obligatorio';
        }

        // Busco el último id que hay en el fichero y le sumo 1
        $id = array_key_last($usersObject) + 1;

        // Una vez que tengo las validaciones, **********el id le indico que agregue en ese índice los datos que recibe según "clave"=>"valor" como un array, que en este caso es $data
        $usersObject[$id] = (array) [
            "id" => $id,
            "name" => $data["name"],
            "surname" => $data["surname"],
            "dni" => $data["dni"],
            "dateOfBirth" => $data["dateOfBirth"],
            "department" => $data["department"]
        ];


        if (!count($arrayErrores) > 0) {
            $json = json_encode(array_values($usersObject), JSON_PRETTY_PRINT);
            file_put_contents(__DIR__ . '/../models/users.json', $json);

            // Creo un array asociativo para mostrar cuando la respuesta ha sido y lo imprimo
            $resp['status'] = 'Se ha creado el usuario';
            print_r($resp);
            print_r($usersObject[$id]);
        } else {

            $resp['failed'] = 'No se ha podido crear el usuario';
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



// Verifica si el DNI ya existe

function existeDNI($usersObject, $dni)
{
    foreach ($usersObject as $user) {
        if ($user["dni"] === $dni) {
            return true;
        }
    }
    return false;
}
/*

,
    {
        "id": 7,
        "name": "Luis",
        "surname": "Palma Toledo",
        "dni": "29672737T",
        "dateOfBirth": "15\/10\/1985",
        "department": "Planning"
    }

    */