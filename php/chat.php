<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "mydb");
    if ($conn -> connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn -> connect_error);
    }

    if ($_COOKIE['login'] == null) {
        header("Location: login.php");
    }

    function friendList() {
        global $conn;
        $login = $_COOKIE['login'];
        
        $sql = "SELECT friend_login
                FROM friends
                WHERE user_login = '$login'";

        $result = $conn -> query($sql);

        while ($row = $result -> fetch_array()) {
            echo "<li>$row[friend_login]</li>";
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleChat.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="shortcut icon" href="../zdjecia/favicon.ico" type="image/x-icon">
    <title>Chat</title>
</head>
<body>
    <nav>
        <div id="account">
            <h2>Witaj, <?=$_COOKIE['login']?>!!!</h2>
            <a href="./changeAccount.php">
                <span class="material-symbols-outlined">
                settings
                </span>
            </a>
        </div>
        <h3>Czaty:</h3>
        <input type="text" name="" id="" placeholder="Szukaj...">
        <div id="friendList">
            <ul>
                <?= friendList();?>
            </ul>
        </div>
    </nav>
    <main>
        <header>
            Osoba z która piszesz :D
        </header>
        <section id="chat">
            <div class="message other-message">   
                wqewqewquegqwe   
            </div>
            <div class="message my-message">
                sajkdsksadsadasdasdasasadasdsdasda
            </div>
            <div class="message other-message">
                sajkdsksadsadasdasdasasadasdsdasda
            </div>
        </section>
        <footer>
            <input type="text" id="text" placeholder="Napisz wiadomość...">
            <button id="send" class="material-symbols-outlined">
                send
            </button>
        </footer>
    </main>
</body>
<script src="../JavaScript/chat.js"></script>
</html>
<?php
    $conn -> close(); 
?>