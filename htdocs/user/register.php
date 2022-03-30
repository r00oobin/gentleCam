<?php


include "../header/header.php";
include "../header/bodyHeader.php";
if ($isLoggedIn) {
    echo "already logged in";
    return;
}
//$logController->log($_SERVER['REMOTE_ADDR'], "page view", "/register", "");

?>
<h1>Register</h1>
    <form action="/api/user/create.php" method="post">
        <div>
            <label>Username:</label>
            <input name="username" type="text" required>
        </div>
        <div>
            <label>Email:</label>
            <input name="email" type="text" required>
        </div>
        <div>
            <label>Password</label>
            <input name="password" type="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
        </div>
        <div>
            <label>Confirm Password</label>
            <input name="password2" type="password" required>
        </div>
        <div>
            <input type="checkbox" required>
            <label>I am 18</label>
        </div>
        <div>
            <input type="checkbox" required>
            <label>I have read and accept our geschäftsbedigungengsdingsbums</label>
        </div>
        <div>
            <input type="submit">
        </div>
    </form>
<?php

include "../footer/bodyFooter.php";
include "../footer/footer.php";