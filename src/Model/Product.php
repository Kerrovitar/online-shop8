<?php

class Product
{
    public function getAll() {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=dbname", 'dbuser', 'dbpwd');
        $stmt = $pdo->query("SELECT * FROM products");
        $result = $stmt->fetchAll();
        return $result;
    }
}