let chatBox = document.getElementById('chat');
function getMessages() {
    $.post("/api/message/",
        {
            stream: streamer.username
        },
        function(data, status){
        data = JSON.parse(data);
        for (let i = 0; i < data.length; i++) {
            addChatMessage(data[i]);
        }
        });
}

let chat = setInterval(getMessages, 100);
function addChatMessage(message) {
    let messageDiv = document.createElement('div');
    messageDiv.classList.add("messageDiv");
    let username = document.createElement('a');
    username.classList.add('usernameLink');
    username.innerHTML = message.username;
    username.href = "/" + message.username;
    let messageText = document.createElement('div');
    messageText.innerHTML = message.message;
    messageText.classList.add("messageText");
    messageDiv.append(username);
    messageDiv.append(messageText);
    if (message.coins > 0) {
        let messageAmount = document.createElement('div');
        messageAmount.classList.add('messageAmount');
        messageAmount.innerHTML = message.coins;
        messageDiv.append(messageAmount);
    }


    chatBox.append(messageDiv);
}
function sendMessage(message, coins) {
    $.post("/api/message/send.php",
    {
        userId: user.id,
        streamer: streamer.username,
        message: message,
        coins: coins
    });
}

function sendTip(message, coins) {
    document.getElementById('tips').value = "";
    sendMessage(message, coins);
}

let chatInputField = document.getElementById('chatInputField');
let chatSubmit = document.getElementById('chatSubmit');

chatSubmit.onclick = function(){
    sendMessage(chatInputField.value, 0);
    chatInputField.value = "";
};

chatInputField.addEventListener("keyup", function(event) {
    // Number 13 is the "Enter" key on the keyboard
    if (event.keyCode === 13) {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        chatSubmit.click();
    }
});