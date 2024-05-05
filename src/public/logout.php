<?php

session_start();
unset($_SESSION['user_id']);

require_once "./get_login.php";
?>