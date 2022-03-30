$.post("/api/stream/updateThumnails.php",
    {
        stream: streamer.username
    },
    function(data, status){
        console.log(data);
    });