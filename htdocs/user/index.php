<?php

include "../header/header.php";
include "../header/bodyHeader.php";

$date = new DateTime();
$_SESSION['streamOpened'] = $date->format('Y-m-d H:i:s');


if ($streamer->isStreamer()) {
    echo "is streamer<br>";
    if($streamer->isOnline()) {
        echo "<br>online";
        include "stream.php";
    } else {
        echo "<br>offline";
        include "streamer.php";
    }
} else {
    echo "no streamer";
}


?>
<?php

include "../footer/bodyFooter.php";
include "../footer/footer.php";