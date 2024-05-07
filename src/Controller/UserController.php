<?php

require_once '../Model/Product.php';
require_once '../Model/User.php';

class UserController
{
    public function registrate() {
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
            $errors['name'] = 'Имя должно быть более 3 символов';
        }
        if (strlen($email) < 3) {
            $errors['email'] = 'Email должно быть более 3 символов';
        } else {
            $userModel = new User();
            $result = $userModel->getByEmail($email);
            if (!empty($result)) {
                $errors['email'] = 'email уже занят';
            }
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
            $userModel = new User();
            $userModel->create($name, $email, $password);
            $result = $userModel->getByEmail($email);
            header("Location: /login");
        }

        require_once '../View/get_registration.php';
    }
    public function login() {
        if(isset($_POST['email'])) {
            $email = $_POST['email'];
        }
        if(isset($_POST['psw'])) {
            $password = $_POST['psw'];
        }
        $errors_login =[];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors_login['email'] = 'Неверно указан логин';
        }
        if (!preg_match("/^(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}$/", $password)) {
            $errors_login['password'] = 'Пароль должен содержать как минимум одну заглавную букву, одну цифру и один специальный символ';
        }

        if (empty($errors_login)) {
            $userModel = new User();
            $user = $userModel->getByEmail($email);
            if($user === false) {
                $errors_login['email'] = 'пользователя с таким email не существует';
            } else {
                if (password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                } else {
                    $errors_login['password'] = 'пароль указан не верно';
                }
            }
        }
        header("Location: /main");
    }
    public function getLogin() {
        require_once './../View/get_login.php';
    }
    public function get_registrate() {
        require_once './../View/get_registration.php';
    }
    public function logout() {
        //session_destroy();
        unset($_SESSION['user_id']);
        header("Location: /login");
    }
}