<?php

declare(strict_types=1);

require_once '../app/models/Movement.php'; // cargo el modelo
require_once '../app/helpers/arrayHelper.php'; // cargo el fichero con las funciones que me permitirán trabajar con los arrays

class MovementController
{
    function __construct() {}

    // GET
    function getAllMovements()
    {
        $dataArray = Movement::getAll();
        print_r($dataArray);
    }

    function getMovementByData($id)
    {
        Movement::getById($id);

    }

    // POST
    function create($data)
    {
        $movementData = [
            'productCode' => $data["productCode"],
            'productName' => $data["productName"],
            'fromBatchNumber' => $data["fromBatchNumber"],
            'toBatchNumber' => $data["toBatchNumber"],
            'fromLocation' => $data["fromLocation"],
            'toLocation' => $data["toLocation"],
            'quantity' => $data["quantity"],
            'movementId' => $data["movementId"],
            'movementDate' => $data["movementDate"],
        ];

        // Llamo al método estático "create"
        $success = Movement::create($movementData);

        if ($success) {
            echo "Movimiento registrado correctamente";
        } else {
            echo "No se ha registrado el movimiento";
        }
    }
}
