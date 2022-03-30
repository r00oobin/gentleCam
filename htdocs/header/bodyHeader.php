<body>
<?php
echo '<a href="/">Home</a> ';
echo '<a href="https://shop.gentlecam.com">Shop</a> ';
if ($isLoggedIn) {
    echo '<a href="/settings">settings</a> ';
    echo '<a href="/logout">Logout</a> ';
} else {
    echo '<a href="/login">Login</a> ';
    echo '<a href="/register">Register</a> ';
}

if ($isLoggedIn) {
    echo "Coins: <div id='coinsCount'>" . $userController->getUser()->getCoins() . "</div>";
}
?>

<br><br>
