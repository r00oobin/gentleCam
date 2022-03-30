<?php

include "/var/www/html/require.php";

$login = null;
$password = null;

if (isset($_POST['login'])) {
    $login = $_POST['login'];
} else {
    echo "Login not set"; // TODO ERROR
    return;
}

if (isset($_POST['password'])) {
    $password = $_POST['password'];
} else {
    echo "Password not set"; // TODO ERROR
    return;
}


$userController = new \obj\controller\UserController();

$response = $userController->login($login, $password);


if ($response === true) {
    header('Location: /');
    return;
} else {
    echo "Login not correct"; // TODO ERROR
    return;
}