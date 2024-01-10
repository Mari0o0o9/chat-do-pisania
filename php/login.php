<?php 
    $conn = new mysqli("localhost", "root", "", "mydb");
    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    global $conn;

    function myFormLogin() {
        global $conn;
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        }
        else {
            $login = $_POST['loginName'];
            $pass = $_POST['passLogin'];

            $sql = "SELECT * 
                    FROM users
                    WHERE login = '$login'";
            $result = $conn -> query($sql);

            if (($row = $result -> fetch_assoc()) && password_verify($pass, $row['password'])) {
                echo "Zalogowano pomyślnie!!!";
                header("refresh:3;url=chat.php");
            }
            else {
                echo "Niepoprawny Login lub Hasło!!!";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleLogin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="shortcut icon" href="../zdjecia/favicon.ico" type="image/x-icon">
    <title>Login</title>
</head>
<body>
    <div id="login">
        <h1>Logowanie:</h1>
        <a href="./register.php">
            <button id="switch1">
                Rejestracja =>
            </button>
        </a>
        <form id="myFormLogin" method="post"> 
            <p>
                <label for="loginName" class="material-symbols-outlined">
                    face
                </label>
                <input type="text" id="loginName" placeholder="Podaj Login..." required name="loginName"> 
            </p>
            <p>
                <label for="passLog" class="material-symbols-outlined">
                    password
                </label>
                <input type="password" id="passLog" placeholder="Podaj Hasło..." required name="passLogin">
            </p>
            <p>
                <input type="submit" value="Logowanie">
            </p>
        </form>
        <p class="wynik"><?= myFormLogin()?></p>
    </div>
</body>
</html>
<?php 
$conn -> close()
?>