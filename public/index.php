<?php

require '../core/Router.php';
require '../app/controllers/User.php';
require '../app/controllers/Department.php';
require '../app/controllers/Product.php';
require '../app/controllers/Movement.php';
require '../app/controllers/MovementType.php';

$url = $_SERVER['QUERY_STRING'];
// echo 'URL = ' . $url . '<br>';

$content = file_get_contents("php://input");
$router = new Router();

/***************************** User ****************************/
$router->add('/public/user/get', array(
    'controller' => 'User',
    'action' => 'getAllUsers'
));

$router->add('/public/user/get/{id}', array(
    'controller' => 'User',
    'action' => 'getUserById'
));

$router->add('/public/user/create', array(
    'controller' => 'User',
    'action' => 'createUser'
));

$router->add('/public/user/update/{id}', array(
    'controller' => 'User',
    'action' => 'updateUser'
));

$router->add('/public/user/delete/{id}', array(
    'controller' => 'User',
    'action' => 'deleteUser'
));


/***************************** Department ****************************/
$router->add('/public/department/get', array(
    'controller' => 'Department',
    'action' => 'getAllDepartments'
));

$router->add('/public/department/get/{id}', array(
    'controller' => 'Department',
    'action' => 'getDepartmentById'
));

$router->add('/public/department/create', array(
    'controller' => 'Department',
    'action' => 'createDepartment'
));

$router->add('/public/department/update/{id}', array(
    'controller' => 'Department',
    'action' => 'updateDepartment'
));

$router->add('/public/department/delete/{id}', array(
    'controller' => 'Department',
    'action' => 'deleteDepartment'
));

/***************************** Product ****************************/
$router->add('/public/product/get', array(
    'controller' => 'Product',
    'action' => 'getAllProducts'
));

$router->add('/public/product/get/{id}', array(
    'controller' => 'Product',
    'action' => 'getProductById'
));

$router->add('/public/product/create', array(
    'controller' => 'Product',
    'action' => 'createProduct'
));

$router->add('/public/product/update/{id}', array(
    'controller' => 'Product',
    'action' => 'updateProduct'
));

$router->add('/public/product/delete/{id}', array(
    'controller' => 'Product',
    'action' => 'deleteProduct'
));

/***************************** Product Category ****************************/
$router->add('/public/category/get', array(
    'controller' => 'Category',
    'action' => 'getAllCategories'
));

$router->add('/public/category/get/{id}', array(
    'controller' => 'Category',
    'action' => 'getCategoryById'
));

$router->add('/public/category/create', array(
    'controller' => 'Category',
    'action' => 'createCategory'
));

$router->add('/public/category/update/{id}', array(
    'controller' => 'Category',
    'action' => 'updateCategory'
));

$router->add('/public/category/delete/{id}', array(
    'controller' => 'Category',
    'action' => 'deleteCategory'
));

/***************************** Movement ****************************/
$router->add('/public/movement/get', array(
    'controller' => 'Movement',
    'action' => 'getAllMovements'
));

$router->add('/public/movement/get/{data}', array(
    'controller' => 'Movement',
    'action' => 'getmovementByData'
));

// Movimiento de venta
$router->add('/public/movement/sale', array(
    'controller' => 'Movement',
    'action' => 'sale'
));

// Movimiento de compra
$router->add('/public/movement/purchase', array(
    'controller' => 'Movement',
    'action' => 'purchase'
));

// Movimiento de transferencia de inventario
$router->add('/public/movement/inventoryTransfer', array(
    'controller' => 'Movement',
    'action' => 'inventoryTransfer'
));

/***************************** Movement type ****************************/
$router->add('/public/movementType/get', array(
    'controller' => 'MovementType',
    'action' => 'getAllMovementTypes'
));

$router->add('/public/movementType/get/{id}', array(
    'controller' => 'MovementType',
    'action' => 'getMovementTypesById'
));

$router->add('/public/movementType/create', array(
    'controller' => 'MovementType',
    'action' => 'createMovementType'
));

$router->add('/public/movementType/update/{id}', array(
    'controller' => 'MovementType',
    'action' => 'updateMovementType'
));

$router->add('/public/movementType/delete/{id}', array(
    'controller' => 'MovementType',
    'action' => 'deleteMovementType'
));


$urlParams = explode('/', $url);

$urlArray = array(
    'HTTP' => $_SERVER['REQUEST_METHOD'],
    'path' => $url,
    'controller' => '',
    'action' => '',
    'params' => ''
);

if (!empty($urlParams[2])) {
    $urlArray['controller'] = ucwords($urlParams[2]);
    if (!empty($urlParams[3])) {
        $urlArray['action'] = $urlParams[3];
        if (!empty($urlParams[4])) {
            $urlArray['params'] = $urlParams[4];
        };
    } else {
        $urlArray['action'] = 'index';
    }
} else {
    $urlArray['controller'] = 'Home';
    $urlArray['action'] = 'index';
}

// Mostramos las rutas
// echo '<pre>';
// print_r($urlArray) . '<br>';
// echo '</pre>';

if ($router->matchRoute($urlArray)) {
    $method = $_SERVER['REQUEST_METHOD'];

    // Define los parámetros según el método HTTP
    $params = [];

    if ($method === 'GET') {
        $params[] = intval($urlArray['params']) ?? null;
    } elseif ($method === 'POST') {
        $json = file_get_contents('php://input');
        $params[] = json_decode($json, true);
    } elseif ($method === 'PUT') {
        $id = intval($urlArray['params']) ?? null;
        $json = file_get_contents('php://input');
        $params[] = $id;
        $params[] = json_decode($json, true);
    } elseif ($method === 'DELETE') {
        $params[] = intval($urlArray['params']) ?? null;
    }

    $controller = $router->getParams()['controller'];
    $action = $router->getParams()['action'];
    $controller = new $controller();

    if (method_exists($controller, $action)) {
        $resp = call_user_func_array([$controller, $action], $params);
    } else {
        echo "El método no existe";
    }
} else {
    echo "No route found for URL " . $url;
}
