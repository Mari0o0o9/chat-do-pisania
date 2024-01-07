<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleLogin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Login</title>
</head>
<body>
    <div id="login">
        <h1>Logowanie:</h1>
        <button id="switch1">
            Rejestracja
        </button>
        <form id="myFormLogin"> 
            <p>
                <label for="emailLog" class="material-symbols-outlined">
                    alternate_email
                </label>
                <input type="email" id="emailLog" placeholder="Podaj Email..." required> 
            </p>
            <p>
                <label for="passLog" class="material-symbols-outlined">
                    password
                </label>
                <input type="password" id="passLog" placeholder="Podaj Hasło..." required>
            </p>
            <p>
                <input type="submit" value="Logowanie">
            </p>
        </form>
    </div>
    <div id="register">
        <h1>Rejestracja:</h1>
        <button id="switch2">
            Logowanie
        </button> 
        <form id="myFormRegister">
            <p>
                <label for="name" class="material-symbols-outlined">
                    face
                </label>
                <input type="text" id="name" placeholder="Podaj Login..." pattern="[^-\s]+" minlength="4" title="Proszę wprowadzić login bez myślników i spacji" required>
            </p>
            <p>
                <label for="email" class="material-symbols-outlined">
                    alternate_email
                </label>
                <input type="email" id="email" placeholder="Podaj Email..." required> 
            </p>
            <p>
                <label for="pass1" class="material-symbols-outlined">
                    password
                </label>
                <input type="password" id="pass1" placeholder="Podaj Hasło..." minlength="12" required>
            </p>
            <p>
                <label for="pass2" class="material-symbols-outlined">
                    password
                </label>
                <input type="password" id="pass2" placeholder="Powtórz Hasło..." minlength="12" required> 
            </p>
            <p>
                <input type="submit" value="Rejestracja">
            </p>
        </form>
    </div>
</body>
<script src="../JavaScript/login.js"></script>
</html>