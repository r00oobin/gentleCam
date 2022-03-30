<?php

include "/var/www/html/require.php";

$userController = new \obj\controller\UserController();
$logController = new \obj\controller\LogController();
$streamController = new \obj\controller\StreamController();
$isLoggedIn = ($userController->getUser() != null);
$db = new \obj\controller\Database();

$streamer = (isset($_GET['username'])) ? $_GET['username'] : false;

if ($streamer) {
    $streamer = $streamController->getStream($streamer);
    if (!$streamer) {
        $logController->log($_SERVER['REMOTE_ADDR'], "no user", "/user", $streamer, $userController->getUser());
        header('Location: /404');
        return;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GentleCam</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css">

    <link href="https://unpkg.com/video.js/dist/video-js.css" rel="stylesheet">
    <script src="https://unpkg.com/video.js/dist/video.js"></script>
    <script src="https://unpkg.com/videojs-contrib-hls/dist/videojs-contrib-hls.js"></script>

    <script>
        // data
        <?php
        if ($isLoggedIn) {
        ?>
        var user = {
            "id": "<?php echo $userController->getUser()->getId(); ?>",
            "username": "<?php echo $userController->getUser()->getUsername(); ?>",
            "email": "<?php echo $userController->getUser()->getEmail(); ?>",
            "coins": "<?php echo $userController->getUser()->getCoins(); ?>",
            "lastlogging": "<?php echo $userController->getUser()->getLastLogging(); ?>",
            "created": "<?php echo $userController->getUser()->getCreated(); ?>",
            "role": "<?php echo $userController->getUser()->getRole(); ?>",
            "ban": "<?php echo $userController->getUser()->getBan(); ?>",
            "birthday": "<?php echo $userController->getUser()->getBirthday(); ?>",
            "descirption": "<?php echo $userController->getUser()->getDescription(); ?>",
            "sex": "<?php echo $userController->getUser()->getSex(); ?>",
            "height": "<?php echo $userController->getUser()->getHeight(); ?>",
            "weight": "<?php echo $userController->getUser()->getWeight(); ?>",
            "skincolor": "<?php echo $userController->getUser()->getSkinColor(); ?>",
            "haircolor": "<?php echo $userController->getUser()->getHairColor(); ?>",
            "online": "<?php echo $userController->getUser()->isOnline(); ?>"
        };
        <?php
        }
        if ($streamer) {
            ?>
        var streamer = {
            "id": "<?php echo $streamer->getId(); ?>",
            "username": "<?php echo $streamer->getUsername(); ?>",
            "email": "<?php echo $streamer->getEmail(); ?>",
            "coins": "<?php echo $streamer->getCoins(); ?>",
            "lastlogging": "<?php echo $streamer->getLastLogging(); ?>",
            "created": "<?php echo $streamer->getCreated(); ?>",
            "role": "<?php echo $streamer->getRole(); ?>",
            "ban": "<?php echo $streamer->getBan(); ?>",
            "birthday": "<?php echo $streamer->getBirthday(); ?>",
            "descirption": "<?php echo $streamer->getDescription(); ?>",
            "sex": "<?php echo $streamer->getSex(); ?>",
            "height": "<?php echo $streamer->getHeight(); ?>",
            "weight": "<?php echo $streamer->getWeight(); ?>",
            "skincolor": "<?php echo $streamer->getSkinColor(); ?>",
            "haircolor": "<?php echo $streamer->getHairColor(); ?>",
            "online": "<?php echo $streamer->isOnline(); ?>"
        }

        <?php
        }

        ?>
    </script>
</head>