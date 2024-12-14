<?php
class Product
{
    function __construct() {}

    // GET
    function getAllProducts()
    {
        echo "Hola desde el método getAllProduct() de Product Controller <br>";
    }

    function getProductById($id)
    {
        echo "Hola desde el método getProductById(" . $id . ") de Product Controller <br>";
        echo "El ID del Product es " . $id . "<br>";
    }

    // POST
    function createProduct($data) {
        echo "Hola desde el método createProduct() de Product Controller <br>";
        echo "Los datos del Product son " .json_encode($data)."<br>";
    }

    // PUT
    function updateProduct($id, $data) {
        echo "Hola desde el método updateProduct() de Product Controller <br>";
        echo "El ID del Product es " . $id . "<br>";
        echo "Los datos del Product son " .json_encode($data)."<br>";
    }
    function deleteProduct($id) {
        echo "Hola desde el método deleteProduct() de Product Controller <br>";
        echo "El ID del Product es " . $id . "<br>";
    }
}
