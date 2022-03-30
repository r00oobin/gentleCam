<?php

include "/var/www/html/require.php";

$streamUsername = null;

if (isset($_POST['stream'])) {
    $streamUsername = $_POST['stream'];
} else {
    echo "stream not set";
    return;
}

$messageController = new \obj\controller\MessageController();

$messages = $messageController->getMessages($streamUsername);


$streamController = new \obj\controller\StreamController();

$userController = new \obj\controller\UserController();

$stream = $streamController->getStream($streamUsername);

$user = $userController->getUser();
if ($user == null) {
    if (!isset($_SESSION['anonymUsername'])) {
        $_SESSION['anonymUsername'] = 'anonym' . time();
    }
    $streamController->addViewer($_SESSION['anonymUsername'], $stream->getId());
} else {
    $streamController->addViewer($user->getId(), $stream->getId());
}

echo "[";
$i = 1;
foreach ($messages as $message) {
    if ($i == sizeof($messages)) {
        echo '{"username":"' . $message->getUsername() . '","message":"' . $message->getMessage() . '","coins":"' . $message->getCoins() . '"}';
    } else {
        echo '{"username":"' . $message->getUsername() . '","message":"' . $message->getMessage() . '","coins":"' . $message->getCoins() . '"},';
    }
    $i++;
}
echo "]";
