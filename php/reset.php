<?php 
    session_start();
    $conn = new mysqli("localhost", "root", "", "mydb");
    if ($conn -> connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn -> connect_error);
    }

    function changePassword() {
        global $conn;
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        }
        else {
            $email = $_POST['email'];
            $pass1 = $_POST['pass1'];
            $pass2 = $_POST['pass2'];

            $sql = "SELECT * 
                    FROM users
                    WHERE email = '$email'";
            $result = $conn -> query($sql);

            if ($result -> num_rows == 0) {
                echo "Nie prawidłowy Email!!!";
            }
            elseif ($pass1 !== $pass2) {
                echo "Hasła nie są takie same!!!";
            }
            else {
                $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);
                $sql = "UPDATE users 
                        SET password = '$hashed_password' 
                        WHERE email = '$email'";
                $conn -> query($sql);

                echo "Zmieniono Hasło pomyślnie!!!";
                header("refresh:2;url=login.php");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="../css/styleLogin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="shortcut icon" href="../zdjecia/favicon.ico" type="image/x-icon">
</head>
<body>
    <div id="login">
        <h1>Zmiana Hasła:</h1>
        <a href="./login.php">
            <button id="switch1">
                Logowanie =>
            </button>
        </a>
        <form id="myFormLogin" method="post"> 
            <p>
                <label for="loginName" class="material-symbols-outlined">
                    face
                </label>
                <input type="text" id="loginName" placeholder="Podaj Email..." required name="email">
            </p>
            <p>
                <label for="pass1" class="material-symbols-outlined passVis">
                    password
                </label>
                <input type="password" id="pass1" placeholder="Podaj Hasło..." minlength="12" required name="pass1" class="pass">
                <span class="material-symbols-outlined visPass">
                    visibility_off
                </span>
            </p>
            <p>
                <label for="pass2" class="material-symbols-outlined passVis">
                    password
                </label>
                <input type="password" id="pass2" placeholder="Powtórz Hasło..." minlength="12" required name="pass2" class="pass">
                <span class="material-symbols-outlined visPass">
                    visibility_off
                </span>
            </p>
            <p>
                <input type="submit" value="Zmień Hasło">
            </p>
        </form>
        <p class="wynik"><?=changePassword();?></p>
    </div>
</body>
<script src="../JavaScript/password.js"></script>
</html>
<?php
$conn -> close();
?>