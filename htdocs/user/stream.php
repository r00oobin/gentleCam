<?php
//$logController->log($_SERVER['REMOTE_ADDR'], "page view streamer", "/" . $streamer->getUsername(), "online", $userController->getUser());

?>
<div class="viewerCount">
    <div id="viewersCount">0</div>
</div>
<div class="streamBox">
     <video id="stream" class="video-js vjs-fluid vjs-default-skin" controls autoplay preload="auto"
           data-setup='{}'>
        <source src="https://gentlecam.com/stream/hls/<?php echo $streamer->getStreamKey(); ?>.m3u8" type="application/x-mpegURL">
    </video>
    <div class="chatBox">
        <div id="chat" class="chatDiv">
        </div>
        <div class="input">
            <input type="text" id="chatInputField">
            <input type="submit" value="Send" id="chatSubmit">
        </div>
        <div class="actions">
            <input type="number" id="tips">
            <button onclick="sendTip('tip', document.getElementById('tips').value)">Tip</button>
            <?php
            foreach ($streamer->getActions() as $action) {
                echo '<button type="button" onclick="sendMessage(' . "'" . $action->getName() . "', " . $action->getCoins() . ')">' . $action->getName() . ' ' .  $action->getCoins() . '</button>';
            }
            ?>
        </div>
    </div>
</div>
<script>
    var player = videojs('my_video_1');
    player.play();
</script>