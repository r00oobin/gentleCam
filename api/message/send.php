<?php


include "/var/www/html/require.php";

$streamUserId = null;
$message = null;
$coins = null;
$userId = null;
$created = time();



if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];
} else {
    echo "userid missing";
    return;
}

if (isset($_POST['streamer'])) {
    $streamUserId = $_POST['streamer'];
} else {
    echo "streamer missing";
    return;
}

if (isset($_POST['message'])) {
    $message = $_POST['message'];
} else {
    echo "message missing";
    return;
}

if (isset($_POST['coins'])) {
    $coins = $_POST['coins'];
} else {
    echo "coins missing";
    return;
}

$userController = new \obj\controller\UserController();

$messageController = new \obj\controller\MessageController();



$db = new \obj\controller\Database();
$streamer = $db->getUserByUsername($streamUserId);
if (!$streamer) {
    echo "streamer error";
    return;
}


$streamUserId = $streamer->getId();

if ($userController->getUser() == null) {
    echo "not logged in";
    return;
}
if ($userController->getUser()->getId() != $userId) {
    echo "auth error";
    return;
}
if ($message != "") {
    $message = new \obj\elm\Message(null, $userId, null, $streamUserId, null, null, $message, $coins);


    //$logController->log($_SERVER['REMOTE_ADDR'], "message send", "/", "userId:" . $userId . " - streamerId: " . $streamUserId . " - message: " . $message->getMessage() . " - coins: " . $coins, $userController->getUser());

    if ($messageController->messageTransfer($message)) {
        echo "ok";
    } else {
        echo "error";
    }
}
return;