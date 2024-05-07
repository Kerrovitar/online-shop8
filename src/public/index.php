<?php

require_once '../Controller/UserController.php';
require_once '../Controller/ProductController.php';
require_once '../Model/Product.php';
require_once '../Model/User.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if($requestUri === '/login') {
    if($requestMethod === 'GET') {
        $userController = new UserController();
        $userController->getLogin();
    } elseif($requestMethod === 'POST') {
        $userController = new UserController();
        $userController->login();
    } else {
        echo "Для адреса $requestUri метод $requestMethod не поддерживается";
    }
} elseif($requestUri === '/registration') {
    if($requestMethod === 'GET') {
        $userController = new UserController();
        $userController->get_registrate();
    } elseif($requestMethod === 'POST') {
        $userController = new UserController();
        $userController->registrate();
    } else {
        echo "Для адреса $requestUri метод $requestMethod не поддерживается";
    }
} elseif($requestUri === '/main') {
    if($requestMethod === 'GET') {
        $productController = new ProductController();
        $productController->getProducts();
    } else {
        echo "Для адреса $requestUri метод $requestMethod не поддерживается";
    }
} elseif($requestUri === '/logout') {
    $userController = new UserController();
    $userController->logout();
} else {
    require_once './../View/404.php';
}

?>

