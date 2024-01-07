

function swap() {
    var swap1 = document.getElementById('switch1')
    var swap2 = document.getElementById('switch2')
    var login = document.getElementById('login')
    var register = document.getElementById('register')

    swap1.addEventListener('click', ()=> {
        login.style.display = 'none'
        register.style.display = 'block'
    })
    swap2.addEventListener('click', ()=> {
        login.style.display = 'block'
        register.style.display = 'none'
    })
}
swap()

function login() {
    var login = document.getElementById('emailLog').value
    var pass1 = document.getElementById('passLog').value
}

function register() {
    var name = document.getElementById('name').value
    var email = document.getElementById('email').value
    var pass = document.getElementById('pass1').value
    var passConfirm = docum.getElementById('pass2').value

    if (pass !== passConfirm) {
        alert('Hasła nie są takie same')
        return
    }
}
register()