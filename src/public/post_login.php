<?php

$email = $_POST['email'];
$password = $_POST['psw'];
$errors =[];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Неверно указан логин';
}
if (!preg_match("/^(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}$/", $password)) {
    $errors['password'] = 'Пароль должен содержать как минимум одну заглавную букву, одну цифру и один специальный символ';
}

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=dbname", 'dbuser', 'dbpwd');

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    if (password_verify($password, $user['password'])) {
        echo 'yes';
    } else {
        echo 'no';
    }
}

?>