<?php


include "../header/header.php";
include "../header/bodyHeader.php";

if ($isLoggedIn) {
    echo "already logged in";
    return;
}
//$logController->log($_SERVER['REMOTE_ADDR'], "page view", "/login", "");

?>
    <form action="/api/user/login.php" method="post">
        <div>
            <label>Login:</label>
            <input name="login" type="text">
        </div>
        <div>
            <label>Password</label>
            <input name="password" type="password">
        </div>
        <div>
            <input type="submit">
        </div>
    </form>
<?php

include "../footer/bodyFooter.php";
include "../footer/footer.php";