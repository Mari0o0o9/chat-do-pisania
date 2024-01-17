function sendMessage() {
    var send = document.getElementById('send')
    var text = document.getElementById('text')
    var chat = document.getElementById('chat')
    
    send.addEventListener('click', ()=> {
        if (text.value == '') { 
            return 0
        }
        else {
            var message = document.createElement('div')
            message.classList.add('message', 'my-message')
            message.textContent = text.value
            chat.appendChild(message)
            text.value = ''
        }
    })
    document.addEventListener('keydown', event => {
        if (event.key == 'Enter') {
            send.click()
        }
    })
}
sendMessage();

function logout() {
    var logoutButton = document.getElementById('logout');
    logoutButton.addEventListener('click', ()=> {
        document.cookie = 'login' + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;"; //data skopiowana 
    })
}
logout();