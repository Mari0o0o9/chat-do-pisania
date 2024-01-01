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