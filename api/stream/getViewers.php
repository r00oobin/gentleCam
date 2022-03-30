<?php

include "/var/www/html/require.php";

$streamController = new \obj\controller\StreamController();


if (isset($_POST['stream'])) {
    $stream = $streamController->getStream($_POST['stream']);
    if ($stream) {
        echo sizeof($streamController->getViewers($stream->getId()));
    } else {
        echo "error";
    }
} else {
    echo "error";
}



