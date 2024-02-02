<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../phpMailer-master/src/PHPMailer.php';
require __DIR__ . '/../phpMailer-master/src/Exception.php';
require __DIR__ . '/../phpMailer-master/src/SMTP.php';

session_start();
$conn = new mysqli("localhost", "root", "", "mydb");

if ($conn -> connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn -> connect_error);
}

function sendEmail() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null;
    } 
    else {
        $email = $_POST['email'];

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn -> query($sql);

        if ($result -> num_rows == 0) {
            return "Nieprawidłowy Email!!!";
        } 
        else {
            $mail = new PHPMailer(true);
            try {
                $mail -> SMTPDebug = 0; 
                $mail -> isSMTP();
                $mail -> Host = "localhost"; 
                $mail -> Port = 25; 

                $mail -> setFrom("noreply@example.com", "Example");
                $mail -> addAddress($email);

                $mail -> isHTML(true);
                $mail -> Subject = "Zmiana hasła!!!";
                $mail -> Body = "Link do zmiany hasła: http://localhost/chat/php/changePassword.php";

                $mail -> send();

                return "Email został wysłany pomyślnie!!!";
            } 
            catch (Exception $e) {
                return "Wystąpił problem podczas wysyłania e-maila: " . $mail -> ErrorInfo;
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
                Logowanie
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
                <input type="submit" value="Zmień Hasło">
            </p>
        </form>
        <p class="wynik"><?=sendEmail();?></p>
    </div>
</body>
<script src="../JavaScript/password.js"></script>
</html>
<?php
$conn -> close();
?>