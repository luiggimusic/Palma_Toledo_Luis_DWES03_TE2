<?php

declare(strict_types=1);

require_once '../app/models/Department.php'; // cargo el modelo
require_once '../app/helpers/arrayHelper.php'; // cargo el fichero con las funciones que me permitirán trabajar con los arrays


class DepartmentController
{
    function __construct() {}

    // GET
    function getAllDepartments()
    {
        $dataArray = Department::getAll();
        print_r($dataArray);
    }

    function getDepartmentById($id)
    {
        Department::getById($id);
    }

    // POST
    function createDepartment($data)
    {
        $departmentData = [
            'departmenId' => $data["departmenId"],
            'departmentName' => $data["departmentName"],
        ];

        // Llamo al método estático "create"
        $success = Department::create($departmentData);

        if ($success) {
            echo "Departamento creado correctamente";
        } else {
            echo "No se ha creado el departamento";
        }
    }

    // PUT
    function updateDepartment($id, $data)
    {
        $departmentData = [
            'id' => $data["id"],
            'departmenId' => $data["departmenId"],
            'departmentName' => $data["departmentName"],
        ];
        // Llamo al método estático "update" para actualizar
        $success = Department::update($id, $data);

        if ($success) {
            echo "Departamento actualizado correctamente";
        } else {
            echo "Error al actualizar";
        }
    }

    // DELETE
    function deleteDepartment($id)
    {
        $success = Department::delete($id);

        if ($success) {
            echo "Departamento eliminado";
        } else {
            echo "Error al eliminar";
        }
    }
}
