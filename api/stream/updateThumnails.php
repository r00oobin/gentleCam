<?php

include "/var/www/html/require.php";

$streamController = new \obj\controller\StreamController();

$streams = $streamController->getAllStreams();

if (isset($_POST['stream'])) {
    foreach ($streams as $stream) {
        if ($stream->getUsername() == $_POST['stream']) {
            exec('ffmpeg -y -i rtmp://202.61.248.90/live/' . $stream->getStreamKey() . ' -ss 00:00:01 -vframes 1 -vf scale=440:248 ../../assets/image/thumbnails/' . $stream->getUsername() . '-440x248.png;');
            echo "ok " . $stream->getUsername();
            return;
        }
    }
    echo "error";
} else {
    foreach ($streams as $stream) {
        exec('ffmpeg -y -i rtmp://202.61.248.90/live/' . $stream->getStreamKey() . ' -ss 00:00:01 -timeout 5 -vframes 1 -vf scale=440:248 ../../assets/image/thumbnails/' . $stream->getUsername() . '-440x248.png;');
    }
    echo "ok all";
}



