function getCoins() {
    $.get("/api/user/getCoins.php",
        function(data, status){
            if (data == "auth error") {
                clearInterval(coinsInterval);
            } else {
                setCoins(data);
            }
        });
}

let coinsInterval = setInterval(getCoins, 100);
let coins = document.getElementById('coinsCount');
function setCoins(i) {
    coins.innerHTML = i;
}