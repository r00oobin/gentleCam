<?php

include "/var/www/html/require.php";

$userController = new \obj\controller\UserController();

$user = $userController->getUser();
if ($user == null) {
    echo "not logged in";
    return;
}

$userId = null;

if ($user->getId()) {
    $userId = $user->getId();
} else {
    echo "auth error";
    return;
}

$actionName = null;

if (isset($_GET['actionName'])) {
    $actionName = $_GET['actionName'];
} else {
    echo "error";
    return;
}

$db = new \obj\controller\Database();
$id = $db->getActionsByUserAndName($userId, $actionName);

if ($id != null) {
    $db->removeAction($id);
}
