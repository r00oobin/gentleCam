<?php


include "./htdocs/header/header.php";
include "./htdocs/header/bodyHeader.php";

$streamController = new \obj\controller\StreamController();

$streams = $streamController->getAllStreams();

echo "streams:<br>";
foreach ($streams as $stream) {

    echo "<a href='/" . $stream->getUsername() . "'><img src='/assets/image/thumbnails/" . $stream->getUsername() . "-440x248.png'></a><br>";
}



include "./htdocs/footer/bodyFooter.php";
include "./htdocs/footer/footer.php";
