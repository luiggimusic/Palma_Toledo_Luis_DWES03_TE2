<?php

declare(strict_types=1);

require_once '../app/models/MovementType.php'; // cargo el modelo
require_once '../app/helpers/arrayHelper.php'; // cargo el fichero con las funciones que me permitirán trabajar con los arrays

class MovementTypeController
{
    function __construct() {}

    // GET
    function getAllMovementTypes()
    {
        $dataArray = MovementType::getAll();
        print_r($dataArray);
    }

    function getMovementTypeById($id)
    {
        MovementType::getById($id);
    }

    // POST
    function createMovementType($data)
    {
        $movementTypeData = [
            'movementId' => $data["movementId"],
            'movementName' => $data["movementName"],
        ];

        // Llamo al método estático "create"
        $success = MovementType::create($movementTypeData);

        if ($success) {
            echo "Tipo de movimiento creado correctamente";
        } else {
            echo "No se ha creado el tipo de movimiento";
        }
    }

    // PUT
    function updateMovementType($id, $data)
    {
        $movementTypeData = [
            'id' => $data["id"],
            'movementId' => $data["movementId"],
            'movementName' => $data["movementName"],
        ];
        // Llamo al método estático "update" para actualizar
        $success = MovementType::update($id, $data);

        if ($success) {
            echo "Tipo de movimiento actualizado correctamente";
        } else {
            echo "Error al actualizar";
        }
    }
    function deleteMovementType($id)
    {
        $success = MovementType::delete($id);

        if ($success) {
            echo "Tipo de movimiento eliminado"; 
        } 
        else{
            echo "Error al eliminar";
        }
    }
}
