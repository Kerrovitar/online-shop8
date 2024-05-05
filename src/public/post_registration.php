<?php

//print_r($_POST);
$pdo = new PDO("pgsql:host=db; port=5432; dbname=dbname", 'dbuser', 'dbpwd');

if(isset($_POST['name'])) {
    $name = $_POST['name'];
}
if(isset($_POST['email'])) {
    $email = $_POST['email'];
}
if(isset($_POST['psw'])) {
    $password = $_POST['psw'];
}
if(isset($_POST['psw-repeat'])) {
    $passwordConfirmation = $_POST['psw-repeat'];
}
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$errors = [];

if (ucfirst($name) !== $name) {
    $errors['name'] = 'Имя должно начинаться с заглавной буквы';
}
if (strlen($name) < 3) {
    $errors['name'] = 'Короткое имя';
}
if (!preg_match("/^[a-zA-Z\s'-]+$/", $name)) {
    $errors['name'] = 'Имя может содержать только буквы, пробелы, дефисы и апострофы';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Неверно указана почта';
}
if (!preg_match("/^(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}$/", $password)) {
    $errors['password'] = 'Пароль должен содержать как минимум одну заглавную букву, одну цифру и один специальный символ';
}
if (!password_verify($passwordConfirmation, $hashedPassword)) {
    $errors['psw-repeat'] = 'Пароли не совпадают';
}

if (empty($errors)) {
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashedPassword]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch();
    //print_r($result);
}

require_once './get_login.php';
?>