<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "mydb");
    if ($conn -> connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn -> connect_error);
    }

    function myFormRegister() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null; 
    } 
    else {
        $login = $_POST['login'];
        $email = $_POST['emailReg'];
        $pass1 = $_POST['pass1Reg'];
        $pass2 = $_POST['pass2Reg'];

        $query = "SELECT * 
                FROM users 
                WHERE login = '$login'";
        $result = $conn -> query($query);

        $query2 = "SELECT * 
                FROM users 
                WHERE email = '$email'";
        $result2 = $conn -> query($query2);

        if ($result -> num_rows > 0) {
            echo "Podany Login już istnieje!!!";
        }
        elseif ($result2 -> num_rows > 0) {
            echo "Podany Email juz istnieje!!!";
        } 
        elseif ($pass1 !== $pass2) {
            echo "Hasła nie są podobne!!!";
        } 
        else {
            $hashed_password = password_hash($pass2, PASSWORD_DEFAULT);
   
            $sql = "INSERT INTO users (login, email, password) 
                    VALUES ('$login', '$email', '$hashed_password')";

            if ($conn -> query($sql) === TRUE) {
                $newUserId = $conn -> insert_id;

                setcookie("login", $login, time() + 43200, "/");
                setcookie("ID", $newUserId, time() + 43200, "/");
                setcookie("email", $email, time() + 43200, "/");

                echo 'Zarejestrowano pomyślnie!!!';
                header("refresh:2;url=chat.php");
            }
            else {
                echo "Błąd podczas dodawania użytkownika!!!";
            }  
        }
    } 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleLogin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="shortcut icon" href="../zdjecia/favicon.ico" type="image/x-icon">
    <title>Register</title>
</head>
<body>
    <div id="register">
        <h1>Rejestracja:</h1>
        <a href="./login.php">
            <button id="switch1">
                Logowanie
            </button> 
        </a>
        <form id="myFormRegister" method="post">
            <p>
                <label for="name" class="material-symbols-outlined">
                    face
                </label>
                <input type="text" id="name" placeholder="Podaj Login..." pattern="[^-\s]+" minlength="4" title="Proszę wprowadzić login bez myślników i spacji" required name="login">
            </p>
            <p>
                <label for="email" class="material-symbols-outlined">
                    alternate_email
                </label>
                <input type="email" id="email" placeholder="Podaj Email..." required name="emailReg"> 
            </p>
            <p>
                <label for="pass1" class="material-symbols-outlined passVis">
                    password
                </label>
                <input type="password" id="pass1" placeholder="Podaj Hasło..." minlength="12" required name="pass1Reg" class="pass">
                <span class="material-symbols-outlined visPass">
                    visibility
                </span>
            </p>
            <p>
                <label for="pass2" class="material-symbols-outlined passVis">
                    password
                </label>
                <input type="password" id="pass2" placeholder="Powtórz Hasło..." minlength="12" required name="pass2Reg" class="pass">
                <span class="material-symbols-outlined visPass">
                    visibility
                </span> 
            </p>
            <p>
                <input type="submit" value="Rejestracja">
            </p>
        </form>
        <p class="wynik"><?= myFormRegister()?></p>
    </div>
</body>
<script src="../JavaScript/password.js"></script>
</html>
<?php
$conn -> close();
?>