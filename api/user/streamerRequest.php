<?php

include "/var/www/html/require.php";

$userController = new \obj\controller\UserController();
$db = new \obj\controller\Database();
$user = $userController->getUser();
if ($user == null) {
    echo "not logged in";
    return;
}

$db->createNewStreamerRequest($user->getId());
