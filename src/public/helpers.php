<?php

session_start();
function redirect(string $path)
{
    header("Location: $path");
    exit;
}