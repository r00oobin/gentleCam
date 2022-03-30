<?php

include "/var/www/html/require.php";

$userController = new \obj\controller\UserController();

$user = $userController->getUser();
if ($user == null) {
    echo "not logged in";
    return;
}

if (isset($_POST['userId']) && $_POST['userId'] != "") {
    $userId = $_POST['userId'];
} else {
    echo "userId missing";
    return;
}

if ($user->getId() != $userId) {
    echo "auth error";
    return;
}

$actionName = null;
$coins = null;

if (isset($_POST['actionName'])) {
    $actionName = $_POST['actionName'];
} else {
    echo "error";
    return;
}

if (isset($_POST['coins'])) {
    $coins = $_POST['coins'];
} else {
    echo "error";
    return;
}

$db = new \obj\controller\Database();
if ($coins > 0) {
    $db->addAction($userId, $actionName, $coins);
}