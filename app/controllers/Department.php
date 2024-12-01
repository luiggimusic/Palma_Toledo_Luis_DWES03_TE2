<?php
class Department
{
    function __construct() {}

    // GET
    function getAllDepartments()
    {
        echo "Hola desde el método getAllDepartments() de Department Controller <br>";
    }

    function getDepartmentById($id)
    {
        echo "Hola desde el método getDepartmentById(" . $id . ") de Department Controller <br>";
        echo "El ID del Department es " . $id . "<br>";
    }

    // POST
    function createDepartment($data) {
        echo "Hola desde el método createDepartment() de Department Controller <br>";
        echo "Los datos del Department son " .json_encode($data)."<br>";
    }

    // PUT
    function updateDepartment($id, $data) {
        echo "Hola desde el método updateDepartment() de Department Controller <br>";
        echo "El ID del Department es " . $id . "<br>";
        echo "Los datos del Department son " .json_encode($data)."<br>";
    }
    function deleteDepartment($id) {
        echo "Hola desde el método deleteDepartment() de Department Controller <br>";
        echo "El ID del Department es " . $id . "<br>";
    }
}
