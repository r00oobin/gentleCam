<?php

include "/var/www/html/require.php";

$username = null;
$email = null;
$password = null;
$password2 = null;

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    if (strlen($username) < 4) {
        echo "username to short";
        return;
    }
} else {
    echo "username not set";
    return;
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
} else {
    echo "email not set";
    return;
}

if (isset($_POST['password'])) {
    $password = $_POST['password'];
} else {
    echo "password not set";
    return;
}

$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);

if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
    echo "weak password";
    return;
}

if (isset($_POST['password2'])) {
    $password2 = $_POST['password2'];
} else {
    return "confirm password not set";
}

if ($password != $password2) {
    echo "password doesnt match";
    return;
}

$userController = new \obj\controller\UserController();
$response = $userController->register($username, $email, $password);
if ($response) {
    echo$response;
} else {
    header('Location: /login');
    return;
}
