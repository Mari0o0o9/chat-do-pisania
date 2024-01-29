function chat() {
    var button = document.getElementById('send');

    button.addEventListener('click', ()=> {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('text').innerHTML = this.responseText;
            }
        }

        var message = document.getElementById('text').value;
        // Send POST request to server with message data
        xhr.open("POST", "http://localhost/chat/php/message.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("textSend=" + encodeURIComponent(message));
    });
}
chat();