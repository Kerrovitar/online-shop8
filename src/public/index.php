<?php

$requestUri = $_SERVER['REQUEST_URI'];

if($requestUri === 'login') {
    require_once './get_login.php';
} elseif($requestUri === 'registration') {
    require_once './get_registration.php';
} else {
    require_once './404.php';
}

?>
