<?php

class User
{
    public function getByEmail(string $email) {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=dbname", 'dbuser', 'dbpwd');

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result;
    }
    public function create(string $name, string $email, string $password) {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=dbname", 'dbuser', 'dbpwd');

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);

    }
}