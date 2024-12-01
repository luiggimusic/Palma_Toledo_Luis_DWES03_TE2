<?php
class Category
{
    function __construct() {}

    // GET
    function getAllCategories()
    {
        echo "Hola desde el método getAllCategories() de Category Controller <br>";
    }

    function getCategoryById($id)
    {
        echo "Hola desde el método getCategoryById(" . $id . ") de Category Controller <br>";
        echo "El ID del Category es " . $id . "<br>";
    }

    // POST
    function createCategory($data) {
        echo "Hola desde el método createCategory() de Category Controller <br>";
        echo "Los datos del Category son " .json_encode($data)."<br>";
    }

    // PUT
    function updateCategory($id, $data) {
        echo "Hola desde el método updateCategory() de Category Controller <br>";
        echo "El ID del Category es " . $id . "<br>";
        echo "Los datos del Category son " .json_encode($data)."<br>";
    }
    function deleteCategory($id) {
        echo "Hola desde el método deleteCategory() de Category Controller <br>";
        echo "El ID del Category es " . $id . "<br>";
    }
}
