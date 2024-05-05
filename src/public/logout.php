<?php

require_once __DIR__ . "/helpers.php";
//session_destroy();
unset($_SESSION['user_id']);

redirect('/login');
?>