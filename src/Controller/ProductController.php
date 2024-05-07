<?php

require_once '../Model/Product.php';

class ProductController
{
    public function getProducts()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $productModel = new Product();
        $result = $productModel->getAll();

        require_once '../View/main.php';
    }
}

?>