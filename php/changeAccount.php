<?php 
    session_start();
    $conn = new mysqli("localhost", "root", "", "mydb");
    if ($conn -> connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn -> connect_error);
    }

    if ($_COOKIE['login'] == null && $_COOKIE['ID'] == null) {
        header("Location: login.php");
    }

    function changeLogin() {
        global $conn;
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        }
        else {
            $account = $_COOKIE['login'];
            $login = $_POST['login'];
    
            $sql = "SELECT * 
                    FROM users 
                    WHERE login = '$login'";
            $result = $conn -> query($sql);
    
            if (isset($login) && $login !== '') {
                if ($result -> num_rows == 1) {
                    echo "Taki Login juz istnieje!!!";
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
        }
    }
    function changePass() {
        global $conn;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        }
        else {
            $account = $_COOKIE['login'];

            $pass = $_POST['pass'];
            $pass1 = $_POST['pass1'];
            $pass2 = $_POST['pass2'];

            if ((isset($pass) && $pass !== '') && (isset($pass1) && $pass1 !== '') && (isset($pass2) && $pass2 !== '')) {
                $sql2 = "SELECT *
                        FROM users
                        WHERE login = '$account'";
                $result2 = $conn -> query($sql2);
                
                if (($row = $result2 -> fetch_assoc()) && password_verify($pass, $row['password'])) {
                    if ($pass1 !== $pass2) {
                        echo "Podane Nowe Hasła nie są takie same!!!";
                    }
                    else {
                        $hashedPwd = password_hash($pass1, PASSWORD_DEFAULT);
                        $sql_update = " UPDATE users
                                        SET password = '$hashedPwd'
                                        WHERE login = '$account'";
                        $conn -> query($sql_update);

                        echo "Zaktualizowano Hasło pomyślnie!!!";
                        header('refresh:2;url=chat.php');
                        exit();
                    }
                }
                else {
                    echo "Aktualne Hasło jest nie poprawne!!!";
                }
            }
        }
    }
    
    function changeEmail() {
        global $conn;
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        }
        else {
            $account = $_COOKIE['login'];
            $email = $_POST['email'];
    
            $sql = "SELECT * 
                    FROM users 
                    WHERE email = '$email'";
            $result = $conn -> query($sql);
    
            if (isset($email) && $email !== '') {
                if ($result -> num_rows == 1) {
                    echo "Taki Email juz istnieje!!!";
                }
                else {
                    $sql = "UPDATE users
                            SET email = '$email'
                            WHERE login = '$account'";
                    $conn -> query($sql);

                    echo "Zmieniono Email Pomyslnie!!!";

                    header("refresh:2;url=chat.php");
                    exit();
                }
            }
        }
    }

    function imgProfil() {
        global $conn;

        $user_id = $_COOKIE['ID'];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        }
        else {
            $target_dir = "profil/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_name = uniqid() . '_' . basename($_FILES["file"]["name"]);
            $target_file = $target_dir . $file_name;


            if (!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                // echo "Wystąpił błąd podczas przesyłania pliku!!!";
                return null;
            } 
        

            $check_sql = "SELECT * 
                        FROM images 
                        WHERE user_id = '$user_id'";
            $check_result = $conn -> query($check_sql);

            if ($check_result -> num_rows > 0) {
                $old_file_name = $check_result -> fetch_assoc()['file_path'];
                $old_file_path = $target_dir . $old_file_name;
                unlink($old_file_path);

                $update_sql = "UPDATE images 
                                SET file_path = '$file_name' 
                                WHERE user_id = '$user_id'";
                $conn -> query($update_sql);
    
                echo "Zdjęcie profilowe zostało zaktualizowane!!!";
                header("refresh:2;url=chat.php");
            } 
            else {
                $insert_sql = "INSERT INTO images (file_path, user_id) 
                                VALUES ('$file_name', '$user_id')";
                $conn -> query($insert_sql);
    
                echo "Zdjęcie profilowe zostało przesłane!!!";
                header("refresh:2;url=chat.php");
            }
        }
    }

    function profilImg() {
        global $conn;

        $user_id = $_COOKIE['ID'];

        $sql = "SELECT file_path 
                FROM images 
                WHERE user_id = '$user_id'";
        $result = $conn -> query($sql);

        if ($result -> num_rows > 0) {
            $imgRow = $result -> fetch_assoc()['file_path'];

            echo "<img src='./profil/$imgRow' alt='Profilowe zdjęcie' class='profil'>";
        }
        else {
            echo "<img src='./profil/user.png' alt='Profilowe zdjęcie' class='profil'>";
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
<body id="changeAccount">
    <div id="account">
        <h1>Dane Konta:</h1>
        <div class="block">
            <h3>Zdjęcie</h3>
            <p>
                <?= profilImg();?>
            </p>
        </div>
        <div class="block">
            <h3>Login</h3>
            <p>
                <?= $_COOKIE['login']?>
            </p>
        </div>
        <div class="block">
            <h3>Email</h3>
            <p>
                <?= $_COOKIE['email']?>
            </p>
        </div>
    </div>

    <div id="accountSetings">
        <h1>Ustawienia konta:</h1>
        <a href="./chat.php">
            <button id="switch1">
                Wróć
            </button>
        </a>
        <form id="myFormLogin" method="post" enctype="multipart/form-data">
            <div class="block">
                <h3>Zmiana Zdjęcia:</h3>
                <p>
                    <label for="file" id="fileLabel">Wybierz zdjęcię</label>
                    <input type="file" name="file" id="file">
                    <p id="fileName"></p>
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
                <h3>Zmiana Emailu:</h3>
                <p>
                    <label for="changeEmail" class="material-symbols-outlined">
                        alternate_email
                    </label>
                    <input type="email" name="email" id="changeEmail" placeholder="Podaj nowy Email...">
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
                        visibility
                    </span>
                </p>
                <p>
                    <label for="pass1" class="material-symbols-outlined passVis">
                        password
                    </label>
                    <input type="password" id="pass1" placeholder="Nowe Hasło..." minlength="12" name="pass1" class="pass">
                    <span class="material-symbols-outlined visPass">
                        visibility
                    </span>
                </p>
                <p>
                    <label for="pass2" class="material-symbols-outlined passVis">
                        password
                    </label>
                    <input type="password" id="pass2" placeholder="Powtórz Hasło..." minlength="12" name="pass2" class="pass">
                    <span class="material-symbols-outlined visPass">
                        visibility
                    </span>
                </p>
            </div> 
            <p>
                <input type="submit" value="Wprowadź zmiany">
            </p>
        </form>
        <p class="wynik">
        <?php 
            changeLogin();
            changePass();
            imgProfil();
            changeEmail();
        ?>
        </p>
    </div>
</body>
<script src="../JavaScript/password.js"></script>
<script src="../JavaScript/file.js"></script>
</html>
<?php
$conn -> close();
?>