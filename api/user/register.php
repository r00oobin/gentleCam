<?php

include "/var/www/html/require.php";

$username = null;
$email = null;
$password = null;
$password2 = null;

if (isset($_POST['username'])) {
    $username = $_POST['username'];
} else {
    return "error";
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
} else {
    return "error";
}

if (isset($_POST['password'])) {
    $password = $_POST['password'];
} else {
    return "error";
}

if (isset($_POST['password2'])) {
    $password2 = $_POST['password2'];
} else {
    return "error";
}

if ($password != $password2) {
    return "error";
}

$userController = new \obj\controller\UserController();

if ($userController->register($username, $email, $password)) {
    echo "ok";
} else {
    echo "error";
}