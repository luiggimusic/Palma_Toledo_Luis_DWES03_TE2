<?php

declare(strict_types=1);

require_once '../app/models/Product.php'; // cargo el modelo
require_once '../app/helpers/arrayHelper.php'; // cargo el fichero con las funciones que me permitirán trabajar con los arrays


class ProductController
{
    function __construct() {}

    // GET
    function getAllProducts()
    {
        $dataArray = Product::getAll();
        print_r($dataArray);
    }

    function getProductById($id)
    {
        Product::getById($id);
    }

    // POST
    function createProduct($data)
    {
        $productData = [
            'productCode' => $data["productCode"],
            'productName' => $data["productName"],
            'batchNumber' => $data["batchNumber"],
            'location' => $data["location"],
            'quantity' => $data["quantity"],
            'category' => $data["category"],
        ];

        // Llamo al método estático "create"
        $success = Product::create($productData);

        if ($success) {
            echo "Producto creado correctamente";
        } else {
            echo "No se ha creado el producto";
        }
    }

    // PUT
    function updateProduct($id, $data)
    {
        $productData = [
            'id' => $data["id"],
            'productCode' => $data["productCode"],
            'productName' => $data["productName"],
            'batchNumber' => $data["batchNumber"],
            'location' => $data["location"],
            'quantity' => $data["quantity"],
            'category' => $data["category"],
        ];



        // Llamo al método estático "update" para actualizar
        $success = Product::update($id, $data);

        if ($success) {
            echo "Producto actualizado correctamente";
        } else {
            echo "Error al actualizar";
        }
    }
    function deleteProduct($id)
    {
        $success = Product::delete($id);
        if ($success) {
            echo "Producto eliminado";
        } else {
            echo "Error al eliminar";
        }
    }
}
