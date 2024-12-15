<?php

class MovementController
{
    function __construct() {}

    // GET
    function getAllMovements()
    {
        echo "Hola desde el método getAllMovements() de Movement Controller <br>";
    }

    function getMovementByData($data)
    {
        echo "Hola desde el método getMovementByData(" . $data . ") de Movement Controller <br>";
        echo "La data del Movement es " . $data . "<br>";
    }

    // POST
    function sale($data) {
        echo "Hola desde el método sale() de Movement Controller <br>";
        echo "Los datos de la venta son " .json_encode($data)."<br>";
    }

    function purchase($data) {
        echo "Hola desde el método purchase() de Movement Controller <br>";
        echo "Los datos de la compra son " .json_encode($data)."<br>";
    }

    function inventoryTransfer($data) {
        echo "Hola desde el método inventoryTransfer() de Movement Controller <br>";
        echo "Los datos de la transferencia de inventario son " .json_encode($data)."<br>";
    }
}
