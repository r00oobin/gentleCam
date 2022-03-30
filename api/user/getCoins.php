<?php


include "/var/www/html/require.php";

$userController = new \obj\controller\UserController();

$user = $userController->getUser();
if ($user == null) {
    echo "auth error";
    return;
}

echo $user->getCoins();
return;



