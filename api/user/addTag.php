<?php

include "/var/www/html/require.php";

$userController = new \obj\controller\UserController();

$user = $userController->getUser();
if ($user == null) {
    echo "not logged in";
    return;
}
$userId = $user->getId();

$tagName = null;

if (isset($_GET['tagName'])) {
    $tagName = $_GET['tagName'];
} else {
    echo "error";
    return;
}

$db = new \obj\controller\Database();
$tag = $db->getTag($tagName);
if ($tag != null) {
    $db->addTag($userId, $tag->getId());
}
