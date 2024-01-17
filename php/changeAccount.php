<?php 
    session_start();
    $conn = new mysqli("localhost", "root", "", "mydb");
    if ($conn -> connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn -> connect_error);
    }

    function changeAccount() {
        global $conn;
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        }
        else {
            $account = $_COOKIE['login'];
            $login = $_POST['login'];
    
            $pass = $_POST['pass'];
            $pass1 = $_POST['pass1'];
            $pass2 = $_POST['pass2'];
    
            $sql = "SELECT * 
                    FROM users 
                    WHERE login = '$login'";
            $result = $conn->query($sql);
    
            if (isset($login) && $login !== '') {
                if ($result -> num_rows == 1) {
                    return "Taki Login juz istnieje!!!";
                }
                else {
                    $sql = "UPDATE users
                            SET login = '$login'
                            WHERE login = '$account'";
                    $conn -> query($sql);

                    echo "Zmieniono Login Pomyslnie!!!";
                    
                    setcookie('login', $login, time() + 43200, '/');

                    header("refresh:2;url=chat.php");
                    exit();
                }
            }

        
            if ((isset($pass) && $pass !== '') && (isset($pass1) && $pass1 !== '') && (isset($pass2) && $pass2 == '')) {
                $sql = "SELECT * 
                        FROM users
                        WHERE password = '$pass'";
                $result = $conn -> query($sql);

                
                if (($row = $result -> fetch_assoc()) && password_verify($pass, $row['password'])) {
                    if ($pass1 !== $pass2) {
                        echo "Haslo nie Sjest takie same!!!";
                    }
                }
                else {
                    echo "Aktualne hasło nie poprawne!!!";
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Account</title>
    <link rel="stylesheet" href="../css/styleLogin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="shortcut icon" href="../zdjecia/favicon.ico" type="image/x-icon">
</head>
<body>
    <div id="accountSetings">
        <h1>Ustawienia konta:</h1>
        <a href="./chat.php">
            <button id="switch1">
                Wróć =>
            </button>
        </a>
        <form id="myFormLogin" method="post">
            <div class="block">
                <h3>Zmiana Zdjęcia:</h3>
                <p>
                    <label for="file" id="fileLabel">Wybierz zdjęcię</label>
                    <input type="file" name="file" id="file">
                </p>
            </div>
            <div class="block">
                <h3>Zmiana Loginu:</h3>
                <p>
                    <label for="changeLogin" class="material-symbols-outlined">
                        face
                    </label>
                    <input type="text" name="login" id="changeLogin" placeholder="Podaj nowy Login...">
                </p>
            </div>
            <div class="block">
                <h3>Zmiana Hasła:</h3>
                <p>
                    <label for="pass" class="material-symbols-outlined passVis">
                        password
                    </label>
                    <input type="password" id="pass" placeholder="Aktualne Hasło..." minlength="12" name="pass" class="pass">        
                    <span class="material-symbols-outlined visPass">
                        visibility_off
                    </span>
                </p>
                <p>
                    <label for="pass1" class="material-symbols-outlined passVis">
                        password
                    </label>
                    <input type="password" id="pass1" placeholder="Nowe Hasło..." minlength="12" name="pass1" class="pass">
                    <span class="material-symbols-outlined visPass">
                        visibility_off
                    </span>
                </p>
                <p>
                    <label for="pass2" class="material-symbols-outlined passVis">
                        password
                    </label>
                    <input type="password" id="pass2" placeholder="Powtórz Hasło..." minlength="12" name="pass2" class="pass">
                    <span class="material-symbols-outlined visPass">
                        visibility_off
                    </span>
                </p>
            </div> 
            <p>
                <input type="submit" value="Wprowadź zmiany">
            </p>
        </form>
        <p class="wynik"><?=changeAccount();?></p>
    </div>
</body>
<script src="../JavaScript/password.js"></script>
</html>
<?php
$conn -> close();
?>