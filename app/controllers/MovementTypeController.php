<?php
class MovementType
{
    function __construct() {}

    // GET
    function getAllMovementTypes()
    {
        echo "Hola desde el método getAllMovementTypes() de MovementType Controller <br>";
    }

    function getMovementTypeById($id)
    {
        echo "Hola desde el método getMovementTypeById(" . $id . ") de MovementType Controller <br>";
        echo "El ID del MovementType es " . $id . "<br>";
    }

    // POST
    function createMovementType($data) {
        echo "Hola desde el método createmovementType() de MovementType Controller <br>";
        echo "Los datos del MovementType son " .json_encode($data)."<br>";
    }

    // PUT
    function updateMovementType($id, $data) {
        echo "Hola desde el método updateMovementType() de MovementType Controller <br>";
        echo "El ID del MovementType es " . $id . "<br>";
        echo "Los datos del MovementType son " .json_encode($data)."<br>";
    }
    function deleteMovementType($id) {
        echo "Hola desde el método deleteMovementType() de MovementType Controller <br>";
        echo "El ID del MovementType es " . $id . "<br>";
    }
}
