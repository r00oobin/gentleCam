function getViewers() {
    $.post("/api/stream/getViewers.php",
        {
            stream: streamer.username
        },
        function(data, status){
        if (data !== "error") {
            setViewers(data);
        }
        });
}

let viewerInterval = setInterval(getViewers, 100);
let viewersCount = document.getElementById('viewersCount');
function setViewers(i) {
    viewersCount.innerHTML = i;
}