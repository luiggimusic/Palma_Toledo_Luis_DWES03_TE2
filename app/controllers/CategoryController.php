<?php

declare(strict_types=1);

require_once '../app/models/Category.php'; // cargo el modelo
require_once '../app/helpers/arrayHelper.php'; // cargo el fichero con las funciones que me permitirán trabajar con los arrays

class CategoryController
{
    function __construct() {}

    // GET
    function getAllCategories()
    {
        $dataArray = Category::getAll();
        print_r($dataArray);
    }

    function getCategoryById($id)
    {
        Category::getById($id);
    }

    // POST
    function createCategory($data)
    {
        $categoryData = [
            'categoryId' => $data["categoryId"],
            'categoryName' => $data["categoryName"],
        ];

        // Llamo al método estático "create"
        $success = Category::create($categoryData);

        if ($success) {
            echo "Categoría creada correctamente.";
        } else {
            echo "No se ha creado la categoría.";
        }
    }

    // PUT
    function updateCategory($id, $data)
    {
        $categoryData = [
            'id' => $data["id"],
            'categoryId' => $data["categoryId"],
            'categoryName' => $data["categoryName"],
        ];
        // Llamo al método estático "update" para actualizar
        $success = Category::update($id, $data);

        if ($success) {
            echo "Categoría actualizada correctamente."; 
        } 
        else{
            echo "Error al actualizar";
        }
    }
    
    function deleteCategory($id)
    {
        $success = Category::delete($id);

        if ($success) {
            echo "Categoría eliminada"; 
        } 
        else{
            echo "Error al eliminar";
        }
    }
}
