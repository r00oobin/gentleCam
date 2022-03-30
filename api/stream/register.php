<?php

include "/var/www/html/require.php";

$userController = new \obj\controller\UserController();

$user = $userController->getUser();
if ($user == null) {
    echo "not logged in";
    return;
}

$db = new \obj\controller\Database();